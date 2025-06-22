<x-guest-layout>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="w-full max-w-lg bg-white rounded shadow-md p-8">
            <h1 class="text-2xl text-center font-semibold mb-6">Менеджер задач</h1>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required autofocus value="{{ old('email') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Пароль</label>
                    <input id="password" name="password" type="password" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mb-4 flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-600">
                        Запомнить меня
                    </label>
                </div>

                <div class="flex justify-between items-center">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-sm text-gray-600 hover:text-gray-900 underline">
                        Забыли пароль?
                    </a>
                    @endif

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Войти
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>