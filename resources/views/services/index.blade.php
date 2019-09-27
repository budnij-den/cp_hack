@extends('layout')

@section('title')
    Таблица служений
@endsection

@section('content')
    <form action="{{ url('/services') }}" method="post">
    @csrf
        <div class="d-flex flex-row">
            <table class="table table-sm table-striped table-bordered shadow bg-light">
                <thead>
                    <tr>
                        <td>
                            Имя
                        </td>
                        <td>
                            Служение
                        </td>
                    </tr>
                </thead>
                <tbody class="usersCount" id="{{count($users)}}">
                <input type="hidden" name="id" value="">
                <input type="hidden" name="date" value="{{$y->format('Y-m-d')}}">
                <input type="hidden" name="service" value="">
                    @foreach($users as $key => $user)
                        <tr title="{{$user->id}}">
                            <td>
                                @if($user->sname)
                                    {{ $user->sname }}
                                @else
                                    {{ $user->name }}
                                @endif
                            </td>
                            <td>
                                <select class="custom-select" name="service{{$user->id}}" onchange="this.form.submit()">
                                    <option>Выбрать служение...</option>
                                    @for($i = 0; $i < count($rules); $i++)
                                        <option value="{{ $rules[$i]->id }}">
                                            {{ $rules[$i]->service }}
                                        </option>
                                    @endfor
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
    <form method="get" action="{{ url('/services') }}" class="d-flex flex-column align-items-center">
        <div class="modal fade" id="timeForm">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-info justify-content-center">
                        Изменить дату
                    </div>
                    <div class="modal-body bg-light">
                        <input class="form-control mb-2" onchange="this.form.submit()" type="date"
                               name="changeDate" value="{{$y->format('Y-m-d')}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="width d-flex justify-content-between rounded bg-info mb-1">
            <div class="ml-3">
                <a class="navbar-brand" href='{{ url("/services?changeDate=$previousDay") }}'>
                    <img style="height: 80px; width: 50px" src="{{ url('/svg/prev.jpg') }}"
                         class="rounded-circle shadow" alt="...">
                </a>
            </div>
            <div class="d-flex mb-1 mt-1 flex-column">
                <div class="h5 text-center bg-light rounded p-1 shadow-sm" id="timeSet">
                    {{ $days[$y->format('N')] . $y->format(' d ') . $months[$y->format('n')] . $y->format(' Y') }}
                </div>
                <a href='{{ url("/services?changeDate=$now") }}' class="text-center">
                    <button type="button" class="btn btn-light shadow-sm">
                        Сегодня
                    </button>
                </a>
            </div>
            <div class="ml-3">
                <div>
                    <a class="navbar-brand" href='{{ url("/services?changeDate=$nextDay") }}'>
                        <img style="height: 80px; width: 50px" src="{{ url('/svg/next') }}.jpg" class="rounded-circle"
                             alt="...">
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection