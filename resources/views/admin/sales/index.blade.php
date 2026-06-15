@extends('layouts.main')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-4xl font-black text-amber-900 tracking-tight">Sales Report</h2>
            <p class="text-amber-700/80 mt-2 font-medium">Overview of your revenue and transaction history.</p>
        </div>
    </div>

    <!-- Analytics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gradient-to-br from-amber-600 to-amber-800 p-8 rounded-3xl shadow-lg border border-amber-500 text-white flex items-center relative overflow-hidden">
            <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-amber-500 opacity-20" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path></svg>
            <div>
                <h3 class="text-amber-100 font-bold uppercase tracking-wider text-sm mb-1">Total Revenue</h3>
                <p class="text-4xl font-black">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-amber-100 flex items-center">
            <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center mr-6">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <div>
                <h3 class="text-amber-600 font-bold uppercase tracking-wider text-sm mb-1">Total Orders</h3>
                <p class="text-4xl font-black text-amber-900">{{ number_format($totalSales, 0, ',', '.') }} <span class="text-lg font-medium text-amber-700/60">transactions</span></p>
            </div>
        </div>
    </div>

    <!-- Sales History Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-amber-100 overflow-hidden">
        <div class="px-8 py-5 border-b border-amber-50 bg-amber-50/50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-amber-900">Transaction History</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-amber-100 text-xs uppercase tracking-wider text-amber-600 font-bold">
                        <th class="px-8 py-4">Order ID</th>
                        <th class="px-8 py-4">Date</th>
                        <th class="px-8 py-4">Customer</th>
                        <th class="px-8 py-4">Items</th>
                        <th class="px-8 py-4 text-right">Revenue</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-medium text-amber-900">
                    @forelse($orders as $order)
                        <tr class="border-b border-amber-50 hover:bg-amber-50/30 transition-colors last:border-0">
                            <td class="px-8 py-4 font-mono text-amber-700">#{{ substr($order->id, 0, 8) }}</td>
                            <td class="px-8 py-4 text-amber-800">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-8 py-4">
                                <span class="font-bold block">{{ $order->user->name }}</span>
                                <span class="text-xs text-amber-600/70">{{ $order->user->email }}</span>
                            </td>
                            <td class="px-8 py-4">
                                <span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full">
                                    {{ $order->order_details->count() }} items
                                </span>
                            </td>
                            <td class="px-8 py-4 text-right font-black text-green-600">
                                + Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-amber-600/70 italic">
                                No sales recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
