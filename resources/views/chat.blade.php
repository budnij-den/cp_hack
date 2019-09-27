@extends('layout')

@section('content')
    <div class="chats" id="ap">
        <chat :user="{{ auth()->user() }}"></chat>
    </div>
@endsection