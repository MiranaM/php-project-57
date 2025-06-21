<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Статусы') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-300">
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-700">
                                {{ __('ID') }}
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-700">
                                {{ __('Имя') }}
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-700">
                                {{ __('Дата создания') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statuses as $status)
                        <tr class="border-b border-dotted border-gray-200">
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ $status->id }}
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ $status->name }}
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ $status->created_at->format('d.m.Y') }}
                            </td>
                        </tr>
                        @endforeach
                        @if($statuses->isEmpty())
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ __('Статусов пока нет.') }}
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>