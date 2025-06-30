<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Изменить метку</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto">
            <form method="POST" action="{{ route('labels.update', $label) }}"
                class="bg-white shadow-md rounded px-8 pt-6 pb-8">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-sm font-bold mb-2">Имя</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $label->name) }}"
                        class="border rounded w-full p-2">
                    @error('name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-bold mb-2">Описание</label>
                    <input type="text" name="description" id="description"
                        value="{{ old('description', $label->description) }}" class="border rounded w-full p-2">
                    @error('description') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>
                <button class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded"
                    type="submit">Обновить</button>
            </form>
        </div>
    </div>
</x-app-layout>