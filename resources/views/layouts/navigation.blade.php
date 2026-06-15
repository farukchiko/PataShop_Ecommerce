<nav x-data="{ open: false }" class="bg-[#FDFBF7] border-b border-amber-200 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('storefront.index') }}" class="font-black text-2xl text-amber-700 tracking-wider">
                        Patashop
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('storefront.index')" :active="request()->routeIs('storefront.*')">
                        {{ __('Home') }}
                    </x-nav-link>
                    
                    @auth
                        @if(Auth::user()->role !== 'admin')
                            <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                                {{ __('Cart') }} 
                                @if(Auth::user()->carts()->count() > 0)
                                    <span class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ Auth::user()->carts()->count() }}</span>
                                @endif
                            </x-nav-link>

                            <x-nav-link :href="route('topups.index')" :active="request()->routeIs('topups.*')">
                                {{ __('Top Up Wallet') }}
                            </x-nav-link>

                            <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                                {{ __('Order History') }}
                            </x-nav-link>
                        @endif
                        
                        @if(Auth::user()->role === 'admin')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                                {{ __('Admin Dashboard') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    @if(Auth::user()->role !== 'admin')
                        <div class="mr-4 text-sm font-semibold text-green-700 bg-green-50 px-3 py-1 rounded-full border border-green-200">
                            Rp {{ number_format(Auth::user()->money, 0, ',', '.') }}
                        </div>
                    @endif
                    
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-amber-900 bg-transparent hover:text-amber-600 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-amber-900 hover:text-amber-600 mr-4 font-semibold transition-colors">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm text-amber-900 bg-amber-200 hover:bg-amber-300 border border-amber-300 px-4 py-2 rounded-md font-semibold transition-colors">Register</a>
                    @endif
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-amber-600 hover:text-amber-800 hover:bg-amber-100 focus:outline-none focus:bg-amber-100 focus:text-amber-800 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#FDFBF7]">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('storefront.index')" :active="request()->routeIs('storefront.*')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            
            @auth
                @if(Auth::user()->role !== 'admin')
                    <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                        {{ __('Cart') }} ({{ Auth::user()->carts()->count() }})
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('topups.index')" :active="request()->routeIs('topups.*')">
                        {{ __('Top Up Wallet') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                        {{ __('Order History') }}
                    </x-responsive-nav-link>
                @endif
                @if(Auth::user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                        {{ __('Admin Dashboard') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-amber-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-amber-900">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-amber-700">{{ Auth::user()->email }}</div>
                    @if(Auth::user()->role !== 'admin')
                        <div class="font-medium text-sm text-green-700 mt-1">Rp {{ number_format(Auth::user()->money, 0, ',', '.') }}</div>
                    @endif
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1 px-4">
                    <a href="{{ route('login') }}" class="block font-medium text-base text-amber-900 hover:text-amber-600 py-2">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block font-medium text-base text-amber-700 hover:text-amber-600 py-2">Register</a>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>
