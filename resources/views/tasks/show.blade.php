<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $task->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 bg-white shadow-sm sm:rounded-lg p-6">
            <div class="mb-4">
                <h3 class="font-medium text-lg">{{ __('Описание') }}</h3>
                <p class="mt-1 text-gray-900 whitespace-pre-line">
                    {{ $task->description ?: __('— не указано —') }}
                </p>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <h3 class="font-medium">{{ __('Статус') }}</h3>
                    <p class="mt-1 text-gray-900">{{ $task->status->name }}</p>
                </div>
                <div>
                    <h3 class="font-medium">{{ __('Исполнитель') }}</h3>
                    <p class="mt-1 text-gray-900">
                        {{ optional($task->assignee)->name ?? __('— не назначен —') }}
                    </p>
                </div>
            </div>

            <div class="mb-4">
                <h3 class="font-medium">{{ __('Метки') }}</h3>
                <div class="mt-2">
                    @forelse($task->labels as $label)
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-medium text-gray-800 mr-1 mb-1">
                            {{ $label->name }}
                        </span>
                    @empty
                        <p class="text-gray-500">{{ __('Нет меток') }}</p>
                    @endforelse
                </div>
            </div>

            <div class="flex space-x-2">
                @auth
                    @if(auth()->id() === $task->created_by_id)
                        <a href="{{ route('tasks.edit', $task) }}"
                           class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-500">
                            {{ __('Редактировать') }}
                        </a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                              onsubmit="return confirm('{{ __('Удалить задачу?') }}')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-500">
                                {{ __('Удалить') }}
                            </button>
                        </form>
                    @endif
                @endauth
                <a href="{{ route('tasks.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                    {{ __('Назад к задачам') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
