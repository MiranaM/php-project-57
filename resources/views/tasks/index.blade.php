<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Задачи') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">

                <!-- Форма фильтрации -->
                <div class="px-6 py-4 border-b border-gray-200 bg-white">
                    <form method="GET" action="{{ route('tasks.index') }}" class="flex flex-wrap gap-4 items-center">
                        <select name="filter[status_id]" class="border rounded px-3 py-1 text-sm">
                            <option value="">Статус</option>
                            @foreach($statuses as $status)
                            <option value="{{ $status->id }}"
                                {{ request('filter.status_id') == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                            @endforeach
                        </select>

                        <select name="filter[created_by_id]" class="border rounded px-3 py-1 text-sm w-48">
                            <option value="">Автор</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                {{ request('filter.created_by_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>

                        <select name="filter[assigned_to_id]" class="border rounded px-3 py-1 text-sm w-48">
                            <option value="">Исполнитель</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                {{ request('filter.assigned_to_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>

                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 text-sm rounded">
                            Применить
                        </button>
                    </form>
                </div>

                <!-- Кнопка "Создать задачу" -->
                @auth
                <div class="px-6 py-4 bg-white">
                    <a href="{{ route('tasks.create') }}"
                        class="inline-block bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded text-sm font-semibold">
                        Create task
                    </a>
                </div>
                @endauth

                <!-- Таблица -->
                <div class="px-6 py-4 bg-white">
                    <table class="w-full text-sm table-auto border-collapse">
                        <thead>
                            <tr class="border-b text-left text-gray-700">
                                <th class="pb-2">ID</th>
                                <th class="pb-2">Статус</th>
                                <th class="pb-2">Имя</th>
                                <th class="pb-2">Автор</th>
                                <th class="pb-2">Исполнитель</th>
                                <th class="pb-2">Дата создания</th>
                                @auth
                                <th class="pb-2">Действия</th>
                                @endauth
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tasks as $task)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2">{{ $task->id }}</td>
                                <td class="py-2">{{ $task->status->name }}</td>
                                <td class="py-2">
                                    <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:underline">
                                        {{ $task->name }}
                                    </a>
                                </td>
                                <td class="py-2">{{ $task->creator->name }}</td>
                                <td class="py-2">{{ optional($task->assignee)->name ?? '-' }}</td>
                                <td class="py-2">{{ $task->created_at->format('d.m.Y') }}</td>
                                @auth
                                @if(auth()->id() === $task->created_by_id)
                                <td class="py-2 whitespace-nowrap">
                                    <a href="{{ route('tasks.edit', $task) }}"
                                        class="text-indigo-600 hover:text-indigo-900">Изменить</a>
                                </td>
                                @else
                                <td class="py-2 text-gray-400">—</td>
                                @endif
                                @endauth
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-4 text-center text-gray-500">Задач пока нет.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>