<section>
    <header>
        <h2 class="text-2xl font-black text-amber-900 tracking-tight">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-2 text-sm text-amber-700/80 font-medium">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="font-bold text-amber-900" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-2 block w-full border-amber-200 focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="font-bold text-amber-900" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-2 block w-full border-amber-200 focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="font-bold text-amber-900" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-2 block w-full border-amber-200 focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-amber-50">
            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-sm transition-colors">
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-bold text-green-600 flex items-center bg-green-50 px-3 py-1.5 rounded-lg border border-green-200"
                >
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
