<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-amber-900 leading-tight tracking-tight">
            {{ __('Add New Address') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#FDFBF7] min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-amber-200">
                <div class="p-8">
                    <form method="POST" action="{{ route('shipping-addresses.store') }}">
                        @csrf

                        @if(request()->has('redirect_to_cart'))
                            <input type="hidden" name="redirect_to_cart" value="1">
                        @endif

                        <div class="space-y-6">
                            <div>
                                <x-input-label for="recipient_name" value="Recipient Name" class="font-bold text-amber-900" />
                                <x-text-input id="recipient_name" name="recipient_name" type="text" class="mt-2 block w-full border-amber-200 focus:border-amber-500 rounded-xl" :value="old('recipient_name')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('recipient_name')" />
                            </div>

                            <div>
                                <x-input-label for="phone" value="Phone Number" class="font-bold text-amber-900" />
                                <x-text-input id="phone" name="phone" type="text" class="mt-2 block w-full border-amber-200 focus:border-amber-500 rounded-xl" :value="old('phone')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <div>
                                <x-input-label for="full_address" value="Full Address" class="font-bold text-amber-900" />
                                <textarea id="full_address" name="full_address" rows="3" class="mt-2 block w-full border-amber-200 focus:border-amber-500 rounded-xl shadow-sm text-amber-900" required>{{ old('full_address') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('full_address')" />
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="city" value="City" class="font-bold text-amber-900" />
                                    <x-text-input id="city" name="city" type="text" class="mt-2 block w-full border-amber-200 focus:border-amber-500 rounded-xl" :value="old('city')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('city')" />
                                </div>
                                <div>
                                    <x-input-label for="postal_code" value="Postal Code" class="font-bold text-amber-900" />
                                    <x-text-input id="postal_code" name="postal_code" type="text" class="mt-2 block w-full border-amber-200 focus:border-amber-500 rounded-xl" :value="old('postal_code')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 mt-8 pt-6 border-t border-amber-100">
                            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-full shadow-md hover:scale-105 transition-transform">
                                Save Address
                            </button>
                            <a href="{{ request()->has('redirect_to_cart') ? route('cart.index') : route('shipping-addresses.index') }}" class="text-amber-700 font-bold hover:text-amber-900 transition-colors">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
