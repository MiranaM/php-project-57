<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    public function __construct()
    {
        // Гости видят только список и, если нужно, show
        $this->middleware('auth')->except(['index']);
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

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:task_statuses,name',
        ]);

        TaskStatus::create($data);

        flash('Статус успешно создан')->success();
        return redirect()->route('task_statuses.index');
    }

    public function edit(TaskStatus $task_status)
    {
        return view('task_statuses.edit', compact('task_status'));
    }

    public function update(Request $request, TaskStatus $task_status)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:task_statuses,name,' . $task_status->id,
        ]);

        $task_status->update($data);

        flash('Статус успешно обновлён')->success();
        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $task_status)
    {
        $task_status->delete();

        flash('Статус успешно удалён')->success();
        return redirect()->route('task_statuses.index');
    }
}