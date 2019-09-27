<?php

namespace App\Http\Controllers;

use App\Slb;
use App\User;
use DateTime;
use Illuminate\Http\Request;

class SlbsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public static function index()
    {
        $now = (new DateTime)->format('Y-m-d');
        $nextDay = (new DateTime())->modify('+1 day')->format('Y-m-d');
        $previousDay = (new DateTime())->modify('-1 day')->format('Y-m-d');

        $test1 = new VariablesController();
        $y = $test1::timeSet()['now'];
        $days = $test1::$days;
        $months = $test1::$months;
        $currentSlb = $test1::timeSet()['slb'];
        $slba = $test1::$slba;
        $stts = $test1::$stts;

        if (request()->has('changeDate')) {
            session()->forget('date');
            request()->session()->put('date', request()->changeDate);
        }

        if (session()->has('date')) {
            $changeDate = session('date');
            $y = new DateTime($changeDate);
            $nextDay = (new DateTime($changeDate))->modify('+1 day')->format('Y-m-d');
            $previousDay = (new DateTime($changeDate))->modify('-1 day')->format('Y-m-d');
        }

        if ($y->format('N') > 5)
            array_splice($slba, 2, 1);

        $users = User::whereNotIn('right', ['adm', 'out'])
            ->orderBy('id', 'asc')
            ->get();

        if (session()->has('mode')) {
            $mode = null;
            session()->forget('mode');
        }
        else {
            request()->session()->put('mode', request()->mode);
            $mode = session('mode');
        }

            return view('slbs.table', compact('stts','users', 'slba', 'y', 'days', 'months', 'currentSlb', 'mode', 'now', 'nextDay', 'previousDay'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $y = VariablesController::timeSet()['now'];
        if ($request->statusNumber) {
            $request->validate([
                'status' => 'min: 1|max: 16'
            ]);
            $var4 = $request->statusNumber;
        }
        else
            $var4 = $request->status;

        if (!$request->slba){
            $request->slba = $this->index()['currentSlb'];
        }

        if ($request->sluzhba) {
            $var1 = $request->id;
            $var2 = $request->date;
            $var3 = $request->sluzhba;
        }
        else{
            $var1 = auth()->user()->id;
            $var2 = (string)$y->format('Y-m-d');
            $var3 = $request->slba;
        }

        if ($request->has('delete'))
            MyFunctions::delete($var1, $var2, $var3);
        else
            MyFunctions::updateOrInsert($var1, $var2, $var3, $var4);

        return redirect('/slbs');
    }

    public static function statistics()
    {
        $dateEnd = new DateTime();
        $dateStart = new DateTime();

        $test = new VariablesController();
        $dzhapaStatuses = $test::$dzhapaStatuses;
        $stts = $test::$stts;
        $slba = $test::$slba;
        $slbs = $slba;
        array_splice($slbs, 1, 1);

        $row1 = MysqlRequests::programm()['row1'];
        $days = $test::$days;
        $months = $test::$months;
        $diff = 7;
        $dateStart->modify("-8 day");

        if (request()->has('dateStart')) {
            $dateStart = (new DateTime(request()->dateStart))->modify('-1 day');
            $dateEnd = new DateTime(request()->dateEnd);
            $diff = $dateEnd->diff($dateStart)->d;
        }

        $weekEndDays = 0;
        for ($i = 0; $i < $diff; ++$i) {
            $date[$i] = new DateTime($dateStart->modify('+1 day')->format('Y-m-d'));
            if($date[$i]->format('N') == 6 or $date[$i]->format('N') == 7)
                $weekEndDays = $weekEndDays + 1;
            if (($dateEnd->diff($date[$i])->d) == 0) {
                break;
            }
        }
        $yogaDays = $diff - $weekEndDays;

        $usersId = User::whereNotIn('right', ['adm', 'out'])->select('id')->get()->toArray();
        for ($i = 0; $i < count($usersId); ++$i )
            $ids[$i] = $usersId[$i]['id'];

        for ($j = 0; $j < count($ids); ++$j) {
            for ($i = 0; $i < count($slbs); ++$i) {
                for ($k = 0; $k < count($date); ++$k) {
                    $status = Slb::where('data', $date[$k]->format('Y-m-d'))
                        ->where('slba', $slbs[$i])
                        ->where('user_id', $ids[$j])
                        ->select('stts')
                        ->get()
                        ->toArray();
                    if ($status){
                        $statuses[$j][$i][$k] = $status['0']['stts'];
                        foreach($stts as $key => $stt){
                            if ($status['0']['stts'] == $key)
                                $day[$j][$i][$k] = $stt;
                        }
                    }
                    else {
                        $day[$j][$i][$k] = 0;
                        $statuses[$j][$i][$k] = '❌';
                    }
                    $dzhapa = Slb::where('data', $date[$k]->format('Y-m-d'))
                        ->where('slba', 'ДЖ')
                        ->where('user_id', $ids[$j])
                        ->select('stts')
                        ->get()
                        ->toArray();
                    if ($dzhapa) {
                        if (!(int)$dzhapa['0']['stts']) {
                            $statuses[$j][6][$k] = $dzhapa['0']['stts'];
                            foreach ($dzhapaStatuses as $key => $stt) {
                                if ($dzhapa['0']['stts'] == $key) {
                                    $day[$j][6][$k] = $stt;
                                }
                            }
                        } else {
                            $day[$j][6][$k] = (int)$dzhapa['0']['stts'];
                            $statuses[$j][6][$k] = (int)$dzhapa['0']['stts'];
                        }
                    }
                    else {
                        $day[$j][6][$k] = 0;
                        $statuses[$j][6][$k] = '❌';
                    }

                    if ($slbs[$i] == 'ЙГ') {
                        if ($yogaDays == 0)
                            $attendance[$j][$i] = '❌';
                        else
                            $attendance[$j][$i] = (int)(array_sum($day[$j][$i]) / $yogaDays * 100);
                    }
                    else
                        $attendance[$j][$i] = (int)(array_sum($day[$j][$i]) / $diff * 100);

                    $attendance[$j][6] = (int)(array_sum($day[$j][6]) / 16 / $diff * 100);
                }
                $iArray[$i] = $i;
                if ($i == 5)
                    $iArray[6] = 6;
            }
            array_multisort($iArray, SORT_ASC, $day[$j]);
            array_multisort($iArray, SORT_ASC, $attendance[$j]);
            array_multisort($iArray, SORT_ASC, $statuses[$j]);
        }

        return view('slbs.stats',compact('attendance', 'row1', 'slba', 'statuses', 'months', 'days', 'date', 'diff', 'dateStart', 'dateEnd', 'weekEndDays', 'slbs'));
    }
}
