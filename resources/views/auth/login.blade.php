<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-amber-900">Welcome Back</h2>
        <p class="text-amber-700/80 mt-1">Please sign in to your account</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-amber-900 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border-amber-300 focus:border-amber-500 focus:ring-amber-500 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-amber-900 font-semibold" />

            <x-text-input id="password" class="block mt-1 w-full border-amber-300 focus:border-amber-500 focus:ring-amber-500 rounded-md shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-amber-300 text-amber-600 shadow-sm focus:ring-amber-500" name="remember">
                <span class="ms-2 text-sm text-amber-800 font-medium">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-amber-600 hover:text-amber-900 font-medium transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200">
                {{ __('Log in') }}
            </button>
        </div>
        
        <div class="mt-6 text-center text-sm text-amber-800">
            Don't have an account? 
            <a href="{{ route('register') }}" class="font-bold text-amber-600 hover:text-amber-900 hover:underline">Sign up</a>
        </div>
    </form>
</x-guest-layout>
