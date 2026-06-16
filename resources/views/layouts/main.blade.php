<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Patashop Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Lenis Smooth Scrolling -->
    <script src="https://unpkg.com/lenis@1.1.5/dist/lenis.min.js"></script>
    <style>
        html.lenis, html.lenis body {
            height: auto;
        }
        .lenis.lenis-smooth {
            scroll-behavior: auto !important;
        }
        .lenis.lenis-smooth [data-lenis-prevent] {
            overscroll-behavior: contain;
        }
        .lenis.lenis-stopped {
            overflow: hidden;
        }
        .lenis.lenis-smooth iframe {
            pointer-events: none;
        }
    </style>
</head>
<body class="font-sans text-amber-900 antialiased bg-[#FDFBF7] min-h-screen flex flex-col">

    <nav class="bg-[#FDFBF7] border-b border-amber-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="font-black text-2xl text-amber-700 tracking-wider">
                        Patashop Admin
                    </a>
                    
                    <div class="hidden sm:flex sm:ml-10 space-x-8">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-amber-700 hover:text-amber-900 hover:border-amber-300 transition duration-150 ease-in-out {{ request()->routeIs('admin.dashboard') || request()->routeIs('products.index') ? 'border-amber-600 text-amber-900' : '' }}">
                            Product List
                        </a>
                        <a href="{{ route('products.create') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-amber-700 hover:text-amber-900 hover:border-amber-300 transition duration-150 ease-in-out {{ request()->routeIs('products.create') ? 'border-amber-600 text-amber-900' : '' }}">
                            Add Product
                        </a>
                        <a href="{{ route('admin.topups.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-amber-700 hover:text-amber-900 hover:border-amber-300 transition duration-150 ease-in-out {{ request()->routeIs('admin.topups.*') ? 'border-amber-600 text-amber-900' : '' }}">
                            Top Up Requests
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-amber-700 hover:text-amber-900 hover:border-amber-300 transition duration-150 ease-in-out {{ request()->routeIs('admin.orders.*') ? 'border-amber-600 text-amber-900' : '' }}">
                            Manage Orders
                        </a>
                        <a href="{{ route('admin.sales.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-amber-700 hover:text-amber-900 hover:border-amber-300 transition duration-150 ease-in-out {{ request()->routeIs('admin.sales.*') ? 'border-amber-600 text-amber-900' : '' }}">
                            Sales Report
                        </a>
                        <a href="{{ route('storefront.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-amber-700 hover:text-amber-900 hover:border-amber-300 transition duration-150 ease-in-out">
                            View Home
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-bold text-red-600 hover:text-red-800 transition-colors">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow">
        @if (session('success'))
            <div class="p-4 mb-6 bg-green-50 text-green-800 rounded-lg shadow-sm border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="bg-[#FDFBF7] text-amber-700/80 text-sm text-center p-6 border-t border-amber-200">
        &copy; {{ date('Y') }} Patashop E-Commerce Admin Panel
    </footer>

    <script>
        // Initialize Lenis
        const lenis = new Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            direction: 'vertical',
            gestureDirection: 'vertical',
            smooth: true,
            mouseMultiplier: 1,
            smoothTouch: false,
            touchMultiplier: 2,
            infinite: false,
        });

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }

        requestAnimationFrame(raf);
    </script>
</body>
</html>