@extends('layout')

@section('guest')
    <div class="row justify-content-center p-2">
        <div style="width:330px">
            <div class="card text-center border-secondary">
                @if (session('token'))
                    <div class="card-header text-white bg-info">
                        Регистрация
                    </div>
                    <form action="{{ url('/signup') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group mr-1 ml-1">
                                <label class="text-info" for="name">
                                    Ваше Имя на русском
                                </label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'border-danger' : ''}}"
                                       id="name" value="{{ old('name') }}" name="name" autocapitalize="on" required>
                            </div>
                            <div class="form-group mr-1 ml-1">
                                <label class="text-info" for="psw">
                                    Пароль
                                </label>
                                <input type="password"
                                       class="form-control {{ $errors->has('password') ? 'is-danger' : ''}}" id="psw"
                                       name="password" maxlength="16" required>
                            </div>
                            <div class="form-group mr-1 ml-1">
                                <label class="text-info" for="sn">
                                    Духовное имя
                                </label>
                                <input type="text"
                                       class="form-control {{ $errors->has('spiritualName') ? 'is-danger' : ''}}"
                                       id="sn" value="{{ old('spiritualName') }}" name="spiritualName"
                                       autocapitalize="on">
                            </div>
                            <div class="col btn-group btn-group-toggle custom-control-inline mb-2"
                                 data-toggle="buttons">
                                <label class="btn btn-secondary active">
                                    <input type="radio" name="right" class="custom-control-input" id="usr" value="usr"
                                           autocomplete="off" checked>Брахмачари
                                </label>
                                <label class="btn btn-secondary">
                                    <input type="radio" name="rt" class="custom-control-input" id="adm" value="adm"
                                           autocomplete="off">Не брахмачари
                                </label>
                            </div>
                            <div class="mb-2">
                                <input class="btn btn-outline-success" type="submit" name="crt" value="СОЗДАТЬ"
                                       formmethod="post">
                            </div>
                        </div>
                    </form>
                @else
                    <div class="card-header bg-info text-white">
                        Пожалуйста введите маха-секретное кодовое слово
                    </div>
                    <form action="{{ url('/check') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group mr-1 ml-1">
                                <input type="password" class="form-control" id="yep" placeholder="код" maxlength="16"
                                       name="psrd" required autofocus>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="mb-2">
                                <input class="btn btn-outline-success" type="submit" name="rt" value="ВВОД" required>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection