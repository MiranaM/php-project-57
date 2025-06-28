<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Задача: {{ $task->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow rounded px-6 py-4">

                <div class="mb-4">
                    <strong class="text-gray-700">Имя:</strong>
                    <p>{{ $task->name }}</p>
                </div>

                <div class="mb-4">
                    <strong class="text-gray-700">Описание:</strong>
                    <p>{{ $task->description ?? '—' }}</p>
                </div>

                <div class="mb-4">
                    <strong class="text-gray-700">Статус:</strong>
                    <p>{{ $task->status->name }}</p>
                </div>

                <div class="mb-4">
                    <strong class="text-gray-700">Автор:</strong>
                    <p>{{ $task->creator->name }}</p>
                </div>

                <div class="mb-4">
                    <strong class="text-gray-700">Исполнитель:</strong>
                    <p>{{ $task->assignee?->name ?? '—' }}</p>
                </div>

                <div class="mb-4">
                    <strong class="text-gray-700">Дата создания:</strong>
                    <p>{{ $task->created_at->format('d.m.Y') }}</p>
                </div>

                <div class="mb-4">
                    <strong class="text-gray-700">Метки:</strong>
                    <ul class="list-disc list-inside text-sm text-gray-800">
                        @forelse ($task->labels as $label)
                        <li>{{ $label->name }}</li>
                        @empty
                        <li>—</li>
                        @endforelse
                    </ul>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>