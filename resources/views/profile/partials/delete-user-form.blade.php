<section class="space-y-6">
    <header>
        <h2 class="text-2xl font-black text-red-900 tracking-tight">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-2 text-sm text-red-700/80 font-medium">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-100 hover:bg-red-200 text-red-700 font-bold py-2.5 px-6 rounded-xl transition-colors border border-red-200"
    >{{ __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-xl font-black text-red-900 mb-2">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="text-sm text-red-700/80 font-medium mb-6">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full border-red-200 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-red-50">
                <button type="button" x-on:click="$dispatch('close')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-6 rounded-xl transition-colors">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-xl shadow-sm transition-colors">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
