@extends('layout')

@section('guest')
    <div class="row justify-content-center p-2">
        <div style="width:300px">
            <div class="card text-center border-primary">
                <div class="card-header text-white bg-primary">
                    Пожалуйста введите свои данные, чтобы войти
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('login') }}">
                        @csrf
                    <div class="form-group mr-1 ml-1">
                        <label for="ysl">
                            Ваше имя
                        </label>
                        <input type="text" class="form-control{{ $errors->has('name') ? 'border-danger' : '' }}" id="ysl" value="{{ old('name') }}" maxlength="32" name="name" required>
                    </div>
                    <div class="form-group mr-1 ml-1">
                        <label for="yep">
                            Пароль
                        </label>
                        <input type="password" class="form-control{{ $errors->has('password') ? ' border-danger' : '' }}" id="yep" placeholder="Пароль" maxlength="16" name="password" required>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" value="1" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    Запомнить
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" value="Вход">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
