<?php

namespace App\Http\Controllers;

use App\Service;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $test = new SlbsController();
        $now = $test::index()['now'];
        $nextDay = $test::index()['nextDay'];
        $previousDay = $test::index()['previousDay'];

        $test1 = new VariablesController();
        $y = $test1::timeSet()['now'];
        $days = $test1::$days;
        $months = $test1::$months;

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

        $users = User::whereNotIn('right', ['adm', 'out'])
            ->orderBy('id', 'asc')
            ->get();

        for ($i = 0; $i < 10; $i++) {
            $rules[$i] = DB::table('rules')
                ->select('service', 'id')
                ->get()[$i];
        }

        return view('services.index', compact('months','days', 'y', 'users', 'rules', 'now', 'nextDay', 'previousDay'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = "service".$request->id;
        Service::create([
            'rule_id' => $request->{$service},
            'user_id' => $request->id,
            'dateToServe' => $request->date
        ]);

        return redirect('/services');
    }

    public function statistics()
    {
        //
    }
}
