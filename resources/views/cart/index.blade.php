<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-amber-700 leading-tight">
            {{ __('Your Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#FDFBF7] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm mb-6" role="alert">
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg shadow-sm mb-6" role="alert">
                    <span class="block sm:inline font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-amber-100">
                <div class="p-6 sm:p-8">
                    @if($carts->isEmpty())
                        <div class="text-center py-16 bg-amber-50/50 rounded-xl border border-amber-100">
                            <h3 class="text-2xl font-semibold text-amber-800 mb-4">Your cart is empty</h3>
                            <a href="{{ route('storefront.index') }}" class="text-amber-600 hover:text-amber-800 font-medium text-lg inline-flex items-center transition-colors">Continue Shopping <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b-2 border-amber-100 text-amber-800 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6">Product</th>
                                        <th class="py-3 px-6">Price</th>
                                        <th class="py-3 px-6 text-center">Quantity</th>
                                        <th class="py-3 px-6 text-right">Subtotal</th>
                                        <th class="py-3 px-6 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-amber-900 text-sm">
                                    @php $total = 0; @endphp
                                    @foreach($carts as $cart)
                                        @php $subtotal = $cart->product->price * $cart->quantity; $total += $subtotal; @endphp
                                        <tr class="border-b border-amber-50 hover:bg-amber-50/50 transition-colors">
                                            <td class="py-4 px-6 flex items-center">
                                                @php $imgSrc = is_array($cart->product->image) ? ($cart->product->image[0] ?? 'default.jpg') : $cart->product->image; @endphp
                                                <img src="{{ asset('images/'.$imgSrc) }}" class="w-16 h-16 object-cover rounded-md mr-4 shadow-sm border border-amber-100">
                                                <span class="font-bold text-amber-900">{{ $cart->product->name }}</span>
                                            </td>
                                            <td class="py-4 px-6 font-medium text-amber-700">Rp {{ number_format($cart->product->price, 0, ',', '.') }}</td>
                                            <td class="py-4 px-6 text-center">
                                                <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="flex justify-center items-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->stock }}" class="w-16 text-center border-amber-200 focus:border-amber-500 focus:ring-amber-500 rounded-l-md shadow-sm text-sm bg-[#FDFBF7] text-amber-900">
                                                    <button type="submit" class="bg-amber-100 hover:bg-amber-200 text-amber-800 py-2 px-3 rounded-r-md transition duration-150 ease-in-out text-sm border-y border-r border-amber-200 font-medium">
                                                        Update
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="py-4 px-6 text-right font-bold text-amber-700">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                            <td class="py-4 px-6 text-center">
                                                <form action="{{ route('cart.destroy', $cart->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-400 hover:text-red-600 font-medium transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 border border-amber-100 rounded-2xl overflow-hidden shadow-sm">
                            <form action="{{ route('checkout.store') }}" method="POST">
                                @csrf
                                <!-- Address Selection Section -->
                                <div class="bg-white p-6 border-b border-amber-100">
                                    <h4 class="text-lg font-bold text-amber-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        Shipping Address
                                    </h4>
                                    
                                    @if($addresses->isEmpty())
                                        <div class="bg-orange-50 border border-orange-200 p-4 rounded-xl flex flex-col sm:flex-row justify-between items-center gap-4">
                                            <div class="flex items-center text-orange-800">
                                                <svg class="w-6 h-6 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                <span class="font-medium text-sm sm:text-base">You must add a shipping address before you can checkout.</span>
                                            </div>
                                            <a href="{{ route('shipping-addresses.create', ['redirect_to_cart' => 1]) }}" class="whitespace-nowrap bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded-full shadow-md transition-all duration-200 hover:scale-105">
                                                Add New Address
                                            </a>
                                        </div>
                                    @else
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach($addresses as $address)
                                                <label class="relative flex cursor-pointer rounded-xl border border-amber-200 bg-white p-4 shadow-sm hover:bg-amber-50 focus-within:ring-2 focus-within:ring-amber-500 transition-colors">
                                                    <input type="radio" name="shipping_address_id" value="{{ $address->id }}" class="peer sr-only" {{ $loop->first ? 'checked' : '' }} required>
                                                    
                                                    <div class="flex flex-col w-full peer-checked:text-amber-900">
                                                        <div class="flex items-center justify-between">
                                                            <span class="text-sm font-bold text-amber-900">{{ $address->recipient_name }}</span>
                                                            <svg class="hidden h-5 w-5 text-amber-600 peer-checked:block" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                                        </div>
                                                        <span class="mt-1 text-xs text-amber-700">{{ $address->phone }}</span>
                                                        <span class="mt-2 text-xs text-amber-800 leading-relaxed line-clamp-2">{{ $address->full_address }}, {{ $address->city }}, {{ $address->postal_code }}</span>
                                                    </div>
                                                    
                                                    <!-- Checked styling wrapper -->
                                                    <div class="absolute -inset-px rounded-xl border-2 border-transparent peer-checked:border-amber-500 pointer-events-none" aria-hidden="true"></div>
                                                </label>
                                            @endforeach
                                        </div>
                                        <div class="mt-4 text-right">
                                            <a href="{{ route('shipping-addresses.create', ['redirect_to_cart' => 1]) }}" class="text-sm font-bold text-amber-600 hover:text-amber-800 underline transition-colors">+ Add Another Address</a>
                                        </div>
                                    @endif
                                </div>

                                <!-- Summary & Checkout Button Section -->
                                <div class="flex flex-col md:flex-row justify-between items-center bg-amber-50/80 p-6 md:p-8">
                                    <div class="mb-6 md:mb-0 bg-white px-6 py-4 rounded-xl border border-amber-200 shadow-sm w-full md:w-auto">
                                        <span class="text-amber-800 text-sm font-bold uppercase tracking-wider block mb-1">Your E-Wallet Balance</span>
                                        <span class="text-2xl font-black text-green-600 flex items-center">
                                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                            Rp {{ number_format(Auth::user()->money, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="flex flex-col sm:flex-row items-center gap-6 w-full md:w-auto">
                                        <div class="text-center sm:text-right w-full sm:w-auto">
                                            <span class="text-amber-800 text-sm font-bold uppercase tracking-wider block mb-1">Total Amount</span>
                                            <div class="text-3xl font-black text-amber-700">Rp {{ number_format($total, 0, ',', '.') }}</div>
                                        </div>
                                        
                                        <button type="submit" 
                                            class="w-full sm:w-auto text-white font-bold py-4 px-10 rounded-xl shadow-lg transform transition duration-200 text-lg flex items-center justify-center
                                            {{ $addresses->isEmpty() ? 'bg-gray-400 cursor-not-allowed' : 'bg-amber-600 hover:bg-amber-700 hover:-translate-y-1 hover:shadow-xl' }}"
                                            {{ $addresses->isEmpty() ? 'disabled' : '' }}>
                                            Checkout Now
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
