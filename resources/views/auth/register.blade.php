<x-guest-layout>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="w-full max-w-lg bg-white rounded shadow-md p-8">
            <h1 class="text-2xl text-center font-semibold mb-6">Менеджер задач</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Имя</label>
                    <input id="name" name="name" type="text" required autofocus value="{{ old('name') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Пароль</label>
                    <input id="password" name="password" type="password" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <label for="password_confirmation"
                        class="block text-sm font-medium text-gray-700">Подтверждение</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                        Уже зарегистрированы?
                    </a>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Зарегистрироваться
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>