<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

<!-- Sidebar -->
<aside class="w-64 bg-gray-900 text-white min-h-screen flex flex-col fixed top-0 left-0">
    <div class="p-6 border-b border-gray-700">
        <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-indigo-400">⚡ Admin Panel</a>
        <p class="text-xs text-gray-400 mt-1">{{ auth()->user()->name }}</p>
    </div>
    <nav class="flex-1 p-4 space-y-1">
        @php
            $links = [
                ['route' => 'admin.dashboard',         'icon' => '📊', 'label' => 'Dashboard'],
                ['route' => 'admin.products.index',    'icon' => '📦', 'label' => 'Products'],
                ['route' => 'admin.categories.index',  'icon' => '🗂️',  'label' => 'Categories'],
                ['route' => 'admin.orders.index',      'icon' => '🛒', 'label' => 'Orders'],
                ['route' => 'admin.users.index',       'icon' => '👥', 'label' => 'Users'],
                ['route' => 'admin.blog.index',           'icon' => '📝', 'label' => 'Blog Posts'],
['route' => 'admin.blog-categories.index','icon' => '🏷️',  'label' => 'Blog Categories'],
            ];
        @endphp
        @foreach($links as $link)
            <a href="{{ route($link['route']) }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                      {{ request()->routeIs($link['route'] . '*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <span>{{ $link['icon'] }}</span> {{ $link['label'] }}
            </a>
        @endforeach
    </nav>
    <div class="p-4 border-t border-gray-700">
        <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-white block mb-2">← View Site</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="w-full text-left text-xs text-red-400 hover:text-red-300">Logout</button>
        </form>
    </div>
</aside>

<!-- Main -->
<div class="ml-64 flex-1 flex flex-col min-h-screen">
    <header class="bg-white shadow-sm px-8 py-4 flex items-center justify-between">
        <h1 class="text-lg font-semibold text-gray-700">@yield('title', 'Dashboard')</h1>
        <span class="text-sm text-gray-400">{{ now()->format('D, d M Y') }}</span>
    </header>

    <main class="flex-1 p-8">
        @foreach(['success','error','info'] as $type)
            @if(session($type))
                <div class="mb-4 px-4 py-3 rounded-lg text-sm
                    {{ $type === 'success' ? 'bg-green-100 text-green-800' :
                       ($type === 'error'   ? 'bg-red-100 text-red-800'   : 'bg-blue-100 text-blue-800') }}">
                    {{ session($type) }}
                </div>
            @endif
        @endforeach

        @yield('content')
    </main>
</div>
</body>
</html>