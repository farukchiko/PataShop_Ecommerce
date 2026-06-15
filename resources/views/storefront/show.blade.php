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
                    <h1 class="text-4xl font-extrabold text-amber-900 mb-4">{{ $product->name }}</h1>
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
        </div>
    </div>
</x-app-layout>
