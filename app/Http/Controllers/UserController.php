<?php

namespace App\Http\Controllers;

use App\Project;
use App\Slb;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $test1 = new VariablesController();
        $stts = $test1::$stts;
        $currentSlb = $test1::timeSet()['slb'];
        $alrt = MysqlRequests::programm()['alrt'];
        $y = $test1::timeSet()['now'];
        $days = $test1::$days;
        $slba = $test1::$slba;
        $months = $test1::$months;
        $dzhapaStatuses = $test1::$dzhapaStatuses;

        $test = new SlbsController();
        $date = $test::statistics()['date'];
        $data = $test::statistics()['date'];
        $weekEndDays = $test::statistics()['weekEndDays'];
        $yogaDays = 7 - $weekEndDays;
        $slbs = $test::statistics()['slbs'];

        for ($i = 0; $i < count($slbs); ++$i) {
            for ($k = 0; $k < count($date); ++$k) {
                $status = Slb::where('data', $date[$k]->format('Y-m-d'))
                    ->where('slba', $slbs[$i])
                    ->where('user_id', $user->id)
                    ->select('stts')
                    ->get()
                    ->toArray();
                if ($status) {
                    $statuses[$i][$k] = $status['0']['stts'];
                    foreach ($stts as $key => $stt) {
                        if ($status['0']['stts'] == $key)
                            $day[$i][$k] = $stt;
                    }
                } else {
                    $day[$i][$k] = 0;
                    $statuses[$i][$k] = '❌';
                }
                $dzhapa = Slb::where('data', $date[$k]->format('Y-m-d'))
                    ->where('slba', 'ДЖ')
                    ->where('user_id', $user->id)
                    ->select('stts')
                    ->get()
                    ->toArray();
                if ($dzhapa) {
                    if (!(int)$dzhapa['0']['stts']) {
                        $statuses[6][$k] = $dzhapa['0']['stts'];
                        foreach ($dzhapaStatuses as $key => $stt) {
                            if ($dzhapa['0']['stts'] == $key) {
                                $day[6][$k] = $stt;
                            }
                        }
                    } else {
                        $day[6][$k] = (int)$dzhapa['0']['stts'];
                        $statuses[6][$k] = (int)$dzhapa['0']['stts'];
                    }
                } else {
                    $day[6][$k] = 0;
                    $statuses[6][$k] = '❌';
                }

                if ($slbs[$i] == 'ЙГ') {
                    if ($yogaDays == 0)
                        $attendance[$i] = '❌';
                    else
                        $attendance[$i] = (int)(array_sum($day[$i]) / $yogaDays * 100);
                } else
                    $attendance[$i] = (int)(array_sum($day[$i]) / 7 * 100);

                $attendance[6] = (int)(array_sum($day[6]) / 16 / 7 * 100);
            }
            $iArray[$i] = $i;
            if ($i == 5)
                $iArray[6] = 6;
        }
        array_multisort($iArray, SORT_ASC, $day);
        array_multisort($iArray, SORT_ASC, $attendance);
        array_multisort($iArray, SORT_ASC, $statuses);

        $ongoingProjects = $user->projects()->where('finished', false)->get();
        foreach ($ongoingProjects as $key => $project) {
            $project->date = (new \DateTime($project->expire_at))->getTimestamp() - (new \DateTime())->getTimestamp();
            if ($project->date > 0)
                $project->day = (new \DateTime($project->expire_at))->diff(new \DateTime())->days;
            else {
                Project::where('id', $project->id)
                    ->update([
                        'finished' => true
                    ]);
                $ongoingProjects->forget($key);
            }
        }

        $doneProjects = $user->projects()->where('finished', true)->get();
        foreach ($doneProjects as $project) {
            $project->date = (new \DateTime($project->expire_at))->getTimestamp() - (new \DateTime())->getTimestamp();
            if ($project->date > 0)
                $project->day = (new \DateTime($project->expire_at))->diff(new \DateTime())->days;
        }

        $daysInAshram = (integer)((new \DateTime("$user->created_at"))->diff(new \DateTime('now'))->days);
        $dzhapa = $user->slbs()->where('slba', 'ДЖ')->select('stts')->get();
        $dzhapaFiltered = $dzhapa->filter(function ($value) {
            return $value->stts > 1;
        });
        foreach ($dzhapaFiltered as $dzhapaFilt) {
            $dzhapaArray[] = $dzhapaFilt->toArray()['stts'];
        }

        if (isset($dzhapaArray))
            $allDzhapa = array_sum($dzhapaArray);
        else
            $allDzhapa = 0;

        if(($y->format('m') < '08') && ($y->format('d') < '26'))
            $yearId = (int)($y->format('y') . '00') - 100;
        else
            $yearId = (int)($y->format('y') . '00');

        for($i = 0; $i < 7; $i++) {
            $services[$i] = $user->services()
                ->where('dateToServe', $data[$i]->modify('+7 day')->format('Y-m-d'))
                ->get();
            if(isset($services[$i][0])) {
                $rules[$i] = DB::table('rules')
                    ->where('id', $services[$i][0]->rule_id)
                    ->select('service', 'description', 'id')
                    ->get()[0];
                $rules[$i]->desc = nl2br($rules[$i]->description);
            }
            else {
                $rules[$i] = 'Свободен';
            }
        }
//dd($rules);
        return view('user.page', compact('user', 'daysInAshram', 'allDzhapa', 'stts', 'currentSlb', 'alrt', 'doneProjects', 'ongoingProjects', 'slba', 'y', 'days', 'months', 'attendance', 'date', 'statuses', 'yearId', 'rules', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(Request $request)
    {
        auth()->user()->update([
            'lastSeen_at' => $request->lastSeen_at
        ]);
        return ['status' => 'lastSeen status updated!'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
