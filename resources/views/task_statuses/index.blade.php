<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Статусы') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">

                @auth
                <div class="px-6 py-4">
                    <a href="{{ route('task_statuses.create') }}"
                        class="inline-block bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded text-sm font-semibold">
                        Новый статус
                    </a>
                </div>
                @endauth

                <table class="min-w-full text-sm border-collapse">
                    <thead>
                        <tr class="border-b border-gray-300 text-left text-gray-700">
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Имя</th>
                            <th class="px-6 py-3">Дата создания</th>
                            @auth
                            <th class="px-6 py-3">Действия</th>
                            @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($statuses as $status)
                        <tr class="border-b border-dotted hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $status->id }}</td>
                            <td class="px-6 py-3">{{ $status->name }}</td>
                            <td class="px-6 py-3">{{ $status->created_at->format('d.m.Y') }}</td>
                            @auth
                            <td class="px-6 py-3 whitespace-nowrap">
                                <a href="{{ route('task_statuses.edit', $status) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">Изменить</a>
                                <form action="{{ route('task_statuses.destroy', $status) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Удалить статус?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Удалить</button>
                                </form>
                            </td>
                            @endauth
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Статусов пока нет.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>