<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Левая часть: название + ссылки -->
            <div class="flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-lg font-bold text-gray-900">
                    Менеджер задач
                </a>

                <a href="{{ route('tasks.index') }}"
                    class="text-sm font-medium text-gray-700 hover:text-gray-900 {{ request()->routeIs('tasks.*') ? 'font-bold' : '' }}">
                    Задачи
                </a>

                <a href="{{ route('task_statuses.index') }}"
                    class="text-sm font-medium text-gray-700 hover:text-gray-900 {{ request()->routeIs('task_statuses.*') ? 'font-bold' : '' }}">
                    Статусы
                </a>

                <a href="{{ route('labels.index') }}"
                    class="text-sm font-medium text-gray-700 hover:text-gray-900 {{ request()->routeIs('labels.*') ? 'font-bold' : '' }}">
                    Метки
                </a>
            </div>

            <!-- Правая часть: Вход / Регистрация или профиль -->
            <div class="flex items-center space-x-2">
                @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="text-sm bg-blue-500 hover:bg-blue-600 text-white font-medium px-3 py-1.5 rounded">
                        Выход
                    </button>
                </form>
                @else
                @guest
                <a href="{{ route('login') }}"
                    class="text-sm bg-blue-500 hover:bg-blue-600 text-white font-medium px-3 py-1.5 rounded">
                    Login
                </a>
                @endguest
                @if (Route::has('register'))
                @guest
                <a href="{{ route('register') }}"
                    class="text-sm bg-blue-500 hover:bg-blue-600 text-white font-medium px-3 py-1.5 rounded">
                    Регистрация
                </a>
                @endguest
                @endif
                @endauth
            </div>
        </div>
    </div>
</nav>