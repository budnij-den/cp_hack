@extends('layout')

@section('content')
    @auth
    <div class="container-fluid">
    <div class="jumbotron jumbotron-fluid">
	    <div class="container">
		    <div class="row">
			    <div class="col-9">
				    <h1 class="display-6">
					    Добро пожаловать в БСШСА
                    </h1>
	                <p class="lead">
	                    {{ auth()->user()->name }}, дорогой, вы уже вошли
	                </p>
                </div>
                <div class="col-3">
                    <img src="{{ url('svg/BSSHSA.jpg') }}" width="195" class="img-thumbnail shadow" alt="">
                </div>
            </div>
            <hr class="row my-4">
                <p>
                    <button type="button" class="dropdown-item btn-lg btn mb-2" data-toggle="modal" data-target="#exML">
                        Инструкция
                    </button>
                    @if($user)
                    <a class="dropdown-item btn-lg mb-2" href='{{ url("/$user->id") }}'>
                        Домой
                    </a>
                    @endif
                    <a class="dropdown-item btn-lg mb-2" href="{{ url('/logout') }}">
                        Выход
                    </a>
                </p>
@include('layouts.instruction')
        </div>
    </div>
    </div>
    @endauth
@endsection
@section('guest')
    <div class="container-fluid">
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-9">
                        <h1 class="display-6">
                            Добро пожаловать в БСШСА
                        </h1>
                        <p class="lead">
                            Дорогой Гость! Пожалуйста зарегистрируйтесь или войдите, чтобы пользоваться сайтом
                        </p>
                    </div>
                    <div class="col-3">
                        <img src="{{ url('svg/BSSHSA.jpg') }}" width="195" class="img-thumbnail shadow" alt="">
                    </div>
                </div>
                <hr class="row my-4">
                <p>
                    <button type="button" class="dropdown-item btn-lg btn mb-2" data-toggle="modal" data-target="#exML">
                        Инструкция
                    </button>
                        <a class="dropdown-item btn-lg mb-2" href="{{ url('/login') }}">
                            Вход
                        </a>
                        <a class="dropdown-item btn-lg mb-2" href="{{ url('/check') }}">
                            Регистрация
                        </a>
                </p>
                @include('layouts.instruction')
            </div>
        </div>
    </div>
@endsection
