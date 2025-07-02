<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use App\Models\Label;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $statuses = TaskStatus::all();
        $users = User::all();

        $filter = $request->input('filter', []); // все параметры фильтра

        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id'),
            ])
            ->with(['status', 'creator', 'assignee'])
            ->orderBy('id')
            ->paginate(15)
            ->appends(['filter' => $filter]);

        return view('tasks.index', [
            'tasks' => $tasks,
            'statuses' => $statuses,
            'users' => $users,
            'filter' => $filter,
        ]);
    }

    public function create()
    {
        $statuses = TaskStatus::all();
        $users = User::all();
        $labels = Label::all();
        return view('tasks.create', compact('statuses', 'users', 'labels'));
    }

    public function store(TaskRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by_id'] = \Auth::id();

        $task = Task::create($validated);
        $task->labels()->sync($request->input('labels', []));

        $perPage = 15;
        $tasksCount = Task::count();
        $lastPage = ceil($tasksCount / $perPage);

        flash('Задача успешно создана')->success();
        return redirect()->route('tasks.index', ['page' => $lastPage]);
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $statuses = TaskStatus::all();
        $users = User::all();
        $labels = Label::all();
        return view('tasks.edit', compact('task', 'statuses', 'users', 'labels'));
    }

    public function update(TaskRequest $request, Task $task)
    {
        $validated = $request->validated();

        $task->update($validated);
        $task->labels()->sync($request->input('labels', []));

        flash('Задача успешно изменена')->success();
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task, Request $request)
    {
        if (Auth::id() !== $task->created_by_id) {
            flash('Нет прав для этого действия')->error();
            return redirect()->route('tasks.index', ['page' => $request->input('page', 1)]);
        }

        $task->labels()->detach();
        $task->delete();

        flash('Задача успешно удалена')->success();
        return redirect()->route('tasks.index', ['page' => $request->input('page', 1)]);
    }
}
