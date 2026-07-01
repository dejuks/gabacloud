@extends('layouts.app')
@section('title', $product->title)
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
    * { font-family: 'Inter', sans-serif; }

    .price-gradient {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .buy-btn {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        transition: all 0.3s ease;
        box-shadow: 0 8px 24px rgba(99,102,241,0.35);
    }
    .buy-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(99,102,241,0.45);
    }

    .download-btn {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        box-shadow: 0 8px 24px rgba(5,150,105,0.3);
        transition: all 0.3s ease;
    }
    .download-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(5,150,105,0.4);
    }

    .preview-btn {
        border: 2px solid #e5e7eb;
        transition: all 0.25s ease;
    }
    .preview-btn:hover {
        border-color: #4f46e5;
        background: #f5f3ff;
        color: #4f46e5;
    }

    /* Sticky buy panel */
    .sticky-panel {
        position: sticky;
        top: 24px;
    }

    /* Tabs */
    .tab-btn {
        padding: 10px 20px;
        border-bottom: 2px solid transparent;
        font-weight: 500;
        font-size: 14px;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .tab-btn.active {
        border-color: #4f46e5;
        color: #4f46e5;
    }
    .tab-btn:hover:not(.active) { color: #374151; }

    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* Prose description */
    .prose-content h1,.prose-content h2,.prose-content h3 {
        font-weight: 700; color: #111827; margin: 1.2em 0 0.5em;
    }
    .prose-content h2 { font-size: 1.25rem; }
    .prose-content h3 { font-size: 1.1rem; }
    .prose-content p  { color: #4b5563; line-height: 1.75; margin-bottom: 0.9em; }
    .prose-content ul,.prose-content ol { padding-left: 1.5em; margin-bottom: 0.9em; }
    .prose-content li { color: #4b5563; line-height: 1.7; margin-bottom: 0.3em; }
    .prose-content strong { color: #111827; font-weight: 600; }
    .prose-content a { color: #4f46e5; text-decoration: underline; }
    .prose-content blockquote {
        border-left: 3px solid #c7d2fe; padding-left: 1em;
        color: #6b7280; font-style: italic; margin: 1em 0;
    }
    .prose-content table { width: 100%; border-collapse: collapse; margin: 1em 0; font-size: 14px; }
    .prose-content th {
        background: #f5f3ff; color: #4f46e5;
        padding: 10px 14px; text-align: left; font-weight: 600;
        border: 1px solid #e5e7eb;
    }
    .prose-content td { padding: 9px 14px; border: 1px solid #e5e7eb; color: #374151; }
    .prose-content tr:nth-child(even) td { background: #fafafa; }

    /* Gallery */
    .gallery-thumb {
        cursor: pointer;
        transition: all 0.2s;
        border: 2px solid transparent;
    }
    .gallery-thumb:hover, .gallery-thumb.active {
        border-color: #4f46e5;
        opacity: 1 !important;
    }

    /* Feature item */
    .feature-item {
        display: flex; align-items: flex-start; gap: 12px;
        padding: 12px 0; border-bottom: 1px solid #f3f4f6;
    }
    .feature-item:last-child { border-bottom: none; }

    /* Star */
    .star { color: #f59e0b; }

    /* Related card */
    .related-card {
        transition: all 0.3s ease;
    }
    .related-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(99,102,241,0.12);
    }

    /* Badge */
    .badge-software  { background:#ede9fe; color:#6d28d9; }
    .badge-template  { background:#dbeafe; color:#1d4ed8; }
    .badge-plugin    { background:#d1fae5; color:#065f46; }
    .badge-other     { background:#fef3c7; color:#92400e; }

    /* Pulse animation for buy button */
    @keyframes pulse-ring {
        0%   { box-shadow: 0 0 0 0 rgba(99,102,241,0.4); }
        70%  { box-shadow: 0 0 0 12px rgba(99,102,241,0); }
        100% { box-shadow: 0 0 0 0 rgba(99,102,241,0); }
    }
    .pulse { animation: pulse-ring 2s infinite; }

    /* Breadcrumb */
    .breadcrumb a { color: #6b7280; font-size: 13px; }
    .breadcrumb a:hover { color: #4f46e5; }
    .breadcrumb span { color: #d1d5db; margin: 0 6px; font-size: 13px; }
</style>

<!-- ── BREADCRUMB ─────────────────────────────────────────── -->
<div class="breadcrumb flex items-center mb-6">
    <a href="{{ route('home') }}">Home</a>
    <span>/</span>
    <a href="{{ route('products.index') }}">Products</a>
    <span>/</span>
    <a href="{{ route('products.index', ['category' => $product->category_id]) }}">{{ $product->category->name }}</a>
    <span>/</span>
    <span class="text-gray-800 text-sm font-medium truncate max-w-xs">{{ $product->title }}</span>
</div>

<!-- ── MAIN LAYOUT: LEFT CONTENT + RIGHT STICKY PANEL ────── -->
<div class="flex flex-col lg:flex-row gap-8 items-start">

    <!-- ── LEFT COLUMN ───────────────────────────────────── -->
    <div class="flex-1 min-w-0">

        <!-- Hero Image -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            @if($product->thumbnail)
                <div class="relative">
                    <img id="mainImage"
                         src="{{ Storage::url($product->thumbnail) }}"
                         alt="{{ $product->title }}"
                         class="w-full h-72 object-cover">
                    <!-- Type chip on image -->
                    <div class="absolute top-4 left-4">
                        <span class="badge-{{ $product->type }} text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                            {{ $product->type }}
                        </span>
                    </div>
                    @if($product->downloads > 0)
                    <div class="absolute top-4 right-4 bg-black bg-opacity-60 text-white text-xs px-3 py-1 rounded-full flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        {{ number_format($product->downloads) }} downloads
                    </div>
                    @endif
                </div>
            @else
                <div class="w-full h-72 bg-gradient-to-br from-indigo-50 via-purple-50 to-blue-50 flex flex-col items-center justify-center">
                    <svg class="w-20 h-20 text-indigo-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                    </svg>
                    <span class="text-indigo-300 font-medium">{{ $product->title }}</span>
                </div>
            @endif
        </div>

        <!-- Title + Meta (mobile visible, hidden on desktop) -->
        <div class="lg:hidden bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">
            <span class="badge-{{ $product->type }} text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">{{ $product->type }}</span>
            <h1 class="text-2xl font-extrabold text-gray-900 mt-3 mb-2">{{ $product->title }}</h1>
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center gap-0.5">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-4 h-4 star" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                    <span class="text-sm text-gray-400 ml-1">5.0</span>
                </div>
                <span class="text-gray-300">•</span>
                <span class="text-sm text-gray-500">{{ $product->category->name }}</span>
            </div>
            <div class="price-gradient text-3xl font-extrabold mb-4">ETB {{ number_format($product->price, 2) }}</div>
            @if($alreadyPurchased)
                <a href="{{ route('orders.download', $userOrder) }}" class="download-btn w-full text-white py-3.5 rounded-xl font-bold text-center flex items-center justify-center gap-2 mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download Now
                </a>
            @else
                <a href="{{ route('payment.checkout', $product) }}" class="buy-btn pulse w-full text-white py-3.5 rounded-xl font-bold text-center flex items-center justify-center gap-2 mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Buy Now — ETB {{ number_format($product->price, 2) }}
                </a>
            @endif
            @if($product->preview_url)
                <a href="{{ $product->preview_url }}" target="_blank" class="preview-btn w-full py-3 rounded-xl font-semibold text-center flex items-center justify-center gap-2 text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Live Preview
                </a>
            @endif
        </div>

        <!-- ── TABS ──────────────────────────────────────── -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex border-b border-gray-100 overflow-x-auto">
                <button class="tab-btn active" onclick="switchTab('description', this)">📄 Description</button>
                <button class="tab-btn" onclick="switchTab('features', this)">✅ Features</button>
                <button class="tab-btn" onclick="switchTab('requirements', this)">⚙️ Requirements</button>
                <button class="tab-btn" onclick="switchTab('changelog', this)">📋 Changelog</button>
            </div>

            <!-- Description Tab -->
            <div id="tab-description" class="tab-panel active p-6 lg:p-8">
                <div class="prose-content">
                    {!! $product->description !!}
                </div>
            </div>

            <!-- Features Tab -->
            <div id="tab-features" class="tab-panel p-6 lg:p-8">
                <h3 class="font-bold text-gray-900 mb-4 text-lg">What's Included</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @php
                        $features = [
                            'Clean & well-commented source code',
                            'Responsive design — works on all devices',
                            'Detailed documentation included',
                            'Free lifetime updates',
                            'Email support for 6 months',
                            'Easy installation guide',
                            'No coding knowledge required to install',
                            'Regular security updates',
                        ];
                    @endphp
                    @foreach($features as $feature)
                    <div class="flex items-start gap-3 p-3 bg-green-50 rounded-xl">
                        <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-700 font-medium">{{ $feature }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Requirements Tab -->
            <div id="tab-requirements" class="tab-panel p-6 lg:p-8">
                <h3 class="font-bold text-gray-900 mb-4 text-lg">Server Requirements</h3>
                <div class="space-y-0">
                    @php
                        $reqs = [
                            ['label' => 'PHP Version',    'value' => '8.1 or higher'],
                            ['label' => 'Laravel',         'value' => '10.x / 11.x / 12.x'],
                            ['label' => 'MySQL',           'value' => '5.7+ or MariaDB 10.3+'],
                            ['label' => 'Web Server',      'value' => 'Apache / Nginx'],
                            ['label' => 'Extensions',      'value' => 'OpenSSL, PDO, Mbstring, Tokenizer, XML, cURL'],
                            ['label' => 'Composer',        'value' => '2.x'],
                            ['label' => 'Disk Space',      'value' => 'Minimum 100MB'],
                        ];
                    @endphp
                    @foreach($reqs as $req)
                    <div class="feature-item">
                        <svg class="w-4 h-4 text-indigo-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                        </svg>
                        <div class="flex justify-between w-full">
                            <span class="text-sm font-semibold text-gray-700">{{ $req['label'] }}</span>
                            <span class="text-sm text-gray-500">{{ $req['value'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Changelog Tab -->
            <div id="tab-changelog" class="tab-panel p-6 lg:p-8">
                <h3 class="font-bold text-gray-900 mb-6 text-lg">Version History</h3>
                <div class="space-y-6">
                    @php
                        $logs = [
                            ['version' => 'v1.0.0', 'date' => 'Initial Release', 'changes' => ['Initial release', 'Core features included', 'Full documentation']],
                        ];
                    @endphp
                    @foreach($logs as $log)
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-3 h-3 bg-indigo-500 rounded-full mt-1"></div>
                            <div class="w-0.5 bg-gray-200 flex-1 mt-2"></div>
                        </div>
                        <div class="pb-6">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full">{{ $log['version'] }}</span>
                                <span class="text-xs text-gray-400">{{ $log['date'] }}</span>
                            </div>
                            <ul class="space-y-1">
                                @foreach($log['changes'] as $change)
                                    <li class="text-sm text-gray-600 flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 bg-indigo-400 rounded-full"></span>
                                        {{ $change }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- ── RIGHT STICKY PANEL ─────────────────────────────── -->
    <div class="w-full lg:w-80 flex-shrink-0 hidden lg:block">
        <div class="sticky-panel space-y-4">

            <!-- Buy Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <!-- Title -->
                <div class="mb-4">
                    <span class="badge-{{ $product->type }} text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                        {{ $product->type }}
                    </span>
                    <h1 class="text-xl font-extrabold text-gray-900 mt-3 leading-snug">{{ $product->title }}</h1>
                    <p class="text-sm text-gray-400 mt-1">{{ $product->category->name }}</p>
                </div>

                <!-- Stars + Downloads -->
                <div class="flex items-center justify-between mb-5 pb-5 border-b border-gray-100">
                    <div class="flex items-center gap-1">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 star" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                        <span class="text-xs text-gray-500 ml-1">5.0 rating</span>
                    </div>
                    <div class="flex items-center gap-1 text-gray-500 text-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        {{ number_format($product->downloads) }} downloads
                    </div>
                </div>

                <!-- Price -->
                <div class="mb-5">
                    <div class="price-gradient text-4xl font-extrabold">
                        ETB {{ number_format($product->price, 2) }}
                    </div>
                    <p class="text-xs text-gray-400 mt-1">One-time payment • Lifetime access</p>
                </div>

                <!-- CTA Buttons -->
                @if($alreadyPurchased)
                    <a href="{{ route('orders.download', $userOrder) }}"
                       class="download-btn w-full text-white py-4 rounded-xl font-bold text-center flex items-center justify-center gap-2 mb-3 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download Now
                    </a>
                    <div class="bg-green-50 rounded-xl p-3 text-center">
                        <p class="text-green-700 text-xs font-semibold">✅ You own this product</p>
                    </div>
                @else
                    <a href="{{ route('payment.checkout', $product) }}"
                       class="buy-btn pulse w-full text-white py-4 rounded-xl font-bold text-center flex items-center justify-center gap-2 mb-3 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Buy Now — ETB {{ number_format($product->price, 2) }}
                    </a>
                    @if($product->preview_url)
                        <a href="{{ $product->preview_url }}" target="_blank"
                           class="preview-btn w-full py-3 rounded-xl font-semibold text-center flex items-center justify-center gap-2 text-gray-600 text-sm mb-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Live Preview
                        </a>
                    @endif
                    <p class="text-center text-xs text-gray-400">🔒 Secure payment via Chapa</p>
                @endif
            </div>

            <!-- Includes Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-bold text-gray-900 mb-4 text-sm">This product includes</h3>
                @php
                    $includes = [
                        ['icon' => '📁', 'text' => 'Full source code'],
                        ['icon' => '📖', 'text' => 'Documentation'],
                        ['icon' => '🔄', 'text' => 'Free future updates'],
                        ['icon' => '💬', 'text' => '6 months support'],
                        ['icon' => '🔑', 'text' => 'Commercial license'],
                    ];
                @endphp
                <div class="space-y-3">
                    @foreach($includes as $item)
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <span class="text-base">{{ $item['icon'] }}</span>
                        {{ $item['text'] }}
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Product Info Card -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-bold text-gray-900 mb-4 text-sm">Product Info</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Category</span>
                        <span class="font-medium text-gray-700">{{ $product->category->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Type</span>
                        <span class="font-medium text-gray-700">{{ ucfirst($product->type) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Last Updated</span>
                        <span class="font-medium text-gray-700">{{ $product->updated_at->format('M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Downloads</span>
                        <span class="font-medium text-indigo-600">{{ number_format($product->downloads) }}</span>
                    </div>
                </div>
            </div>

            <!-- Trust Badges -->
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100 p-5">
                <div class="grid grid-cols-3 gap-3 text-center">
                    <div>
                        <div class="text-2xl mb-1">🔒</div>
                        <p class="text-xs text-gray-600 font-medium">Secure<br>Payment</p>
                    </div>
                    <div>
                        <div class="text-2xl mb-1">⚡</div>
                        <p class="text-xs text-gray-600 font-medium">Instant<br>Download</p>
                    </div>
                    <div>
                        <div class="text-2xl mb-1">🛡️</div>
                        <p class="text-xs text-gray-600 font-medium">Money<br>Back</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ── RELATED PRODUCTS ───────────────────────────────────── -->
@if(isset($related) && $related->count())
<div class="mt-14">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-extrabold text-gray-900">Related Products</h2>
        <a href="{{ route('products.index', ['category' => $product->category_id]) }}"
           class="text-indigo-600 text-sm font-semibold hover:underline">
            View all →
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach($related as $rel)
        <div class="related-card bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            @if($rel->thumbnail)
                <img src="{{ Storage::url($rel->thumbnail) }}" alt="{{ $rel->title }}" class="w-full h-36 object-cover">
            @else
                <div class="w-full h-36 bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center text-3xl">📦</div>
            @endif
            <div class="p-4">
                <h3 class="font-bold text-gray-900 text-sm mb-1 line-clamp-2">{{ $rel->title }}</h3>
                <div class="flex items-center justify-between mt-3">
                    <span class="font-extrabold text-indigo-600 text-sm">ETB {{ number_format($rel->price, 2) }}</span>
                    <a href="{{ route('products.show', $rel) }}"
                       class="bg-indigo-600 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-indigo-700 transition-colors">
                        View
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<script>
function switchTab(name, btn) {
    // Hide all panels
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    // Show selected
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
}
</script>

@endsection