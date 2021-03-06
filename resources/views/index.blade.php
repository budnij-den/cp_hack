@extends('layout')

@section('content')
    <div class="container-fluid">
    <div class="jumbotron jumbotron-fluid">
	    <div class="container">
		    <div class="row">
			    <div class="col-9">
				    <h1 class="display-6">
					    Добро пожаловать на сайт волонтёров
                    </h1>
	                <p class="lead">
	                    Это страница приветствия
	                </p>
                </div>
                <div class="col-3">
                    <img src="{{ url('svg/volunteer.jpg') }}" width="195" class="img-thumbnail shadow" alt="">
                </div>
            </div>
            <hr class="row my-4">
                <p>
                    <a class="dropdown-item btn-secondary mb-2" href='{{ url("/activity") }}'>
                        Посмотреть активность
                    </a>
                </p>
        </div>
    </div>
    </div>
@endsection
{{--
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
--}}
