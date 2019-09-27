<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Task $task)
    {
        $method = request()->has('completed') ? 'complete' : 'incomplete';
            $task->$method();
        return back();
    }

    public function store(Request $request, Project $project)
    {
        $attributes = $request->validate([
            'description' => 'required|min:3'
        ]);
        $project->addTask($attributes);
        return back();
    }
}
