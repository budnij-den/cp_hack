@extends('layout')

@section('title')
    Страница активности
@endsection

@section('content')
    <div class="chats" id="app">
        <photo :users="{{ $users }}"></photo>
    </div>
@endsection