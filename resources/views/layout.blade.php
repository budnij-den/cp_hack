<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge, chrome=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title')
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
<div class="page-main d-none" ref="main" id="main">
    @yield('content')
</div>
@include('layouts.footer')
</body>
</html>
