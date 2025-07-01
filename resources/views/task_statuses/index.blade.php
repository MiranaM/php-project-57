<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Статусы') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-4">
                @auth
                <a href="{{ route('task_statuses.create') }}"
                    class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                    Создать статус
                </a>
                @endauth
            </div>

            <div class="overflow-x-auto bg-white shadow rounded">
                <table class="min-w-full border divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Имя</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Дата создания</th>
                            @canany(['update', 'delete'], new \App\Models\TaskStatus())
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Действия</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($statuses as $status)
                        <tr>
                            <td class="px-4 py-2 text-sm">{{ $status->id }}</td>
                            <td class="px-4 py-2 text-sm">{{ $status->name }}</td>
                            <td class="px-4 py-2 text-sm">{{ $status->created_at->format('d.m.Y') }}</td>
                            @canany(['update', 'delete'], $status)
                            <td>
                                @can('delete', $status)
                                <a class="text-red-600 hover:text-red-900" href="#" onclick="if(confirm('Вы уверены, что хотите удалить метку?')) {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{ $status->id }}').submit();
                                }">
                                    Удалить
                                </a>
                                <form id="delete-form-{{ $status->id }}"
                                    action="{{ route('task_statuses.destroy', $status) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endcan

                                @can('update', $status)
                                <a href="{{ route('task_statuses.edit', $status) }}"
                                    class="text-blue-600 hover:text-blue-900">Изменить</a>
                                @endcan
                            </td>
                            @endcanany
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>