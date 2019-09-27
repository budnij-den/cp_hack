<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        session()->forget('token');
        return view('index', compact('user'));
    }

    public function list()
    {
        $this->middleware('auth');
        $users = SlbsController::index()['users'];

        return view('user.all')->with('users', $users);
    }
}
