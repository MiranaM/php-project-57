<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Редактировать задачу') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf @method('PATCH')

                        {{-- Name --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Имя') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $task->name) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                          focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
                            @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700">{{ __('Описание') }}</label>
                            <textarea name="description" id="description" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                             focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label for="status_id"
                                class="block text-sm font-medium text-gray-700">{{ __('Статус') }}</label>
                            <select name="status_id" id="status_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                           focus:border-indigo-500 focus:ring-indigo-500 @error('status_id') border-red-500 @enderror">
                                @foreach($statuses as $status)
                                <option value="{{ $status->id }}"
                                    {{ old('status_id', $task->status_id) == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('status_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Assignee --}}
                        <div class="mb-4">
                            <label for="assigned_to_id"
                                class="block text-sm font-medium text-gray-700">{{ __('Исполнитель') }}</label>
                            <select name="assigned_to_id" id="assigned_to_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                           focus:border-indigo-500 focus:ring-indigo-500 @error('assigned_to_id') border-red-500 @enderror">
                                <option value="">{{ __('— не назначен —') }}</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('assigned_to_id', $task->assigned_to_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('assigned_to_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Labels --}}
                        <div class="mb-4">
                            <fieldset>
                                <legend class="block text-sm font-medium text-gray-700">{{ __('Метки') }}</legend>
                                <div class="mt-2 space-y-2">
                                    @foreach($labels as $label)
                                    <div>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="labels[]" value="{{ $label->id }}"
                                                {{ in_array($label->id, old('labels', $task->labels->pluck('id')->toArray())) ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            <span class="ml-2 text-sm text-gray-700">{{ $label->name }}</span>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @error('labels')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </fieldset>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent
                                      rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest
                                      hover:bg-gray-300 focus:outline-none transition">
                                {{ __('Отмена') }}
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent
                                           rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                           hover:bg-indigo-500 focus:outline-none focus:ring focus:ring-indigo-300 transition">
                                {{ __('Обновить') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>