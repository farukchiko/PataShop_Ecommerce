<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-amber-800 leading-tight tracking-wide">
            {{ __('Patashop') }}
        </h2>
    </x-slot>

    <div class="bg-[#FDFBF7] min-h-screen">
        
        <!-- Search Logic: If searching, hide all promotional sections and show Search Header -->
        @if(request('search'))
            <div class="bg-amber-50 border-b border-amber-200 py-8 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
                    <div class="text-center md:text-left mb-6 md:mb-0">
                        <h1 class="text-3xl font-black text-amber-900">Search Results</h1>
                        <p class="text-amber-700 font-medium mt-1 text-lg">Found {{ $products->count() }} items for "<span class="font-black text-amber-800">{{ request('search') }}</span>"</p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                        <form method="GET" action="{{ route('storefront.index') }}" class="flex shadow-md rounded-full overflow-hidden border-2 border-amber-200 bg-white w-full sm:w-auto">
                            <input type="text" name="search" value="{{ request('search') }}" class="py-2.5 px-4 border-none focus:ring-0 text-amber-900 text-sm font-medium w-full sm:w-64">
                            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2.5 px-6 transition duration-200 text-sm">Search</button>
                        </form>
                        
                        <a href="{{ route('storefront.index') }}" class="bg-white border-2 border-amber-300 text-amber-800 hover:bg-amber-100 font-black py-2.5 px-6 rounded-full transition-colors flex items-center whitespace-nowrap shadow-sm w-full sm:w-auto justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Hero Section with Search -->
            <div class="relative bg-amber-50 overflow-hidden border-b border-amber-100">
                <!-- Decorative background elements -->
                <div class="absolute inset-y-0 left-0 w-1/2 bg-gradient-to-r from-amber-100/50 to-transparent"></div>
                <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-amber-200/40 blur-3xl"></div>
                <div class="absolute bottom-0 right-1/4 w-64 h-64 rounded-full bg-orange-200/30 blur-2xl"></div>
                
                <!-- Slightly reduced padding to bring products up closer -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-12 lg:py-20 flex flex-col items-center text-center">
                    <span class="text-amber-600 font-bold tracking-widest uppercase text-sm mb-4">Your Ultimate Online Marketplace</span>
                    <h1 class="text-5xl md:text-6xl font-black text-amber-900 mb-6 tracking-tight">
                        Discover Everything <br class="hidden md:block"/> You Need at <span class="text-amber-600">Patashop</span>
                    </h1>
                    <p class="text-xl text-amber-800/80 mb-10 max-w-2xl font-medium leading-relaxed">
                        From daily essentials to the latest trends, explore thousands of products at unbeatable prices. Shop smartly, securely, and conveniently today.
                    </p>
                    
                    <!-- Search Bar in Hero -->
                    <form method="GET" action="{{ route('storefront.index') }}" class="w-full max-w-xl flex shadow-xl rounded-full overflow-hidden border-2 border-amber-200 bg-white focus-within:border-amber-400 focus-within:ring-4 focus-within:ring-amber-100 transition-all">
                        <div class="pl-6 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" placeholder="Search for gadgets, fashion, home goods..." class="flex-1 py-4 px-4 border-none focus:ring-0 text-amber-900 placeholder-amber-400 font-medium">
                        <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-4 px-8 transition duration-200">
                            Search Now
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <!-- Product Listing Section (Moved immediately after Hero) -->
        <div id="products" class="py-16">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                @if(!request('search'))
                    <div class="flex flex-col md:flex-row justify-between items-end mb-10 px-4 sm:px-0">
                        <div>
                            <h2 class="text-4xl font-black text-amber-900 tracking-tight">Featured Products</h2>
                            <p class="mt-2 text-lg text-amber-700/80 font-medium">Explore our top picks and daily deals.</p>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl shadow-sm mb-8 flex items-center" role="alert">
                        <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="block sm:inline font-medium text-lg">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-8 gap-y-12 px-4 sm:px-0">
                    @forelse ($products as $product)
                        <div class="bg-white rounded-3xl shadow-sm hover:shadow-xl border border-amber-100/60 transition-all duration-300 overflow-hidden transform hover:-translate-y-2 group flex flex-col h-full">
                            
                            <!-- Image Container -->
                            <div class="relative h-64 overflow-hidden bg-amber-50">
                                <a href="{{ route('storefront.show', $product->id) }}" class="block w-full h-full">
                                    @php $imgSrc = is_array($product->image) ? ($product->image[0] ?? 'default.jpg') : $product->image; @endphp
                                    <img src="{{ asset('images/'.$imgSrc) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                </a>
                                @if($product->stock < 10 && $product->stock > 0)
                                    <div class="absolute top-4 left-4 bg-orange-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md">
                                        Only {{ $product->stock }} left!
                                    </div>
                                @elseif($product->stock == 0)
                                    <div class="absolute inset-0 bg-white/60 backdrop-blur-sm flex items-center justify-center z-10">
                                        <span class="bg-red-500 text-white font-black px-6 py-2 rounded-full text-lg shadow-lg transform -rotate-12">SOLD OUT</span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Content Container -->
                            <div class="p-6 flex-1 flex flex-col">
                                <div class="flex justify-between items-start mb-2">
                                    <a href="{{ route('storefront.show', $product->id) }}">
                                        <h3 class="text-2xl font-bold text-amber-900 group-hover:text-amber-600 transition-colors line-clamp-1">{{ $product->name }}</h3>
                                    </a>
                                </div>
                                
                                <p class="text-amber-700/70 text-sm mb-6 line-clamp-2 leading-relaxed flex-1">{{ $product->description }}</p>
                                
                                <div class="flex justify-between items-center mb-6 pt-4 border-t border-amber-50">
                                    <span class="text-2xl font-black text-amber-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <span class="text-xs font-bold text-amber-600/70 bg-amber-100 px-2 py-1 rounded-md border border-amber-200">Stock: {{ $product->stock }}</span>
                                </div>

                                <form action="{{ route('cart.store') }}" method="POST" class="mt-auto">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="flex items-center space-x-3 bg-amber-50/50 p-2 rounded-xl border border-amber-100">
                                        <div class="relative flex items-center">
                                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                                class="w-16 pl-2 pr-1 py-2.5 border-amber-200 focus:border-amber-500 focus:ring-amber-500 rounded-lg shadow-sm bg-white text-amber-900 font-bold text-center {{ $product->stock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ $product->stock == 0 ? 'disabled' : '' }}>
                                        </div>
                                        <button type="submit" 
                                            class="flex-1 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-200 flex items-center justify-center
                                            {{ $product->stock == 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-amber-600 hover:bg-amber-700 hover:shadow-lg' }}"
                                            {{ $product->stock == 0 ? 'disabled' : '' }}>
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            Add
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-24 bg-white rounded-3xl shadow-sm border border-amber-100 flex flex-col items-center">
                            <svg class="w-24 h-24 text-amber-200 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            <h3 class="text-3xl font-black text-amber-900 mb-2">No products found</h3>
                            <p class="text-xl text-amber-700/80 font-medium">We couldn't find any items matching your criteria.</p>
                            @if(request('search'))
                                <a href="{{ route('storefront.index') }}" class="mt-6 bg-amber-100 text-amber-700 hover:bg-amber-200 hover:text-amber-900 font-bold py-3 px-8 rounded-full transition duration-200">
                                    View All Products
                                </a>
                            @endif
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        @if(!request('search'))
            <!-- Promotional Banner (Moved after products) -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 mb-16">
                <div class="bg-gradient-to-r from-amber-600 to-orange-500 rounded-3xl p-8 md:p-12 shadow-lg flex flex-col md:flex-row items-center justify-between text-white overflow-hidden relative">
                    <!-- Background pattern -->
                    <svg class="absolute inset-0 w-full h-full opacity-10" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0 100C20 0 50 0 100 100Z"></path></svg>
                    
                    <div class="relative z-10 mb-6 md:mb-0 md:max-w-lg text-center md:text-left">
                        <span class="inline-block py-1 px-3 rounded-full bg-white/20 text-white text-xs font-bold uppercase tracking-wider mb-3">Mega Sale</span>
                        <h2 class="text-3xl md:text-4xl font-black mb-4 leading-tight">Get 20% Off Your First Purchase</h2>
                        <p class="text-amber-50 text-lg font-medium">Use code <span class="font-bold bg-white text-amber-600 px-2 py-1 rounded">PATA20</span> at checkout to claim your discount across all categories.</p>
                    </div>
                    <div class="relative z-10 shrink-0">
                        <a href="#products" class="inline-block bg-white text-amber-600 hover:bg-amber-50 font-bold text-lg py-4 px-8 rounded-full shadow-lg transition-transform hover:scale-105">
                            Shop Collection Now
                        </a>
                    </div>
                </div>
            </div>

            <!-- Features / Value Proposition Section (Moved after Promo Banner) -->
            <div class="py-12 bg-white border-y border-amber-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                        <div class="p-6">
                            <div class="w-16 h-16 mx-auto bg-amber-100 rounded-2xl flex items-center justify-center mb-4 text-amber-600 transform rotate-3 shadow-sm">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-amber-900 mb-2">Secure Payments</h3>
                            <p class="text-amber-700/80 font-medium">Your transactions are 100% protected with our advanced payment security systems.</p>
                        </div>
                        <div class="p-6 border-y md:border-y-0 md:border-x border-amber-100">
                            <div class="w-16 h-16 mx-auto bg-orange-100 rounded-2xl flex items-center justify-center mb-4 text-orange-600 transform -rotate-3 shadow-sm">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-amber-900 mb-2">Fast Delivery</h3>
                            <p class="text-amber-700/80 font-medium">Get your items delivered quickly to your doorstep with our trusted logistics partners.</p>
                        </div>
                        <div class="p-6">
                            <div class="w-16 h-16 mx-auto bg-amber-100 rounded-2xl flex items-center justify-center mb-4 text-amber-600 transform rotate-3 shadow-sm">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-amber-900 mb-2">Quality Guarantee</h3>
                            <p class="text-amber-700/80 font-medium">We ensure all products meet our high-quality standards before they reach you.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Store Information Footer -->
        <footer class="bg-amber-900 text-amber-50 py-16 border-t-8 border-amber-600 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                    <div class="md:col-span-2">
                        <a href="{{ route('storefront.index') }}" class="font-black text-3xl text-amber-400 tracking-wider mb-6 block">
                            Patashop
                        </a>
                        <p class="text-amber-200/80 mb-6 max-w-md font-medium leading-relaxed">
                            Your ultimate online shopping destination. We provide a wide variety of quality products from electronics to fashion, delivering the best value directly to your doorstep.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 rounded-full bg-amber-800 flex items-center justify-center text-amber-400 hover:bg-amber-600 hover:text-white transition-colors">
                                <span class="sr-only">Facebook</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"></path></svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-amber-800 flex items-center justify-center text-amber-400 hover:bg-amber-600 hover:text-white transition-colors">
                                <span class="sr-only">Instagram</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path></svg>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-white mb-6">Quick Links</h4>
                        <ul class="space-y-3 font-medium text-amber-200/80">
                            <li><a href="#" class="hover:text-amber-400 hover:translate-x-1 inline-block transition-transform">About Us</a></li>
                            <li><a href="#products" class="hover:text-amber-400 hover:translate-x-1 inline-block transition-transform">All Categories</a></li>
                            <li><a href="#" class="hover:text-amber-400 hover:translate-x-1 inline-block transition-transform">Order Tracking</a></li>
                            <li><a href="#" class="hover:text-amber-400 hover:translate-x-1 inline-block transition-transform">Customer Support</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-white mb-6">Customer Service</h4>
                        <ul class="space-y-3 font-medium text-amber-200/80">
                            <li class="flex justify-between"><span>Mon - Sun:</span> <span>24 Hours (Always Open)</span></li>
                            <li class="flex justify-between"><span>Holidays:</span> <span>24 Hours</span></li>
                            <li class="flex justify-between"><span>Live Chat:</span> <span>Available 24/7</span></li>
                        </ul>
                        <div class="mt-6 pt-6 border-t border-amber-800">
                            <p class="text-sm">Jl. Raya Kebon Jeruk No. 27, <br>Jakarta Barat, 11530</p>
                        </div>
                    </div>
                </div>
                <div class="mt-12 pt-8 border-t border-amber-800 text-center text-amber-400/60 font-medium">
                    <p>&copy; {{ date('Y') }} Patashop E-Commerce. All rights reserved.</p>
                </div>
            </div>
        </footer>

    </div>
</x-app-layout>
