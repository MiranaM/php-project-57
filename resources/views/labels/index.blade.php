<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Метки') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                @auth
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('labels.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent
                                  rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                  hover:bg-indigo-500 focus:outline-none focus:ring focus:ring-indigo-300 transition">
                        {{ __('Создать метку') }}
                    </a>
                </div>
                @endauth

                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-300">
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-700">ID</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-700">Имя</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-700">Описание</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-700">Дата создания</th>
                            @auth
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-700">Действия</th>
                            @endauth
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($labels as $label)
                        <tr class="border-b border-dotted border-gray-200">
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">{{ $label->id }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">{{ $label->name }}</td>
                            <td class="px-6 py-3 text-sm text-gray-900">{{ $label->description }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ $label->created_at->format('d.m.Y') }}
                            </td>
                            @auth
                            <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('labels.edit', $label) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">{{ __('Изменить') }}</a>
                                <form action="{{ route('labels.destroy', $label) }}" method="POST" class="inline"
                                    onsubmit="return confirm('{{ __('Удалить метку?') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        {{ __('Удалить') }}
                                    </button>
                                </form>
                            </td>
                            @endauth
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('Меток пока нет.') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>