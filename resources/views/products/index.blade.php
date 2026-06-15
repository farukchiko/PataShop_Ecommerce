@extends('layouts.main')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-black text-amber-900 tracking-tight">Product List</h2>
        <a href="{{ route('products.create') }}" class="bg-amber-600 hover:bg-amber-700 text-white font-bold px-4 py-2 rounded-lg shadow-md transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Product
        </a>
    </div>

    <div class="mb-8 bg-white p-4 rounded-xl shadow-sm border border-amber-100 flex items-center">
        <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap gap-4 w-full items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-semibold text-amber-900 mb-1">Search Product</label>
                <input type="text" name="search" placeholder="E.g. Laptop, Cake..." class="w-full border-amber-200 focus:border-amber-500 focus:ring-amber-500 rounded-lg shadow-sm text-amber-900">
            </div>
            <div>
                <label class="block text-sm font-semibold text-amber-900 mb-1">Min Price</label>
                <input type="number" name="min_price" placeholder="0" class="w-32 border-amber-200 focus:border-amber-500 focus:ring-amber-500 rounded-lg shadow-sm text-amber-900">
            </div>
            <div>
                <label class="block text-sm font-semibold text-amber-900 mb-1">Max Price</label>
                <input type="number" name="max_price" placeholder="9999999" class="w-32 border-amber-200 focus:border-amber-500 focus:ring-amber-500 rounded-lg shadow-sm text-amber-900">
            </div>
            <button type="submit" class="bg-amber-100 text-amber-800 hover:bg-amber-200 font-bold px-6 py-2.5 rounded-lg shadow-sm transition-colors border border-amber-300">
                Filter
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($products as $product)
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-amber-100 hover:shadow-md transition-shadow">
                @php $imgSrc = is_array($product->image) ? ($product->image[0] ?? 'default.jpg') : $product->image; @endphp
                <img src="{{ asset('images/'.$imgSrc) }}" class="w-full h-48 object-cover rounded-xl mb-4 border border-amber-50">
                <h3 class="text-xl font-bold text-amber-900 mb-1">{{ $product->name }}</h3>
                <p class="text-amber-700/80 mb-3 text-sm h-10 overflow-hidden">{{ Str::limit($product->description, 60) }}</p>
                <div class="flex justify-between items-center mb-4 pb-4 border-b border-amber-50">
                    <p class="font-black text-amber-600 text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <span class="text-xs font-bold text-amber-600/70 bg-amber-100 px-2 py-1 rounded-md border border-amber-200">Stock: {{ $product->stock }}</span>
                </div>

                <div class="flex space-x-2 text-sm font-semibold">
                    <a href="{{ route('products.show', $product->id) }}" class="flex-1 text-center bg-amber-50 text-amber-700 hover:bg-amber-100 px-3 py-2 rounded-lg transition-colors border border-amber-200">View</a>
                    <a href="{{ route('products.edit', $product->id) }}" class="flex-1 text-center bg-orange-100 text-orange-700 hover:bg-orange-200 px-3 py-2 rounded-lg transition-colors border border-orange-200">Edit</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button class="w-full text-center bg-red-100 text-red-700 hover:bg-red-200 px-3 py-2 rounded-lg transition-colors border border-red-200" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection