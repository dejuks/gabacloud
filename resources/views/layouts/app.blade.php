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
        <button id="menuBtn" class="sm:hidden text-gray-700 text-2xl">
            ☰
        </button>

        <!-- Desktop Menu -->
        <div class="hidden sm:flex items-center gap-5">
            <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-indigo-600">Products</a>

            @auth
                <a href="{{ route('orders.my') }}" class="text-gray-600 hover:text-indigo-600">My Orders</a>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 font-semibold">Admin</a>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="bg-red-100 text-red-600 px-3 py-1 rounded hover:bg-red-200 text-sm">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600">Login</a>
                <a href="{{ route('register') }}"
                   class="bg-indigo-600 text-white px-4 py-1.5 rounded-lg text-sm hover:bg-indigo-700">
                    Register
                </a>
            @endauth
        </div>
    </div>

    <!-- MOBILE MENU BACKDROP -->
    <div id="backdrop"
         class="fixed inset-0 bg-black/40 hidden z-40 sm:hidden">
    </div>

    <!-- MOBILE MENU -->
    <div id="menu"
         class="fixed top-0 left-0 w-72 h-full bg-white shadow-lg transform -translate-x-full transition-transform duration-300 z-50 sm:hidden">

        <div class="p-4 border-b flex items-center justify-between">
            <span class="font-bold text-indigo-600">Menu</span>
            <button id="closeBtn" class="text-xl">×</button>
        </div>

        <div class="flex flex-col p-4 gap-4">

            <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-indigo-600">
                Products
            </a>

            @auth
                <a href="{{ route('orders.my') }}" class="text-gray-700 hover:text-indigo-600">
                    My Orders
                </a>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 font-semibold">
                        Admin
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-left text-red-600">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-gray-700">Login</a>
                <a href="{{ route('register') }}" class="text-indigo-600 font-semibold">
                    Register
                </a>
            @endauth
        </div>
    </div>
</nav>

<!-- FLASH -->
<div class="max-w-7xl mx-auto px-4 mt-4">
    @foreach(['success','error','info'] as $type)
        @if(session($type))
            <div class="p-3 rounded mb-3
                {{ $type === 'success' ? 'bg-green-100 text-green-800' :
                   ($type === 'error' ? 'bg-red-100 text-red-800' :
                    'bg-blue-100 text-blue-800') }}">
                {{ session($type) }}
            </div>
        @endif
    @endforeach
</div>

<main class="max-w-7xl mx-auto px-4 py-8">
    @yield('content')
</main>

<footer class="bg-white border-t mt-16 py-8 text-center text-gray-400 text-sm">
    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
</footer>

<!-- JS -->
<script>
    const menu = document.getElementById('menu');
    const backdrop = document.getElementById('backdrop');
    const btn = document.getElementById('menuBtn');
    const closeBtn = document.getElementById('closeBtn');

    function openMenu() {
        menu.classList.remove('-translate-x-full');
        backdrop.classList.remove('hidden');
    }

    function closeMenu() {
        menu.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
    }

    btn.addEventListener('click', openMenu);
    closeBtn.addEventListener('click', closeMenu);
    backdrop.addEventListener('click', closeMenu);
</script>

</body>
</html>