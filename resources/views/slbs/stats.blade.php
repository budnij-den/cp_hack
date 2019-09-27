@extends('layout')

@section('content')
    <div class="row justify-content-center">
        <div class="alert alert-info shadow">
            <p class="h4" id="timeSet">
                Статистика за {{$diff}} дней начиная с {{ $date[0]->format(' d ') . $months[$date[0]->format('n')] }}
                до {{ $date[$diff-1]->format(' d ') . $months[$date[$diff-1]->format('n')] }} в %
            </p>
        </div>
    </div>
    <div class="d-flex flex-row">
        <table class="table table-sm table-striped table-bordered table-fit shadow bg-light">
            <caption>
                Статистка посещаемости
            </caption>
            <thead class="bg-info">
                <tr>
                    <th>
                        Имя
                    </th>
                    @foreach($slba as $slb)
                        <th scope='col' id="{{ $slb }}">
                            {{ $slb }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @for ($j = 0; $j < count($row1); ++$j)
                    <tr title="{{ $row1[$j]['name'] }}" id="{{$row1[$j]['id']}}">
                        <td class="{{($row1[$j]['id'] == auth()->id()) || (auth()->user()->right !== 'usr') ? 'stts' : ''}}" id="{{count($date)}}">
                            {{ $row1[$j]['name'] }}
                        </td>
                        @for ($i = 0; $i < count($slba); ++$i)
                            <td class="{{ (($attendance[$j][$i] >= 75) || (((int)$row1[$j]['id'] < 1800) && ($slba[$i] == 'ЙГ'))) ? 'bg-success' : 'bg-danger'}}">
                                @for($k = 0; $k < count($date); ++$k)
                                    <div class="hide sts{{$row1[$j]['id']}}{{$i}}{{$k}}" title="{{$statuses[$j][$i][$k]}}"></div>
                                @endfor
                                {{ $attendance[$j][$i] }}
                            </td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
    <form action="{{url('/slbs/statistic')}}" method="get">
        <div class="row justify-content-center">
            <div style="width:300px">
                <div class="text-center card border-info mb-2">
                    <div class="card-header">
                        Выберите диапазон дат
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <div class="float-right">
                    <input class="form-control" type="date" name="dateStart" value="{{$date[0]->format('Y-m-d')}}" onchange="this.form.submit()" max="{{$date[$diff-1]->format('Y-m-d')}}">
                </div>
            </div>
            <div class="col-6">
                <div class="float-left">
                    <input class="form-control" type="date" name="dateEnd" value="{{$date[$diff-1]->format('Y-m-d')}}" min="{{$date[1]->format('Y-m-d')}}" max="{{$date[$diff-1]->format('Y-m-d')}}"
                           onchange="this.form.submit()">
                </div>
            </div>
        </div>
    </form>
    <div class="modal fade" id="statuses" role="dialog">
        <div class="modal-dialog modal-dialog-centered" >
            <div class="modal-content">
                <div class="justify-content-center">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="statsModal"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="overflow-y: auto;
    max-height: 350px;">
                        <table class="table table-sm table-striped table-bordered shadow">
                            <thead>
                            <tr>
                                <th>День</th>
                                @foreach($slba as $slb)
                                    <th>{{ $slb }}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @for($k = 0; $k <count($date); ++$k)
                                <tr>
                                    <td>{{$days[$date[$k]->format('N')] . $date[$k]->format(' d ') . $months[$date[$k]->format('n')]}}</td>
                                    @for($i = 0; $i <count($slba); ++$i)
                                        <td class="st{{$i}}{{$k}}"></td>
                                    @endfor
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection