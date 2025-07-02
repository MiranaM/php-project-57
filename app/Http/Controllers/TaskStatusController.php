<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use App\Http\Requests\TaskStatusRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $statuses = TaskStatus::all();
        return view('task_statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('task_statuses.create');
    }

    public function store(TaskStatusRequest $request)
    {
        $validated = $request->validated();

        TaskStatus::create($validated);

        flash('Статус успешно создан')->success();
        return redirect()->route('task_statuses.index');
    }

    public function edit(TaskStatus $taskStatus)
    {
        return view('task_statuses.edit', compact('taskStatus'));
    }

    public function update(TaskStatusRequest $request, TaskStatus $taskStatus)
    {
        $validated = $request->validated();

        $taskStatus->update($validated);

        flash('Статус успешно изменён')->success();
        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        if ($taskStatus->tasks()->exists()) {
            flash('Не удалось удалить статус')->error();
            return redirect()->route('task_statuses.index');
        }

        $taskStatus->delete();
        flash('Статус успешно удалён')->success();
        return redirect()->route('task_statuses.index');
    }
}
