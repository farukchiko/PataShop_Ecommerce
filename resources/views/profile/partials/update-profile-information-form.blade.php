<section>
    <header>
        <h2 class="text-2xl font-black text-amber-900 tracking-tight">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-2 text-sm text-amber-700/80 font-medium">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" class="font-bold text-amber-900" />
            <x-text-input id="name" name="name" type="text" class="mt-2 block w-full border-amber-200 focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div x-data="{ photoName: null, photoPreview: null }">
            <x-input-label for="avatar" :value="__('Profile Photo (Avatar)')" class="font-bold text-amber-900" />
            
            <div class="mt-2 flex items-center gap-6">
                <!-- Current Profile Photo -->
                <div x-show="! photoPreview">
                    @if ($user->avatar)
                        <img src="{{ asset('avatars/' . $user->avatar) }}" alt="Avatar" class="h-16 w-16 rounded-full object-cover border-2 border-amber-200 shadow-sm">
                    @else
                        <div class="h-16 w-16 rounded-full bg-amber-100 flex items-center justify-center border-2 border-amber-200 shadow-sm text-amber-500">
                            <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- New Profile Photo Preview -->
                <div x-show="photoPreview" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100">
                    <span class="block h-16 w-16 rounded-full bg-cover bg-no-repeat bg-center border-2 border-amber-400 shadow-md"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>
                
                <div>
                    <input id="avatar" name="avatar" type="file" accept="image/*" class="hidden" x-ref="photo" 
                           x-on:change="
                                photoName = $refs.photo.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    photoPreview = e.target.result;
                                };
                                reader.readAsDataURL($refs.photo.files[0]);
                           " />
                           
                    <button type="button" x-on:click.prevent="$refs.photo.click()" class="inline-flex items-center px-4 py-2 bg-white border border-amber-300 rounded-full font-semibold text-xs text-amber-700 uppercase tracking-widest shadow-sm hover:bg-amber-50 hover:scale-105 active:scale-95 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-all duration-200 ease-in-out">
                        Select a New Photo
                    </button>
                    <p class="mt-2 text-xs text-amber-600 font-medium" x-show="photoName" x-text="photoName" x-transition></p>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="font-bold text-amber-900" />
            <x-text-input id="email" name="email" type="email" class="mt-2 block w-full border-amber-200 focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-amber-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-amber-600 hover:text-amber-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 font-bold">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 bg-green-50 p-2 rounded-lg border border-green-200">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-amber-50">
            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-sm transition-colors">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
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
