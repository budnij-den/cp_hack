<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge, chrome=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @auth
            @hasSection('title')
                @yield('title')
            @else
                @if(auth()->user()->sname)
                    {{ auth()->user()->sname }}
                @else
                    {{ auth()->user()->name }}
                @endif
            @endif
        @else
            Гость
        @endauth
    </title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
</head>
<body>
<div class="spinner-border text-success"
     style="position: absolute; top: 50%; left: 50%; margin-top: -1.5rem; margin-left: -1.5rem; width: 3rem; height: 3rem;"
     role="status">
    <span class="sr-only">Loading...</span>
</div>
<div id="app">
    <div class="page-header d-none sidenav bg-light" ref="mySidenav" id="mySidenav">
        @include('layouts.navbar')
    </div>
    @if($errors->any() || session('message'))
        @include('layouts.toast')
    @endif
    <span @click="openNav">
        <img src="{{ url('svg/BSSHSA.jpg') }}" width="35" class="rounded align-top m-2" alt="">
    </span>
    <div class="page-main d-none" ref="main" id="main">
        @auth
                @yield('content')
        @else
                @yield('guest')
        @endauth
    </div>
</div>
@include('layouts.footer')
</body>
</html>
