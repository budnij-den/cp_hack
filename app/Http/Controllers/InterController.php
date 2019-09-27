<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Brah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;


class InterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function name()
    {
        return 'name';
    }
    public function check(Request $request)
    {
        if ($request->has('psrd')) {
            $password = $request->psrd;
            $secretWord = 'jointohil';
            if($password == $secretWord)
                $token = TRUE;
            else
                $token = FALSE;
            $request->session()->put('token', $token);

            if ($token)
            {
                return redirect('/signup');
            }
            else
            {
                session()->flash('message', 'Секретное слово введено неверно');
                return redirect('/check');
            }
        }
        else
            return back();
    }

    protected function registration(Request $request)
    {
        if (Auth::viaRemember()) {
            MyFunctions::destroySession();
            Auth::logout();
        }

        $request->validate ([
            'password' => 'required|string|min:6|max:255',
            'name' => 'required|string|min:6|max:255|unique:users',
        ]);

        $thisYear = (new \DateTime())->format('y');
        if(User::count())
            $lastUser = User::select('id')->get()->last()->id;
        else
            $lastUser = (int)($thisYear . "00");
        $lastUserId = str_split($lastUser, 2);
        if ($lastUserId[0] == $thisYear)
            $id = $lastUser + 1;
        else
            $id = (int)($thisYear . "01");

        Brah::create([
            'tel' => '',
            'city' => '',
            'user_id' => $id
        ]);

        User::create([
            'sname' => $request->spiritualName,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'right' => $request->right,
            'id' => $id
        ]);
        session()->flash('message', 'Успешная регистрация. Удачи!');
        return redirect('/');
    }

    public function signup()
    {
        return view('guest.signup');
    }
    
    protected function login()
    {
    	return view('guest.login');
    }
    
    public function enter(Request $request)
    {
    	$request->validate ([
            'password' => 'required|string|min:6|max:255',
            'name' => 'required|string|min:6|max:255',
        ]);

    	$user = User::where('name', $request->name)->first();
        $remember = (int)$request->remember;

        if (Auth::attempt(['name' => Input::get('name'), 'password' => Input::get('password')], $remember)) {
            $request->session()->regenerate();
            return redirect("/$user->id");
        }
        else {
            session()->flash('message', 'Имя или пароль введены неверно');
            return redirect('/login');
        }
    }

    public function logout()
    {
        if (isset($name))
            $name = null;
        else {
            if (auth()->user())
                $name = auth()->user()->name;
            else
                $name = null;
        }

        Auth::logout();
        return view('guest.logout', compact('name'));
    }
}