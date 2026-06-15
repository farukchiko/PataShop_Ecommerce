<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-amber-900">Create an Account</h2>
        <p class="text-amber-700/80 mt-1">Join Patashop today and get 1,000,000 IDR bonus!</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-amber-900 font-semibold" />
            <x-text-input id="name" class="block mt-1 w-full border-amber-300 focus:border-amber-500 focus:ring-amber-500 rounded-md shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-amber-900 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border-amber-300 focus:border-amber-500 focus:ring-amber-500 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-amber-900 font-semibold" />

            <x-text-input id="password" class="block mt-1 w-full border-amber-300 focus:border-amber-500 focus:ring-amber-500 rounded-md shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-amber-900 font-semibold" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full border-amber-300 focus:border-amber-500 focus:ring-amber-500 rounded-md shadow-sm"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-amber-600 hover:text-amber-900 font-medium transition-colors" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</x-guest-layout>
