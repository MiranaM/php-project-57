<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Задачи
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Фильтр --}}
            <form method="GET" action="{{ route('tasks.index') }}" class="mb-4 flex flex-wrap gap-4 items-center">
                <select name="filter[status_id]" class="border-gray-300 rounded">
                    <option value="">Статус</option>
                    @foreach($statuses as $status)
                    <option value="{{ $status->id }}" @if(($filter['status_id'] ?? '' )==$status->id) selected @endif>
                        {{ $status->name }}
                    </option>
                    @endforeach
                </select>

                <select name="filter[created_by_id]" class="border-gray-300 rounded">
                    <option value="">Автор</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" @if(($filter['created_by_id'] ?? '' )==$user->id) selected @endif>
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>

                <select name="filter[assigned_to_id]" class="border-gray-300 rounded">
                    <option value="">Исполнитель</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" @if(($filter['assigned_to_id'] ?? '' )==$user->id) selected @endif>
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Применить
                </button>
            </form>


            {{-- Таблица задач --}}
            <div class="overflow-x-auto bg-white shadow rounded">
                <table class="min-w-full border divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-sm text-left">ID</th>
                            <th class="px-4 py-2 text-sm text-left">Статус</th>
                            <th class="px-4 py-2 text-sm text-left">Имя</th>
                            <th class="px-4 py-2 text-sm text-left">Автор</th>
                            <th class="px-4 py-2 text-sm text-left">Исполнитель</th>
                            <th class="px-4 py-2 text-sm text-left">Дата создания</th>
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