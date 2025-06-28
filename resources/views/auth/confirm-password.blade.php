<x-guest-layout>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Пароль')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm>
                {{ __('Подтвердить') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>