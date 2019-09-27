@extends('layout')

@section('title')
    Изменить проект {{ $project->title }}
@endsection

@section('content')
    <div class="justify-content-center mb-2">
        <form action='{{ url("/projects/$project->id") }}' method="post">
            @method('PATCH')
            @csrf
        <h3>
            Изменить проект
        </h3>
        <div class="form-group">
            <label class="text-info" for="title"></label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $project->title }}">
        </div>
        <div class="form-group">
            <label class="text-info" for="description"></label>
            <textarea class="form-control" id="description" name="description">{{ $project->description }}</textarea>
        </div>
            <button type="submit" class="btn btn-info mb-2 float-right">
                Изменить
            </button>
        </form>
        <form action='{{ url("/projects/$project->id") }}' method="post">
            @method('DELETE')
            @csrf
            <div class="d-flex">
            <button type="submit" class="btn btn-danger float-left">💥️
                Удалить
            </button>
            </div>
        </form>
    </div>
@endsection