<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-amber-700 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#FDFBF7] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row border border-amber-100">
                <div class="md:w-1/2 bg-amber-50/50 flex flex-col items-center p-6 md:p-10" x-data="{ activeImage: 0, images: {{ json_encode(is_array($product->image) ? $product->image : [$product->image]) }} }">
                    <!-- Main Image -->
                    <div class="relative w-full h-[400px] md:h-[500px] rounded-2xl overflow-hidden shadow-sm border border-amber-200 bg-white">
                        <template x-for="(img, index) in images" :key="index">
                            <img :src="'/images/' + img" :alt="'{{ addslashes($product->name) }} image ' + (index+1)" 
                                 class="absolute inset-0 w-full h-full object-cover transition-opacity duration-300"
                                 x-show="activeImage === index" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0">
                        </template>
                        
                        <!-- Navigation Arrows -->
                        <template x-if="images.length > 1">
                            <div class="absolute inset-0 flex items-center justify-between px-4 opacity-0 hover:opacity-100 transition-opacity duration-300">
                                <button type="button" @click.prevent="activeImage = activeImage === 0 ? images.length - 1 : activeImage - 1" class="bg-white/90 hover:bg-amber-100 text-amber-700 rounded-full p-3 shadow-md transition-all transform hover:scale-110 backdrop-blur-sm border border-amber-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                                </button>
                                <button type="button" @click.prevent="activeImage = activeImage === images.length - 1 ? 0 : activeImage + 1" class="bg-white/90 hover:bg-amber-100 text-amber-700 rounded-full p-3 shadow-md transition-all transform hover:scale-110 backdrop-blur-sm border border-amber-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </div>
                        </template>
                    </div>
                    
                    <!-- Thumbnails -->
                    <template x-if="images.length > 1">
                        <div class="flex space-x-3 mt-6 overflow-x-auto py-2 px-1 w-full max-w-full no-scrollbar">
                            <template x-for="(img, index) in images" :key="index">
                                <button type="button" @click="activeImage = index" 
                                        class="relative flex-none w-20 h-20 md:w-24 md:h-24 rounded-xl overflow-hidden border-2 transition-all duration-300 focus:outline-none"
                                        :class="activeImage === index ? 'border-amber-600 shadow-md ring-2 ring-amber-200 ring-offset-1' : 'border-amber-200 hover:border-amber-400 opacity-60 hover:opacity-100'">
                                    <img :src="'/images/' + img" class="w-full h-full object-cover">
                                </button>
                            </template>
                        </div>
                    </template>
                </div>
                <div class="md:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
                    <h1 class="text-4xl font-extrabold text-amber-900 mb-2">{{ $product->name }}</h1>
                    
                    @if($product->reviews->count() > 0)
                        <div class="flex items-center mb-4">
                            <div class="flex items-center text-amber-500">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= round($averageRating) ? 'text-amber-500' : 'text-amber-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-2 text-sm font-bold text-amber-900">{{ number_format($averageRating, 1) }}</span>
                            <span class="ml-2 text-sm font-medium text-amber-700/80">({{ $product->reviews->count() }} ulasan)</span>
                        </div>
                    @endif

                    <p class="text-3xl font-black text-amber-600 mb-6 tracking-tight">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    
                    <div class="prose max-w-none text-amber-900/80 mb-8 leading-relaxed">
                        <p class="whitespace-pre-line">{{ $product->description }}</p>
                    </div>

                    <div class="flex items-center mb-8">
                        <span class="px-4 py-2 bg-amber-100 text-amber-800 rounded-lg font-semibold text-sm mr-4 border border-amber-200 shadow-sm">
                            Stock: {{ $product->stock }}
                        </span>
                    </div>

                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center space-x-4">
                            <label for="quantity" class="font-bold text-amber-900">Qty:</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-24 border-amber-300 focus:border-amber-500 focus:ring-amber-500 rounded-lg shadow-sm text-lg text-center bg-[#FDFBF7] text-amber-900">
                            
                            <button type="submit" class="flex-1 bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transform transition duration-200 hover:-translate-y-1 text-lg">
                                Add to Cart
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-8 pt-6 border-t border-amber-100">
                        <a href="{{ route('storefront.index') }}" class="text-amber-600 hover:text-amber-800 font-semibold inline-flex items-center transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Back to Shop
                        </a>
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="mt-12 bg-white rounded-3xl shadow-sm border border-amber-100 overflow-hidden">
                <div class="bg-amber-50 px-8 py-6 border-b border-amber-100">
                    <h3 class="text-2xl font-black text-amber-900">Ulasan Pelanggan</h3>
                </div>
                
                <div class="p-8">
                    @if($product->reviews->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach($product->reviews as $review)
                                <div class="bg-[#FDFBF7] p-6 rounded-2xl border border-amber-100 shadow-sm">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center gap-3">
                                            @if($review->user->avatar)
                                                <img src="{{ asset('avatars/' . $review->user->avatar) }}" alt="{{ $review->user->name }}" class="w-10 h-10 rounded-full object-cover border border-amber-200">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-amber-200 flex items-center justify-center text-amber-700 font-bold border border-amber-300">
                                                    {{ substr($review->user->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-bold text-amber-900 text-sm">{{ $review->user->name }}</div>
                                                <div class="text-xs text-amber-600/80 font-medium">{{ $review->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end gap-2">
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-500' : 'text-amber-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                            @auth
                                                <div class="flex items-center gap-2">
                                                    @if(Auth::id() === $review->user_id && now()->diffInHours($review->created_at) <= 24)
                                                        <a href="{{ route('reviews.edit', $review->id) }}" class="text-[10px] uppercase font-bold text-amber-600 hover:text-amber-800 transition-colors bg-amber-100 px-2 py-1 rounded">Edit</a>
                                                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-[10px] uppercase font-bold text-red-600 hover:text-red-800 transition-colors bg-red-100 px-2 py-1 rounded">Hapus</button>
                                                        </form>
                                                    @elseif(Auth::user()->role === 'admin')
                                                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini sebagai Admin?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-[10px] uppercase font-bold text-white bg-red-600 hover:bg-red-700 transition-colors px-2 py-1 rounded">Admin Delete</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            @endauth
                                        </div>
                                    </div>
                                    
                                    <p class="text-amber-900/80 text-sm leading-relaxed mb-4">{{ $review->comment }}</p>
                                    
                                    @if($review->media_paths && count($review->media_paths) > 0)
                                        <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                                            @foreach($review->media_paths as $media)
                                                @php 
                                                    $ext = pathinfo($media, PATHINFO_EXTENSION); 
                                                    $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                @endphp
                                                <div class="flex-shrink-0 w-24 h-24 rounded-xl overflow-hidden border border-amber-200">
                                                    @if($isImage)
                                                        <img src="{{ asset('reviews/' . $media) }}" alt="Review Image" class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                                                    @else
                                                        <video src="{{ asset('reviews/' . $media) }}" controls class="w-full h-full object-cover bg-amber-900"></video>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-amber-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <h4 class="text-xl font-bold text-amber-900 mb-2">Belum Ada Ulasan</h4>
                            <p class="text-amber-700/80">Produk ini belum memiliki ulasan dari pelanggan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
