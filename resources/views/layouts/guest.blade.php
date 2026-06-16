<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
    <body class="font-sans text-amber-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#FDFBF7]">
            <div>
                <a href="/" class="text-4xl font-black text-amber-700 tracking-wider">
                    Patashop
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-8 px-8 py-8 bg-white shadow-xl border border-amber-100 overflow-hidden rounded-2xl">
                {{ $slot }}
            </div>
        </div>
        
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
