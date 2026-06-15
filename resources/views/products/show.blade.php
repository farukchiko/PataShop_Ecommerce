@extends('layouts.main')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-4xl font-black text-amber-900 tracking-tight">Product Detail</h2>
            <p class="text-amber-700/80 mt-2 font-medium">Viewing details for {{ $product->name }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('products.index') }}" class="bg-white border border-amber-200 text-amber-700 hover:bg-amber-50 font-bold px-6 py-2.5 rounded-lg shadow-sm transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back
            </a>
            <a href="{{ route('products.edit', $product->id) }}" class="bg-amber-600 hover:bg-amber-700 text-white font-bold px-6 py-2.5 rounded-lg shadow-sm transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Main Details -->
        <div class="xl:col-span-2 space-y-8">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-amber-100">
                <h3 class="text-2xl font-black text-amber-900 mb-2">{{ $product->name }}</h3>
                <p class="text-3xl font-black text-amber-600 mb-6">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                
                <div class="prose prose-amber max-w-none text-amber-900/80 mb-8">
                    <p>{{ $product->description }}</p>
                </div>

                <div class="flex items-center space-x-4 border-t border-amber-100 pt-6">
                    <div class="bg-amber-50 px-4 py-3 rounded-xl border border-amber-200">
                        <span class="text-sm font-bold text-amber-700 block mb-1">Current Stock</span>
                        <span class="text-xl font-black {{ $product->stock > 10 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $product->stock }} units
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Media -->
        <div class="xl:col-span-1">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-amber-100">
                <h3 class="text-xl font-black text-amber-900 mb-6 border-b border-amber-100 pb-4">Product Images</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    @if(is_array($product->image))
                        @foreach($product->image as $index => $img)
                            <div class="relative aspect-square rounded-xl overflow-hidden border-2 border-amber-200 shadow-sm {{ $index === 0 ? 'col-span-2' : '' }}">
                                <img src="{{ asset('images/'.$img) }}" class="w-full h-full object-cover">
                                @if($index === 0)
                                    <span class="absolute top-3 left-3 bg-amber-600 text-white text-xs font-black px-3 py-1.5 rounded-lg shadow-md z-10">Cover Photo</span>
                                @endif
                            </div>
                        @endforeach
                    @elseif(is_string($product->image))
                        <div class="col-span-2 relative aspect-square rounded-xl overflow-hidden border-2 border-amber-200 shadow-sm">
                            <img src="{{ asset('images/'.$product->image) }}" class="w-full h-full object-cover">
                            <span class="absolute top-3 left-3 bg-amber-600 text-white text-xs font-black px-3 py-1.5 rounded-lg shadow-md z-10">Cover Photo</span>
                        </div>
                    @else
                        <div class="col-span-2 py-8 text-center text-amber-700/50 italic text-sm border border-dashed border-amber-200 rounded-xl bg-amber-50/50">
                            No images uploaded.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection