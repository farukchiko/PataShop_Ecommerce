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

                        <div class="mt-8 flex flex-col md:flex-row justify-between items-center bg-amber-50 border border-amber-100 p-6 rounded-xl shadow-sm">
                            <div class="mb-4 md:mb-0">
                                <span class="text-amber-800 text-lg font-medium">Your Balance: </span>
                                <span class="text-xl font-bold text-green-600 ml-2">Rp {{ number_format(Auth::user()->money, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center space-x-6">
                                <div class="text-right">
                                    <span class="text-amber-800 text-lg font-medium">Total Amount:</span>
                                    <div class="text-3xl font-black text-amber-700">Rp {{ number_format($total, 0, ',', '.') }}</div>
                                </div>
                                <form action="{{ route('checkout.store') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-4 px-8 rounded-xl shadow-md transform transition duration-200 hover:-translate-y-1 text-lg">
                                        Checkout Now
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
