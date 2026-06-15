@extends('layouts.main')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-4xl font-black text-amber-900 tracking-tight">Order Management</h2>
            <p class="text-amber-700/80 mt-2 font-medium">Review and update customer orders.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl shadow-sm flex items-start mb-6">
            <svg class="w-6 h-6 mr-3 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="font-bold">{{ session('success') }}</p>
        </div>
    @endif
    
    @if (session('error'))
        <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm flex items-start mb-6">
            <svg class="w-6 h-6 mr-3 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="font-bold">{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white p-8 rounded-3xl shadow-sm border border-amber-100">
        @if($orders->count() > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                <div class="border border-amber-100 rounded-2xl overflow-hidden hover:border-amber-300 transition-colors">
                    
                    <!-- Order Header -->
                    <div class="bg-amber-50 px-6 py-4 flex flex-col lg:flex-row lg:items-center justify-between gap-4 border-b border-amber-100">
                        <div class="flex flex-wrap gap-x-8 gap-y-2">
                            <div>
                                <span class="block text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Order Date</span>
                                <span class="text-sm font-semibold text-amber-900">{{ $order->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Customer</span>
                                <span class="text-sm font-bold text-amber-900">{{ $order->user->name }} <br> <span class="font-normal text-xs text-amber-700">{{ $order->user->email }}</span></span>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Total</span>
                                <span class="text-sm font-black text-amber-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Status</span>
                                @if($order->status === 'pending')
                                    <span class="bg-amber-100 text-amber-800 text-xs font-black px-3 py-1 rounded-full border border-amber-200">Pending</span>
                                @elseif($order->status === 'packing')
                                    <span class="bg-blue-100 text-blue-800 text-xs font-black px-3 py-1 rounded-full border border-blue-200">Packing</span>
                                @elseif($order->status === 'shipped')
                                    <span class="bg-purple-100 text-purple-800 text-xs font-black px-3 py-1 rounded-full border border-purple-200 flex items-center inline-flex">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        Shipped
                                    </span>
                                @elseif($order->status === 'completed')
                                    <span class="bg-green-100 text-green-800 text-xs font-black px-3 py-1 rounded-full border border-green-200 flex items-center inline-flex">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Completed
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Admin Action -->
                        <div class="lg:text-right">
                            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="border-amber-200 text-sm font-bold text-amber-900 focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm py-2 px-3" {{ $order->status === 'completed' ? 'disabled' : '' }}>
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="packing" {{ $order->status === 'packing' ? 'selected' : '' }}>Packing</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded-xl shadow-sm transition-colors text-sm" {{ $order->status === 'completed' ? 'disabled' : '' }}>
                                    Update
                                </button>
                            </form>
                            @if($order->status === 'shipped' && $order->shipped_at)
                                <p class="text-xs text-amber-600/70 mt-2 font-medium">Shipped on: {{ $order->shipped_at->format('d M, H:i') }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Order Items (Collapsible/Simple List) -->
                    <div class="p-6">
                        <h4 class="text-sm font-bold text-amber-900 mb-3 uppercase tracking-wider">Ordered Items</h4>
                        <div class="flex flex-col gap-2">
                            @foreach($order->order_details as $detail)
                                <div class="flex justify-between items-center text-sm border-b border-amber-50 pb-2 last:border-0 last:pb-0">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-amber-100 overflow-hidden border border-amber-200">
                                            @php $imgSrc = is_array($detail->product->image) ? ($detail->product->image[0] ?? 'default.jpg') : $detail->product->image; @endphp
                                            <img src="{{ asset('images/'.$imgSrc) }}" alt="{{ $detail->product->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <span class="font-semibold text-amber-900">{{ $detail->product->name }}</span>
                                    </div>
                                    <div class="text-amber-700">
                                        {{ $detail->quantity }} x Rp {{ number_format($detail->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 text-amber-700/50 italic font-medium">
                <svg class="mx-auto h-16 w-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <p class="text-lg">No orders found.</p>
            </div>
        @endif
    </div>
@endsection
