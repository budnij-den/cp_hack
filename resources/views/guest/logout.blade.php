@extends('layout')


@section('guest')
    @if($name)
<div class="row justify-content-center p-2">
    <div style="width:300px">
        <div class="card text-center border-secondary">
            <div class="card-header bg-success">
                Вы вышли
            </div>
            <div class="card-body">
                <h5 class="card-title">
                    Всего доброго, {{ $name }}
                </h5>
                <a class="btn btn-outline-info" href="{{ url('login') }}">
                    На вход
                </a>
            </div>
            <div class="card-footer text-muted">
                Спасибо за посещение
            </div>
        </div>
    </div>
</div>
@else
<div class="row justify-content-center p-2">
    <div style="width:300px">
        <div class="card text-center border-secondary">
            <div class="card-header">
                Это Выход
            </div>
            <div class="card-body">
                <h5 class="card-title">
                    Вы ещё не заходили
                </h5>
                <a class="btn btn-outline-primary" href="{{ url('/') }}">
                    Начало
                </a>
            </div>
            <div class="card-footer bg-light text-muted">
                Сайт БСШСА
            </div>
        </div>
    </div>
</div>
@endif
@endsection