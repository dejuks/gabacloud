<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('gabacloud.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-50 text-gray-900 min-h-screen">

<!-- NAVBAR -->
<nav class="bg-white shadow-sm border-b border-gray-200 relative z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">

        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-bold text-indigo-600">
            <img src="{{ asset('gabacloud.png') }}" class="w-8 h-8 rounded" alt="Logo">
            <span class="hidden sm:block">{{ config('app.name') }}</span>
        </a>

        <!-- Mobile Button -->
        <button id="menuBtn" class="sm:hidden text-gray-700 text-2xl">☰</button>

        <!-- Desktop Menu -->
        <div class="hidden sm:flex items-center gap-6">

            <a href="{{ route('products.index') }}"
               class="text-sm font-medium {{ request()->routeIs('products*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }} transition-colors">
                Products
            </a>

            <a href="{{ route('blog.index') }}"
               class="text-sm font-medium {{ request()->routeIs('blog*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }} transition-colors">
                Blog
            </a>

            @auth
                <a href="{{ route('orders.my') }}"
                   class="text-sm font-medium {{ request()->routeIs('orders*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }} transition-colors">
                    My Orders
                </a>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="text-sm font-semibold text-indigo-600 border border-indigo-200 px-3 py-1 rounded-lg hover:bg-indigo-50 transition-colors">
                        ⚡ Admin
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="bg-red-50 text-red-600 px-4 py-1.5 rounded-lg hover:bg-red-100 text-sm font-medium transition-colors">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="bg-indigo-600 text-white px-4 py-1.5 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors">
                    Get Started
                </a>
            @endauth
        </div>
    </div>

    <!-- Mobile Backdrop -->
    <div id="backdrop" class="fixed inset-0 bg-black/40 hidden z-40 sm:hidden"></div>

    <!-- Mobile Menu -->
    <div id="menu"
         class="fixed top-0 left-0 w-72 h-full bg-white shadow-2xl transform -translate-x-full transition-transform duration-300 z-50 sm:hidden">

        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <img src="{{ asset('gabacloud.png') }}" class="w-7 h-7 rounded">
                <span class="font-bold text-indigo-600 text-sm">{{ config('app.name') }}</span>
            </div>
            <button id="closeBtn" class="text-2xl text-gray-400 hover:text-gray-700">×</button>
        </div>

        <div class="flex flex-col p-5 gap-1">

            <a href="{{ route('products.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
                      {{ request()->routeIs('products*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                📦 Products
            </a>

            <a href="{{ route('blog.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
                      {{ request()->routeIs('blog*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                📝 Blog
            </a>

            @auth
                <a href="{{ route('orders.my') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
                          {{ request()->routeIs('orders*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    🛒 My Orders
                </a>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-indigo-600 bg-indigo-50">
                        ⚡ Admin Panel
                    </a>
                @endif

                <div class="border-t border-gray-100 my-2 pt-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="w-full text-left flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50">
                            🚪 Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="border-t border-gray-100 my-2 pt-2 space-y-2">
                    <a href="{{ route('login') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50">
                        🔑 Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="flex items-center justify-center gap-2 bg-indigo-600 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700">
                        ✨ Get Started
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<!-- Flash Messages -->
<div class="max-w-7xl mx-auto px-4 mt-4">
    @foreach(['success','error','info'] as $type)
        @if(session($type))
            <div class="p-3 rounded-xl mb-3 text-sm flex items-center gap-2
                {{ $type === 'success' ? 'bg-green-50 text-green-800 border border-green-200' :
                   ($type === 'error'  ? 'bg-red-50 text-red-800 border border-red-200' :
                    'bg-blue-50 text-blue-800 border border-blue-200') }}">
                <span>{{ $type === 'success' ? '✅' : ($type === 'error' ? '❌' : 'ℹ️') }}</span>
                {{ session($type) }}
            </div>
        @endif
    @endforeach
</div>

<main class="max-w-7xl mx-auto px-4 py-8">
    @yield('content')
</main>

<footer class="bg-white border-t mt-16">
    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 mb-8">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <img src="{{ asset('gabacloud.png') }}" class="w-7 h-7 rounded">
                    <span class="font-bold text-indigo-600">{{ config('app.name') }}</span>
                </div>
                <p class="text-gray-400 text-sm">Premium software, scripts & templates for developers and businesses.</p>
            </div>
            <div>
                <h4 class="font-semibold text-gray-700 mb-3 text-sm">Quick Links</h4>
                <div class="space-y-2">
                    <a href="{{ route('home') }}"           class="block text-gray-400 hover:text-indigo-600 text-sm">Home</a>
                    <a href="{{ route('products.index') }}" class="block text-gray-400 hover:text-indigo-600 text-sm">Products</a>
                    <a href="{{ route('blog.index') }}"     class="block text-gray-400 hover:text-indigo-600 text-sm">Blog</a>
                </div>
            </div>
            <div>
                <h4 class="font-semibold text-gray-700 mb-3 text-sm">Account</h4>
                <div class="space-y-2">
                    @auth
                        <a href="{{ route('orders.my') }}" class="block text-gray-400 hover:text-indigo-600 text-sm">My Orders</a>
                    @else
                        <a href="{{ route('login') }}"    class="block text-gray-400 hover:text-indigo-600 text-sm">Login</a>
                        <a href="{{ route('register') }}" class="block text-gray-400 hover:text-indigo-600 text-sm">Register</a>
                    @endauth
                </div>
            </div>
        </div>
        <div class="border-t border-gray-100 pt-6 text-center text-gray-400 text-xs">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</footer>

<script>
    const menu     = document.getElementById('menu');
    const backdrop = document.getElementById('backdrop');
    const btn      = document.getElementById('menuBtn');
    const closeBtn = document.getElementById('closeBtn');

    function openMenu()  { menu.classList.remove('-translate-x-full'); backdrop.classList.remove('hidden'); }
    function closeMenu() { menu.classList.add('-translate-x-full');    backdrop.classList.add('hidden'); }

    btn.addEventListener('click', openMenu);
    closeBtn.addEventListener('click', closeMenu);
    backdrop.addEventListener('click', closeMenu);
</script>
</body>
</html>