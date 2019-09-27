@extends('layout')

@section('title')
    Список Брахмачари
@endsection

@section('content')
    <div class="list-group all w-25 card ml-5">
        @foreach($users as $user)
            <div class="list-group-item d-flex flex-row p-1">
                <div class="w-25 d-flex justify-content-center mr-3">
                    <img src="{{ url('/svg/'.$user->id.'.jpg')}}" width="100"
                     class="img-thumbnail all-img" alt="...">
                </div>
                <div class="w-75 align-self-center">
                    <a href='{{ url("/$user->id") }}' class="btn btn-outline-info" role="button">
                        @if($user->sname)
                            {{ $user->sname }}
                        @else
                            {{ $user->name }}
                        @endif
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection