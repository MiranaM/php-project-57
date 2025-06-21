<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\Label;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        // Всё, кроме index/show, — только для авторизованных
        $this->middleware('auth')->except(['index', 'show']);
    }

    // GET /tasks
    public function index()
    {
        $tasks = Task::with(['status', 'creator', 'assignee', 'labels'])->get();
        return view('tasks.index', compact('tasks'));
    }

    // GET /tasks/create
    public function create()
    {
        $statuses = TaskStatus::all();
        $users    = User::all();
        $labels   = Label::all();

        return view('tasks.create', compact('statuses', 'users', 'labels'));
    }

    // POST /tasks
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'status_id'      => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels'         => 'nullable|array',
            'labels.*'       => 'exists:labels,id',
        ]);

        $data['created_by_id'] = auth()->id();

        $task = Task::create($data);

        if (! empty($data['labels'])) {
            $task->labels()->sync($data['labels']);
        }

        flash(__('Задача успешно создана'))->success();
        return redirect()->route('tasks.index');
    }

    // GET /tasks/{task}
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    // GET /tasks/{task}/edit
    public function edit(Task $task)
    {
        $statuses = TaskStatus::all();
        $users    = User::all();
        $labels   = Label::all();

        return view('tasks.edit', compact('task', 'statuses', 'users', 'labels'));
    }

    // PATCH /tasks/{task}
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'status_id'      => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels'         => 'nullable|array',
            'labels.*'       => 'exists:labels,id',
        ]);

        $task->update($data);
        $task->labels()->sync($data['labels'] ?? []);

        flash(__('Задача успешно обновлена'))->success();
        return redirect()->route('tasks.index');
    }

    // DELETE /tasks/{task}
    public function destroy(Task $task)
    {
        if (auth()->id() !== $task->created_by_id) {
            flash(__('Удалять задачи может только их создатель'))->error();
            return redirect()->route('tasks.index');
        }

        $task->delete();
        flash(__('Задача успешно удалена'))->success();
        return redirect()->route('tasks.index');
    }
}