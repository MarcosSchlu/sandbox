<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return view("welcome", compact("tasks"));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'task' => 'required',
            'status' => 'required',
        ]);
        Task::create($request->all());
        return back()->with("message", "Tarea agregada correctamente");
    }

    public function edit(Request $request)
    {
        $task = Task::findOrFail($request->taskid);
        $task->task = $request->editTaskName;
        $task->status = $request->editStatus;
        $task->update();
        return back()->with('message', "Tarea actualizada correctamente");
    }

    public function destroy(Request $request)
    {
        $task = Task::findOrFail($request->id);
        $task->delete();
        return back()->with('message', "Tarea eliminada correctamente");
    }
}
