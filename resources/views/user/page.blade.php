@extends('layout')

@section('title')
    {{ $user->name }}
@endsection

@section('content')
    <div class="d-flex bg-light rounded flex-column">
        <div class="d-flex flex-row">
            <div class="w-25 mb-1 img">
                <div class="card mr-1">
                    <img src='{{ url("/svg/".$user->id.".jpg") }}' alt="" class="rounded img-thumbnail personal-img">
                    <div class="card-footer lastSeen text-muted p-1 text-right"
                         id="{{ $user->lastSeen_at }}"></div>
                </div>
            </div>
            <div class="w-75 list-group" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action" id="list-person-list" data-toggle="list"
                   href="#list-person" role="tab" aria-controls="home">
                    Личные данные
                </a>
                @can('view', $user)
                    <a class="list-group-item list-group-item-action" id="list-projects-list" data-toggle="list"
                       href="#list-projects" role="tab" aria-controls="projects">
                        @if(auth()->id() == $user->id)
                            Мои проекты
                        @else
                            Проекты преданного
                        @endif
                    </a>
                    <a class="list-group-item list-group-item-action" id="list-slbs-list" data-toggle="list"
                       href="#list-slbs" role="tab" aria-controls="slbs">
                        @if(auth()->id() == $user->id)
                            Мои службы
                        @else
                            Службы преданного
                        @endif
                    </a>
                @endcan
                <a class="list-group-item list-group-item-action" id="list-services-list" data-toggle="list"
                   href="#list-services" role="tab" aria-controls="home">
                    Мои служения
                </a>
            </div>
        </div>
        <div>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="list-person" role="tabpanel"
                     aria-labelledby="list-person-list">
                    <ul class="list-group list-group-flush">
                        @if($user->sname)
                            <li class="list-group-item">
                                <a class="badge badge-light">
                                   Духовное Имя
                                </a>
                                <span class="float-right">
                                    {{$user->sname}}
                                </span>
                            </li>
                        @endif
                        <li class="list-group-item">
                            <a class="badge badge-light">
                                Имя
                            </a>
                            <span class="float-right">
                                {{$user->name}}
                            </span>
                        </li>
                        <li class="list-group-item">
                            <a class="badge badge-light">
                                Город
                            </a>
                            <span class="float-right">
                                {{$user->brah->city}}
                            </span>
                        </li>
                        <li class="list-group-item">
                            <a class="badge badge-light">
                                Телефон
                            </a>
                            <a class="float-right" href="tel:{{$user->brah->tel}}">
                                {{$user->brah->tel}}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a class="badge badge-light">
                                Дней в ашраме
                            </a>
                            <span class="float-right">
                                {{ $daysInAshram }}
                            </span>
                        </li>
                        <li class="list-group-item">
                            <a class="badge badge-light">
                                Прочитано джапы
                            </a>
                            <span class="float-right">
                                {{ $allDzhapa }}
                            </span>
                        </li>
                    </ul>
                </div>
                @can('view', $user)
                    <div class="tab-pane fade" id="list-projects" role="tabpanel"
                         aria-labelledby="list-projects-list">
                        <div class="accordion" id="projects">
                            <div class="card">
                                <div class="card-header h2 text-center" id="actual">
                                    <button class="btn" type="button" data-toggle="collapse"
                                            data-target="#collapseActual"
                                            aria-expanded="true" aria-controls="collapseActual">
                                        <a class="h4">
                                            Текущие Проекты
                                        </a>
                                    </button>
                                </div>
                                <div id="collapseActual" class="collapse show" aria-labelledby="actual"
                                     data-parent="#projects">
                                    <div class="card-body">
                                        @if($ongoingProjects->count())
                                            <div class="list-group">
                                                @foreach($ongoingProjects as $project)
                                                    <div class="mb-3 shadow">
                                                        <a href='{{ url("/projects/$project->id") }}'
                                                           class="list-group-item list-group-item-action">
                                                            <div class="d-flex justify-content-between">
                                                                <p class="h5 text-dark text-truncate">
                                                                    {{ $project->title }}
                                                                </p>
                                                                <small class="badge expireAt {{ $project->day <= 1 ? 'badge-danger' : 'badge-success'}}"
                                                                       id="{{$project->expire_at}}"
                                                                       title="{{ $project->date <= 0 ? 'stop' : 'play' }}">
                                                                </small>
                                                            </div>
                                                        </a>
                                                        <div class="text-truncate m-1 font-italic">
                                                            {{ $project->description }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center">
                                                Пусто
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card text-muted">
                                <div class="card-header text-center" id="archive">
                                    <button class="btn" type="button" data-toggle="collapse"
                                            data-target="#collapseArchive"
                                            aria-expanded="true" aria-controls="collapseArchive">
                                        <a class="h4 text-muted">
                                            Архив
                                        </a>
                                    </button>
                                </div>
                                <div id="collapseArchive" class="collapse" aria-labelledby="archive"
                                     data-parent="#projects">
                                    <div class="card-body">
                                        @if($doneProjects->count())
                                            <div class="list-group">
                                                @foreach($doneProjects as $project)
                                                    <div class="mb-3 shadow">
                                                        <a href='{{ url("/projects/$project->id") }}'
                                                           class="list-group-item list-group-item-action">
                                                            <div class="d-flex justify-content-between">
                                                                <p class="h5 text-truncate">
                                                                    {{ $project->title }}
                                                                </p>
                                                                <small class="badge expireAt badge-danger"
                                                                       id="{{$project->expire_at}}"
                                                                       title="stop">
                                                                </small>
                                                            </div>
                                                        </a>
                                                        <div class="text-truncate m-1 font-italic">
                                                            {{ $project->description }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center">
                                                Пусто
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($user->id == auth()->id())
                            <div class="flex-fill">
                                <div class="text-muted mb-2"
                                     onclick="document.location.href='{{ url("/projects/create") }}'">
                                    Создать Проект
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="list-slbs" role="tabpanel"
                     aria-labelledby="list-slbs-list">
                        @if($currentSlb && ($user->id == auth()->id()))
                            <div class="text-muted mb-2">
                                Отметиться на службе
                            </div>
                        @endif
                        <form action="{{ url('/slbs') }}" class="mb-1" method="post">
                            @csrf
                            @if($user->id == auth()->id())
                                <div class="d-flex flex-row justify-content-center mb-3">
                                    @if($currentSlb == 'ДЖ')
                                        <input type="hidden" name="slba" id="dzhapa" value="">
                                        <div class="btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-secondary" for="sttsn">
                                                <input type="radio" name="status"
                                                       class="custom-control-input" id="sttsn" value="n"
                                                       onchange="this.form.submit()">n
                                            </label>
                                            <label class="btn btn-secondary" for="sttsc">
                                                <input type="radio" name="status"
                                                       class="custom-control-input" id="sttsc" value="c"
                                                       onchange="this.form.submit()">c
                                            </label>
                                            <label class="btn btn-secondary" for="sttsb">
                                                <input type="radio" name="status"
                                                       class="custom-control-input" id="sttsb" value="b"
                                                       onchange="this.form.submit()">b
                                            </label>
                                        </div>
                                        <div class="mb-2">
                                            <input type="number" name="statusNumber" onfocusout="this.form.submit()"
                                                   class="form-control"
                                                   placeholder="в лакхах" min="1" max="16">
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-outline-danger" name="delete">
                                                ❌
                                            </button>
                                        </div>
                                    @elseif($currentSlb)
                                        <input type="hidden" name="slba" id="sluzhba" value="">
                                        <div class="btn-group-toggle mb-2" data-toggle="buttons">
                                            @foreach($stts as $key => $stt)
                                                <label class="btn btn-secondary" for="stts{{ $key }}">
                                                    <input type="radio" name="status" onchange="this.form.submit()"
                                                           class="custom-control-input" id="stts{{ $key }}"
                                                           value="{{ $key }}">{{ $key }}
                                                </label>
                                            @endforeach
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-outline-danger" name="delete">
                                                ❌
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </form>
                        <table class="table table-sm table-striped table-bordered table-fit shadow bg-light">
                                <caption>
                                    Статистка посещаемости
                                </caption>
                                <thead class="bg-info">
                                <tr>
                                    <th>
                                        @if($user->sname)
                                            {{ $user->sname }}
                                        @else
                                            {{ $user->name }}
                                        @endif
                                    </th>
                                    @foreach($slba as $slb)
                                        <th scope='col' id="{{ $slb }}">
                                            {{ $slb }}
                                        </th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                    @for($k = 0; $k < count($date); ++$k)
                                        <tr>
                                            <td>
                                                {{$days[$date[$k]->format('N')] . $date[$k]->format(' d ') . $months[$date[$k]->format('n')]}}
                                            </td>
                                            @for ($i = 0; $i < count($slba); ++$i)
                                                <td>
                                                    <div>
                                                        {{$statuses[$i][$k]}}
                                                    </div>
                                                </td>
                                            @endfor
                                        </tr>
                                    @endfor
                                    <tr>
                                        <td>
                                            Итого
                                        </td>
                                        @for($i = 0; $i < count($slba); ++$i)
                                            <td class="{{ (($attendance[$i] >= 75) || (($user->id < $yearId) && ($slba[$i] == 'ЙГ'))) ? 'bg-success' : 'bg-danger'}}">
                                                {{ $attendance[$i] }}
                                            </td>
                                        @endfor
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                @endcan
                <div class="tab-pane fade" id="list-services" role="tabpanel"
                     aria-labelledby="list-services-list">
                    <table class="table table-sm table-striped table-bordered table-fit shadow bg-light">
                        <thead class="bg-info">
                        <tr>
                            <th>
                                @if($user->sname)
                                    {{ $user->sname }}
                                @else
                                    {{ $user->name }}
                                @endif
                            </th>
                            <th>
                                Служения
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($k = 0; $k < count($data); ++$k)
                            <tr>
                                <td>
                                    {{$days[$data[$k]->format('N')] . $data[$k]->format(' d ') . $months[$data[$k]->format('n')]}}
                                </td>
                                @if($rules[$k] == 'Свободен')
                                    <td>
                                        {{$rules[$k]}}
                                    </td>
                                @else
                                    <td class="service" id="{{$k}}">
                                        {{ $rules[$k]->service }}
                                    </td>
                                    <div class="modal fade description{{$k}}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel{{ $rules[$k]->id }}">
                                                        {{ $rules[$k]->service }}
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    @php
                                                        echo $rules[$k]->desc;
                                                    @endphp
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                        Спасибо
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection