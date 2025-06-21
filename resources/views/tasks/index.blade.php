<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Задачи') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                @auth
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent
                              rounded-md font-semibold text-xs text-white uppercase tracking-widest
                              hover:bg-indigo-500 focus:outline-none focus:ring focus:ring-indigo-300 transition">
                        {{ __('Новая задача') }}
                    </a>
                </div>
                @endauth

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Имя</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Создатель</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Исполнитель</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Метки</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Дата</th>
                            @auth
                            <th class="px-6 py-3"></th>
                            @endauth
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tasks as $task)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $task->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <a href="{{ route('tasks.show', $task) }}" class="hover:underline">
                                    {{ $task->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $task->status->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $task->creator->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ optional($task->assignee)->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @foreach($task->labels as $label)
                                <span
                                    class="inline-block bg-gray-200 rounded-full px-2 py-0.5 text-xs font-medium text-gray-800 mr-1">
                                    {{ $label->name }}
                                </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $task->created_at->format('d.m.Y') }}
                            </td>
                            @auth
                            @if(auth()->id() === $task->created_by_id)
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('tasks.edit', $task) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">{{ __('Изменить') }}</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline"
                                    onsubmit="return confirm('{{ __('Удалить задачу?') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        {{ __('Удалить') }}
                                    </button>
                                </form>
                            </td>
                            @endif
                            @endauth
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('Задач пока нет.') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>