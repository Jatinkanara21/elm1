<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Premium fine wines, spirits, and craft beers at Elm Grove Liquor Store">
    <meta name="theme-color" content="#8B4513">

    <title>{{ config('app.name', 'Elm Grove Liquor') }} - @yield('title', 'Premium Liquor Store')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-mocha-light text-mocha-text font-sans antialiased flex flex-col min-h-screen pb-20 sm:pb-0">
    <x-age-gate />

    <!-- Navigation -->
    <nav x-data="{ open: false }" class="bg-white/95 backdrop-blur-md border-b border-gray-200 shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <span class="font-serif text-2xl font-bold text-mocha-accent">Elm Grove</span>
                        <span class="font-sans text-sm ml-2 tracking-widest text-gray-400 mt-1 uppercase">Liquor</span>
                    </a>
                    <div class="hidden sm:ml-10 sm:flex sm:space-x-8">
                        <a href="{{ route('home') }}" class="border-transparent text-gray-600 hover:text-mocha-accent inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">Home</a>
                        <a href="{{ route('products.index') }}" class="border-transparent text-gray-600 hover:text-mocha-accent inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">Shop</a>
                    </div>
                </div>
                
                <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-6">
                    <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-mocha-accent relative group">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        @if(session('cart'))
                            <span class="absolute -top-2 -right-2 bg-mocha-accent text-white rounded-full h-5 w-5 flex items-center justify-center text-xs font-bold">{{ count(session('cart')) }}</span>
                        @endif
                    </a>

                    @auth
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 text-gray-600 hover:text-mocha-accent focus:outline-none">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" loading="lazy" decoding="async" class="w-8 h-8 rounded-full border border-mocha-accent" alt="User Avatar">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-mocha-accent text-white flex items-center justify-center text-sm font-bold">{{ substr(auth()->user()->name, 0, 1) }}</div>
                                @endif
                                <span class="text-gray-800 font-medium">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            
                            <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 border border-gray-100 ring-1 ring-black ring-opacity-5 z-50" style="display: none;">
                                @if(auth()->user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-mocha-light hover:text-mocha-accent">Admin Dashboard</a>
                                @endif
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-mocha-light hover:text-mocha-accent">Profile</a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-mocha-light hover:text-mocha-accent">Order History</a>
                                <a href="{{ route('wishlist.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-mocha-light hover:text-mocha-accent">Wishlist</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600">Log Out</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-mocha-accent font-medium transition-colors">Log in</a>
                        <a href="{{ route('register') }}" class="bg-mocha-accent hover:bg-[#A0522D] text-white px-4 py-2 rounded-md font-medium transition-colors shadow-sm">Register</a>
                    @endauth
                </div>
                
                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-mocha-secondary focus:outline-none focus:bg-mocha-secondary focus:text-white transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-gray-100 bg-white shadow-md">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-mocha-accent hover:bg-gray-50">Home</a>
                <a href="{{ route('products.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-mocha-accent hover:bg-gray-50">Shop</a>
                <a href="{{ route('cart.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-mocha-accent hover:bg-gray-50">Cart (@if(session('cart')) {{ count(session('cart')) }} @else 0 @endif)</a>
            </div>
            @guest
                <div class="pt-4 pb-3 border-t border-gray-100">
                    <div class="mt-3 space-y-1">
                        <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-mocha-accent hover:bg-gray-50">Log in</a>
                        <a href="{{ route('register') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-mocha-accent hover:bg-gray-50">Register</a>
                    </div>
                </div>
            @endguest
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-600/20 border border-green-500 text-green-400 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-600/20 border border-red-500 text-red-400 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-mocha-secondary border-t border-white/10 mt-12 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <span class="font-serif text-2xl font-bold text-mocha-accent">Elm Grove</span>
                    <p class="mt-4 text-gray-400 text-sm max-w-sm">Premium fine wines, spirits, and craft beers. Experience luxury with every pour. Drink responsibly.</p>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Quick Links</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white text-sm">Home</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white text-sm">Shop</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Contact</h3>
                    <ul class="mt-4 space-y-2 text-sm text-gray-400">
                        <li>7433 N Lindbergh Blvd</li>
                        <li>Hazelwood, MO 63042</li>
                        <li>United States</li>
                        <li class="pt-1">Phone: (555) 123-4567</li>
                        <li>Email: info@elmgroveliquor.com</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider">Location</h3>
                    <div class="mt-4 rounded-xl overflow-hidden border border-white/5 h-36">
                        <iframe class="w-full h-full" src="https://maps.google.com/maps?q=7433%20N%20Lindbergh%20Blvd,%20Hazelwood,%20MO%2063042&t=&z=14&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" loading="lazy" title="Elm Grove Liquor Store Location"></iframe>
                    </div>
                </div>
            </div>
            <div class="mt-8 border-t border-white/10 pt-8 flex items-center justify-between">
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Elm Grove Liquor Store. All rights reserved.</p>
                <div class="flex space-x-6">
                    <p class="text-gray-500 text-xs">Must be 18+ to purchase.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bottom Navigation (Mobile App-style) -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 shadow-lg flex justify-around p-3 z-50 sm:hidden">
        <a href="{{ route('home') }}" class="flex flex-col items-center text-gray-600 hover:text-mocha-accent transition">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            <span class="text-[10px] mt-1 font-medium">Home</span>
        </a>
        <a href="{{ route('products.index') }}" class="flex flex-col items-center text-gray-600 hover:text-mocha-accent transition">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            <span class="text-[10px] mt-1 font-medium">Search</span>
        </a>
        <a href="{{ route('cart.index') }}" class="flex flex-col items-center text-gray-600 hover:text-mocha-accent transition relative">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            @if(session('cart'))
                <span class="absolute -top-1 -right-1 bg-mocha-accent text-white rounded-full h-4 w-4 flex items-center justify-center text-[10px] font-bold">{{ count(session('cart')) }}</span>
            @endif
            <span class="text-[10px] mt-1 font-medium">Cart</span>
        </a>
        @auth
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center text-gray-600 hover:text-mocha-accent transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                <span class="text-[10px] mt-1 font-medium">Profile</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="flex flex-col items-center text-gray-600 hover:text-mocha-accent transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h5a3 3 0 013 3v1" /></svg>
                <span class="text-[10px] mt-1 font-medium">Login</span>
            </a>
        @endauth
    </div>
</body>
</html>
