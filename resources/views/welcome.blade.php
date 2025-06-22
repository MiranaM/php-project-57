<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl font-bold mb-4">Привет от Хекслета!</h1>
            <p class="text-xl text-gray-500 mb-6">Это простой менеджер задач на Laravel</p>
            <a href="{{ route('tasks.index') }}"
                class="inline-block px-6 py-2 border border-gray-800 rounded font-medium hover:bg-gray-100">
                Нажми меня
            </a>
        </div>
    </div>
</x-app-layout>