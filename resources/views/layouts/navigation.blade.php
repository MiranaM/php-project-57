<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            {{-- Название --}}
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="text-lg font-bold text-gray-800">
                    Менеджер задач
                </a>
            </div>

            {{-- Навигационные ссылки --}}
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <x-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')">
                    Задачи
                </x-nav-link>
                <x-nav-link :href="route('task_statuses.index')" :active="request()->routeIs('task_statuses.*')">
                    Статусы
                </x-nav-link>
                <x-nav-link :href="route('labels.index')" :active="request()->routeIs('labels.*')">
                    Метки
                </x-nav-link>
            </div>

            {{-- Аутентификация --}}
            <div class="flex items-center space-x-4">
                @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                        Выход
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                    Вход
                </a>
                <a href="{{ route('register') }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                    Регистрация
                </a>
                @endauth
            </div>
        </div>
    </div>
</nav>