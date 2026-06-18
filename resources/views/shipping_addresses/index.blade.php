<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-amber-900 leading-tight tracking-tight">
            {{ __('My Addresses') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#FDFBF7] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl shadow-sm flex items-center mb-6">
                    <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="block sm:inline font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-bold text-amber-900">Saved Addresses</h3>
                    <p class="text-amber-700 font-medium">Manage where your orders will be shipped.</p>
                </div>
                <a href="{{ route('shipping-addresses.create') }}" class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-full font-bold text-sm text-white hover:bg-amber-700 focus:bg-amber-700 active:bg-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 shadow-md hover:scale-105 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add New Address
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($addresses as $address)
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-amber-200 flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-lg font-black text-amber-900">{{ $address->recipient_name }}</h4>
                                <span class="bg-amber-100 text-amber-800 text-xs font-bold px-2.5 py-1 rounded-full border border-amber-200">Home</span>
                            </div>
                            
                            <div class="space-y-2 text-sm text-amber-800 font-medium mb-6">
                                <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> {{ $address->phone }}</p>
                                <p class="flex items-start"><svg class="w-4 h-4 mr-2 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> <span class="leading-relaxed">{{ $address->full_address }}<br>{{ $address->city }}, {{ $address->postal_code }}</span></p>
                            </div>
                        </div>

                        <div class="flex space-x-3 pt-4 border-t border-amber-100">
                            <a href="{{ route('shipping-addresses.edit', $address) }}" class="flex-1 text-center bg-amber-50 text-amber-700 hover:bg-amber-100 hover:text-amber-900 font-bold py-2 rounded-xl transition-colors border border-amber-200">
                                Edit
                            </a>
                            <form action="{{ route('shipping-addresses.destroy', $address) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this address?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-50 text-red-600 hover:bg-red-100 font-bold py-2 rounded-xl transition-colors border border-red-200">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-12 rounded-3xl shadow-sm border border-amber-200 text-center flex flex-col items-center">
                        <div class="w-20 h-20 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mb-6 border-4 border-amber-50">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </div>
                        <h4 class="text-2xl font-black text-amber-900 mb-2">No addresses found</h4>
                        <p class="text-amber-700 font-medium mb-6">You haven't saved any shipping addresses yet.</p>
                        <a href="{{ route('shipping-addresses.create') }}" class="inline-flex items-center px-6 py-3 bg-amber-600 border border-transparent rounded-full font-bold text-white hover:bg-amber-700 shadow-md hover:scale-105 transition-all duration-200">
                            Add Your First Address
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
