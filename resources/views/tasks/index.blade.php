<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Задачи
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Фильтр --}}
            <div class="d-flex justify-content-between align-items-start mb-4 gap-3 flex-wrap">
                {{-- Форма фильтра --}}
                <form method="GET" action="{{ route('tasks.index') }}"
                    class="d-flex flex-wrap gap-2 align-items-center">
                    <select name="filter[status_id]" class="form-select form-select-sm w-auto">
                        <option value="">Статус</option>
                        @foreach($statuses as $status)
                        <option value="{{ $status->id }}" @selected(($filter['status_id'] ?? '' )==$status->id)>
                            {{ $status->name }}
                        </option>
                        @endforeach
                    </select>

                    <select name="filter[created_by_id]" class="form-select form-select-sm w-auto">
                        <option value="">Автор</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" @selected(($filter['created_by_id'] ?? '' )==$user->id)>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>

                    <select name="filter[assigned_to_id]" class="form-select form-select-sm w-auto">
                        <option value="">Исполнитель</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" @selected(($filter['assigned_to_id'] ?? '' )==$user->id)>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">Применить</button>
                </form>

                {{-- Кнопка создания задачи --}}
                @auth
                <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">Создать задачу</a>
                @endauth
            </div>

            {{-- Таблица задач --}}
            <div class="overflow-x-auto bg-white shadow rounded">
                <table class="min-w-full border divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-sm text-left">ID</th>
                            <th class="px-4 py-2 text-sm text-left w-48">Статус</th>
                            <th class="px-4 py-2 text-sm text-left">Имя</th>
                            <th class="px-4 py-2 text-sm text-left">Автор</th>
                            <th class="px-4 py-2 text-sm text-left">Исполнитель</th>
                            <th class="px-4 py-2 text-sm text-left">Дата создания</th>
                            @canany(['update', 'delete'], new \App\Models\Task())
                            <th class="px-4 py-2 text-sm text-left">Действия</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($tasks as $task)
                        <tr>
                            <td class="px-4 py-2 text-sm">{{ $task->id }}</td>
                            <td class="px-4 py-2 text-sm">{{ $task->status->name }}</td>
                            <td class="px-4 py-2 text-sm text-blue-600 hover:underline">
                                <a href="{{ route('tasks.show', $task) }}">
                                    {{ $task->name }}
                                </a>
                            </td>
                            <td class="px-4 py-2 text-sm">{{ $task->creator->name }}</td>
                            <td class="px-4 py-2 text-sm">{{ $task->assignee?->name ?? '—' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $task->created_at->format('d.m.Y') }}</td>
                            @canany(['update', 'delete'], $task)
                            <td>
                                @can('delete', $task)
                                <a class="text-red-600 hover:text-red-900" href="#" onclick="if(confirm('Вы уверены, что хотите удалить задачу?')) {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{ $task->id }}').submit();
                                }">
                                    Удалить
                                </a>
                                <form id="delete-form-{{ $task->id }}" action="{{ route('tasks.destroy', $task) }}"
                                    method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endcan

                                @can('update', $task)
                                <a href="{{ route('tasks.edit', $task) }}"
                                    class="text-blue-600 hover:text-blue-900">Изменить</a>
                                @endcan
                            </td>
                            @endcanany
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Пагинация --}}
            <div class="mt-4">
                {{ $tasks->appends($filter)->links() }}
            </div>
        </div>
    </div>
</x-app-layout>