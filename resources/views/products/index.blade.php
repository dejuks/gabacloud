@extends('layouts.app')
@section('title', 'Products')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    * { font-family: 'Inter', sans-serif; }

    .hero-gradient {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%);
    }

    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .card-hover:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(99, 102, 241, 0.15);
    }

    .badge-software  { background:#ede9fe; color:#6d28d9; }
    .badge-template  { background:#dbeafe; color:#1d4ed8; }
    .badge-plugin    { background:#d1fae5; color:#065f46; }
    .badge-other     { background:#fef3c7; color:#92400e; }

    .search-glow:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
    }

    .filter-chip {
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .filter-chip:hover, .filter-chip.active {
        background: #4f46e5;
        color: white;
        border-color: #4f46e5;
    }

    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .price-tag {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .star { color: #f59e0b; }

    .product-img-wrap { position: relative; overflow: hidden; }
    .product-img-wrap img { transition: transform 0.4s ease; }
    .card-hover:hover .product-img-wrap img { transform: scale(1.07); }

    .overlay-btn {
        opacity: 0;
        transform: translateY(8px);
        transition: all 0.25s ease;
    }
    .card-hover:hover .overlay-btn {
        opacity: 1;
        transform: translateY(0);
    }

    .tag-pill {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 3px 10px;
        border-radius: 999px;
    }

    .sort-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 36px;
    }

    /* Pagination custom */
    .pagination { display: flex; gap: 6px; justify-content: center; flex-wrap: wrap; }
    .pagination a, .pagination span {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 36px; height: 36px; padding: 0 8px;
        border-radius: 8px; font-size: 14px; font-weight: 500;
        border: 1px solid #e5e7eb; color: #374151;
        text-decoration: none; transition: all 0.2s;
    }
    .pagination a:hover { background: #4f46e5; color: white; border-color: #4f46e5; }
    .pagination span.active-page { background: #4f46e5; color: white; border-color: #4f46e5; }
    .pagination span[aria-disabled] { color: #d1d5db; cursor: not-allowed; }
</style>

<!-- ── HERO SEARCH SECTION ─────────────────────────────────────── -->
<div class="hero-gradient rounded-3xl p-10 mb-10 text-white relative overflow-hidden">
    <!-- decorative circles -->
    <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full bg-white opacity-5"></div>
    <div class="absolute -bottom-10 -left-10 w-48 h-48 rounded-full bg-white opacity-5"></div>
    <div class="absolute top-1/2 right-1/4 w-32 h-32 rounded-full bg-indigo-400 opacity-10"></div>

    <div class="relative z-10 max-w-3xl mx-auto text-center">
        <p class="text-indigo-300 text-sm font-semibold tracking-widest uppercase mb-3">
            Digital Marketplace
        </p>

        <h1 class="text-4xl md:text-5xl font-extrabold mb-3 leading-tight">
            Find Your Next<br>
            <span class="text-indigo-300">Powerful Software</span>
        </h1>

        <p class="text-indigo-200 mb-8 text-lg">
            Premium scripts, templates & plugins — built for developers, ready for production.
        </p>

        <!-- SEARCH FORM -->
        <form method="GET" action="{{ route('products.index') }}" class="flex gap-3">
            
            <div class="flex-1 relative">

                <!-- icon -->
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                </div>

                <!-- INPUT (WHITE SMOKE STYLE) -->
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search scripts, templates, plugins..."
                    class="search-glow w-full pl-12 pr-4 py-4 rounded-2xl
                           text-gray-900 text-sm font-medium
                           bg-gray-100/90 backdrop-blur-md
                           border border-white/20
                           shadow-lg
                           placeholder-gray-500"
                >
            </div>

            <!-- BUTTON -->
            <button type="submit"
                class="bg-indigo-500 hover:bg-indigo-400 text-white px-8 py-4 rounded-2xl
                       font-semibold text-sm transition-colors shadow-lg whitespace-nowrap">
                Search
            </button>
        </form>

        <!-- QUICK STATS -->
        <div class="flex items-center justify-center gap-8 mt-8 text-sm">
            <div class="text-center">
                <p class="text-2xl font-bold">{{ $totalProducts ?? '50+' }}</p>
                <p class="text-indigo-300 text-xs">Products</p>
            </div>

            <div class="w-px h-8 bg-indigo-600"></div>

            <div class="text-center">
                <p class="text-2xl font-bold">{{ $totalDownloads ?? '1K+' }}</p>
                <p class="text-indigo-300 text-xs">Downloads</p>
            </div>

            <div class="w-px h-8 bg-indigo-600"></div>

            <div class="text-center">
                <p class="text-2xl font-bold">5★</p>
                <p class="text-indigo-300 text-xs">Avg Rating</p>
            </div>
        </div>
    </div>
</div>

<!-- ── FILTERS & SORT ROW ─────────────────────────────────────── -->
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">

    <!-- Category + Type Filter Chips -->
    <form method="GET" action="{{ route('products.index') }}" id="filterForm" class="flex flex-wrap gap-2 items-center">
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif

        <!-- Category dropdown -->
        <select name="category" onchange="document.getElementById('filterForm').submit()"
            class="sort-select border border-gray-200 rounded-xl px-4 py-2 text-sm font-medium text-gray-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
            <option value="">All Categories</option>
            @foreach($categories ?? [] as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <!-- Type chips -->
        @foreach(['software' => '💻 Software', 'template' => '🎨 Template', 'plugin' => '🔌 Plugin', 'other' => '📁 Other'] as $val => $label)
            <a href="{{ request()->fullUrlWithQuery(['type' => request('type') === $val ? '' : $val]) }}"
               class="filter-chip border border-gray-200 rounded-xl px-4 py-2 text-sm font-medium bg-white shadow-sm text-gray-700
                      {{ request('type') === $val ? 'active' : '' }}">
                {{ $label }}
            </a>
        @endforeach

        @if(request()->hasAny(['search','category','type','sort']))
            <a href="{{ route('products.index') }}"
               class="text-xs text-red-500 hover:text-red-700 font-medium ml-1">
                ✕ Clear filters
            </a>
        @endif
    </form>

    <!-- Sort + Result Count -->
    <div class="flex items-center gap-3">
        <span class="text-sm text-gray-400">
            {{ $products->total() }} result{{ $products->total() !== 1 ? 's' : '' }}
        </span>
        <form method="GET" action="{{ route('products.index') }}">
            @foreach(request()->except('sort') as $key => $val)
                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
            @endforeach
            <select name="sort" onchange="this.form.submit()"
                class="sort-select border border-gray-200 rounded-xl px-4 py-2 text-sm font-medium text-gray-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <option value="latest"     {{ request('sort','latest') === 'latest'     ? 'selected' : '' }}>🕐 Latest</option>
                <option value="popular"    {{ request('sort') === 'popular'    ? 'selected' : '' }}>🔥 Most Popular</option>
                <option value="price_asc"  {{ request('sort') === 'price_asc'  ? 'selected' : '' }}>💰 Price: Low to High</option>
                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>💎 Price: High to Low</option>
            </select>
        </form>
    </div>
</div>

<!-- ── ACTIVE SEARCH INDICATOR ───────────────────────────────── -->
@if(request('search'))
<div class="flex items-center gap-2 mb-4 text-sm text-gray-600">
    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
    </svg>
    Showing results for <strong class="text-indigo-600 ml-1">"{{ request('search') }}"</strong>
</div>
@endif

<!-- ── PRODUCT GRID ───────────────────────────────────────────── -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($products as $product)
    <div class="card-hover bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">

        <!-- Thumbnail -->
        <div class="product-img-wrap h-44 bg-gradient-to-br from-indigo-50 to-purple-50 relative">
            @if($product->thumbnail)
                <img src="{{ Storage::url($product->thumbnail) }}"
                     alt="{{ $product->title }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex flex-col items-center justify-center text-indigo-300">
                    <svg class="w-12 h-12 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                    </svg>
                    <span class="text-xs font-medium">{{ ucfirst($product->type) }}</span>
                </div>
            @endif

            <!-- Type badge overlay -->
            <div class="absolute top-3 left-3">
                <span class="tag-pill badge-{{ $product->type }}">{{ $product->type }}</span>
            </div>

            <!-- Downloads overlay -->
            <div class="absolute top-3 right-3 bg-black bg-opacity-50 text-white rounded-lg px-2 py-0.5 text-xs flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                {{ number_format($product->downloads) }}
            </div>

            <!-- Quick View overlay button -->
            <div class="overlay-btn absolute bottom-3 left-0 right-0 flex justify-center">
                <a href="{{ route('products.show', $product) }}"
                   class="bg-white text-indigo-600 text-xs font-semibold px-5 py-2 rounded-xl shadow-lg hover:bg-indigo-600 hover:text-white transition-colors">
                    Quick View
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="p-4 flex flex-col flex-1">
            <!-- Category -->
            <p class="text-xs text-gray-400 font-medium mb-1">{{ $product->category->name ?? '' }}</p>

            <!-- Title -->
            <h2 class="font-bold text-gray-900 text-sm leading-snug mb-2 line-clamp-2">
                {{ $product->title }}
            </h2>

            <!-- Description -->
            <p class="text-gray-400 text-xs leading-relaxed mb-3 line-clamp-2 flex-1">
                {{ Str::limit(strip_tags($product->description), 80) }}
            </p>

            <!-- Stars (static for now, extend with real ratings later) -->
            

            <!-- Demo/Preview link (replaces price) -->
<!-- Product Action -->
<div class="mt-auto pt-3 border-t border-gray-50">
    <a href="{{ route('products.show', $product) }}"
       class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2.5 rounded-xl transition-colors flex items-center justify-center gap-2">

        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>

        View Details
    </a>
</div>
        </div>
    </div>

    @empty
    <!-- Empty State -->
    <div class="col-span-4 py-24 text-center">
        <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">No products found</h3>
        <p class="text-gray-400 mb-6">
            @if(request('search'))
                No results for <strong>"{{ request('search') }}"</strong> — try different keywords.
            @else
                No products are available yet. Check back soon!
            @endif
        </p>
        @if(request()->hasAny(['search','category','type']))
            <a href="{{ route('products.index') }}"
               class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-indigo-700 transition-colors">
                Browse All Products
            </a>
        @endif
    </div>
    @endforelse
</div>

<!-- ── PAGINATION ─────────────────────────────────────────────── -->
@if($products->hasPages())
<div class="mt-10 flex flex-col items-center gap-3">
    <div class="pagination">
        {{ $products->appends(request()->query())->links() }}
    </div>
    <p class="text-xs text-gray-400">
        Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} products
    </p>
</div>
@endif

@endsection