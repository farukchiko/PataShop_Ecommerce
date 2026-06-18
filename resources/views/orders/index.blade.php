<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-amber-800 leading-tight tracking-wide">
            {{ __('My Order History') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#FDFBF7] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if (session('success'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl shadow-sm flex items-start">
                    <svg class="w-6 h-6 mr-3 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="font-bold">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm flex items-start">
                    <svg class="w-6 h-6 mr-3 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="font-bold">{{ session('error') }}</p>
                </div>
            @endif

            @if($orders->count() > 0)
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-3xl shadow-sm border border-amber-100 overflow-hidden">
                            <!-- Order Header -->
                            <div class="bg-amber-50 px-6 py-4 border-b border-amber-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex flex-wrap gap-x-8 gap-y-2">
                                    <div>
                                        <span class="block text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Order Date</span>
                                        <span class="text-sm font-semibold text-amber-900">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Total Amount</span>
                                        <span class="text-sm font-black text-amber-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Order ID</span>
                                        <span class="text-sm font-mono text-amber-700">#{{ substr($order->id, 0, 8) }}</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-4">
                                    <!-- Status Badge -->
                                    @if($order->status === 'pending')
                                        <span class="bg-amber-100 text-amber-800 text-xs font-black px-4 py-1.5 rounded-full border border-amber-200">Menunggu Proses</span>
                                    @elseif($order->status === 'packing')
                                        <span class="bg-blue-100 text-blue-800 text-xs font-black px-4 py-1.5 rounded-full border border-blue-200">Dalam Pengemasan</span>
                                    @elseif($order->status === 'shipped')
                                        <span class="bg-purple-100 text-purple-800 text-xs font-black px-4 py-1.5 rounded-full border border-purple-200 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            Dalam Pengiriman
                                        </span>
                                    @elseif($order->status === 'completed')
                                        <span class="bg-green-100 text-green-800 text-xs font-black px-4 py-1.5 rounded-full border border-green-200 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Selesai
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="p-6">
                                <div class="space-y-4">
                                    @foreach($order->order_details as $detail)
                                        <div class="flex items-center gap-4 border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                            <div class="w-16 h-16 rounded-xl overflow-hidden bg-amber-50 flex-shrink-0 border border-amber-100">
                                                @php $imgSrc = is_array($detail->product->image) ? ($detail->product->image[0] ?? 'default.jpg') : $detail->product->image; @endphp
                                                <img src="{{ asset('images/'.$imgSrc) }}" alt="{{ $detail->product->name }}" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-bold text-amber-900 line-clamp-1">{{ $detail->product->name }}</h4>
                                                <div class="text-sm text-amber-700/80 mt-1">
                                                    {{ $detail->quantity }} x Rp {{ number_format($detail->price, 0, ',', '.') }}
                                                </div>
                                                @if($order->status === 'completed')
                                                    @php
                                                        $review = \App\Models\Review::where('order_id', $order->id)
                                                                            ->where('product_id', $detail->product_id)
                                                                            ->where('user_id', Auth::id())
                                                                            ->first();
                                                    @endphp
                                                    <div class="mt-2 flex items-center gap-2">
                                                        @if(!$review)
                                                            <a href="{{ route('reviews.create', [$order->id, $detail->product_id]) }}" class="inline-block text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 px-3 py-1.5 rounded-lg shadow-sm transition-colors">Tulis Ulasan</a>
                                                        @else
                                                            <span class="inline-block text-xs font-bold text-green-700 bg-green-100 px-3 py-1.5 rounded-lg border border-green-200">Sudah Diulas</span>
                                                            @if(now()->diffInHours($review->created_at) <= 24)
                                                                <a href="{{ route('reviews.edit', $review->id) }}" class="inline-block text-xs font-bold text-amber-700 bg-amber-100 hover:bg-amber-200 px-3 py-1.5 rounded-lg border border-amber-200 transition-colors">Edit Ulasan</a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                <span class="font-black text-amber-900">Rp {{ number_format($detail->quantity * $detail->price, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Shipping Address Section -->
                                <div class="mt-6 pt-4 border-t border-amber-100">
                                    <h5 class="text-sm font-bold text-amber-900 mb-2 uppercase tracking-wider flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        Alamat Pengiriman
                                    </h5>
                                    @if($order->shippingAddress)
                                        <div class="bg-amber-50/50 p-4 rounded-xl border border-amber-200">
                                            <div class="font-bold text-amber-900 mb-1">{{ $order->shippingAddress->recipient_name }}</div>
                                            <div class="text-sm font-medium text-amber-700 mb-2">{{ $order->shippingAddress->phone }}</div>
                                            <div class="text-sm text-amber-800 leading-relaxed">{{ $order->shippingAddress->full_address }}<br>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->postal_code }}</div>
                                        </div>
                                    @else
                                        <div class="text-sm italic text-amber-700/60 font-medium">Tidak ada data alamat pengiriman.</div>
                                    @endif
                                </div>

                                <!-- Action Section -->
                                @if($order->status === 'shipped')
                                    <div class="mt-6 pt-4 border-t border-amber-100 flex flex-col items-end">
                                        <p class="text-xs text-amber-600 mb-3 text-right max-w-sm">
                                            Pesanan Anda sedang dalam pengiriman. Mohon konfirmasi jika pesanan telah diterima dengan baik. Pesanan akan otomatis selesai dalam 3 hari setelah dikirim.
                                        </p>
                                        <form action="{{ route('orders.complete', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-black px-6 py-2.5 rounded-xl shadow-md transition-colors flex items-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Pesanan Diterima
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-amber-100 flex flex-col items-center">
                    <svg class="w-24 h-24 text-amber-200 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <h3 class="text-3xl font-black text-amber-900 mb-2">Belum ada pesanan</h3>
                    <p class="text-xl text-amber-700/80 font-medium mb-8">Anda belum melakukan transaksi apapun.</p>
                    <a href="{{ route('storefront.index') }}" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-full transition duration-200 shadow-md">
                        Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
