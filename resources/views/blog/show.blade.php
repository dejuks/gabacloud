@extends('layouts.app')
@section('title', $blog->title)
@section('content')

<style>
    .prose-content h1,.prose-content h2,.prose-content h3{font-weight:700;color:#111827;margin:1.4em 0 0.5em}
    .prose-content h2{font-size:1.35rem}.prose-content h3{font-size:1.15rem}
    .prose-content p{color:#374151;line-height:1.85;margin-bottom:1em}
    .prose-content ul,.prose-content ol{padding-left:1.6em;margin-bottom:1em}
    .prose-content li{color:#374151;line-height:1.7;margin-bottom:0.4em}
    .prose-content strong{color:#111827;font-weight:700}
    .prose-content a{color:#4f46e5;text-decoration:underline}
    .prose-content blockquote{border-left:4px solid #c7d2fe;padding:0.5em 1.2em;background:#f5f3ff;border-radius:0 8px 8px 0;margin:1.2em 0;font-style:italic;color:#4b5563}
    .prose-content img{border-radius:12px;margin:1.2em 0;max-width:100%}
    .prose-content table{width:100%;border-collapse:collapse;margin:1em 0;font-size:14px}
    .prose-content th{background:#f5f3ff;color:#4f46e5;padding:10px 14px;text-align:left;font-weight:600;border:1px solid #e5e7eb}
    .prose-content td{padding:9px 14px;border:1px solid #e5e7eb;color:#374151}
    .prose-content tr:nth-child(even) td{background:#fafafa}
    .related-card{transition:all 0.25s ease}
    .related-card:hover{transform:translateY(-3px);box-shadow:0 10px 25px rgba(99,102,241,0.12)}
    .share-btn{transition:all 0.2s ease}
    .share-btn:hover{transform:scale(1.08)}
</style>

<!-- Breadcrumb -->
<div class="flex items-center gap-2 text-xs text-gray-400 mb-6 flex-wrap">
    <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
    <span>/</span>
    <a href="{{ route('blog.index') }}" class="hover:text-indigo-600">Blog</a>
    @if($blog->category)
        <span>/</span>
        <a href="{{ route('blog.index', ['category' => $blog->blog_category_id]) }}" class="hover:text-indigo-600">{{ $blog->category->name }}</a>
    @endif
    <span>/</span>
    <span class="text-gray-600 truncate max-w-xs">{{ $blog->title }}</span>
</div>

<div class="flex flex-col lg:flex-row gap-8 items-start">

    <!-- Article -->
    <article class="flex-1 min-w-0">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <!-- Thumbnail -->
            @if($blog->thumbnail)
                <img src="{{ Storage::url($blog->thumbnail) }}" alt="{{ $blog->title }}" class="w-full h-72 object-cover">
            @else
                <div class="w-full h-56 bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center text-6xl">📝</div>
            @endif

            <div class="p-6 lg:p-10">
                <!-- Meta -->
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    @if($blog->category)
                        <span class="bg-indigo-100 text-indigo-600 text-xs font-bold px-3 py-1 rounded-full">{{ $blog->category->name }}</span>
                    @endif
                    <span class="text-xs text-gray-400">{{ $blog->published_at?->format('F d, Y') }}</span>
                    <span class="text-xs text-gray-400">• {{ $blog->read_time }}</span>
                    <span class="text-xs text-gray-400">• 👁 {{ number_format($blog->views) }} views</span>
                </div>

                <!-- Title -->
                <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 leading-tight mb-4">
                    {{ $blog->title }}
                </h1>

                <!-- Author -->
                <div class="flex items-center gap-3 mb-8 pb-8 border-b border-gray-100">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        {{ substr($blog->author->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">{{ $blog->author->name }}</p>
                        <p class="text-xs text-gray-400">Author</p>
                    </div>
                </div>

                <!-- Content -->
                <div class="prose-content">
                    {!! $blog->content !!}
                </div>

                <!-- Share -->
                <div class="mt-10 pt-8 border-t border-gray-100">
                    <p class="text-sm font-bold text-gray-700 mb-3">Share this article</p>
                    <div class="flex gap-3 flex-wrap">
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title) }}&url={{ urlencode(request()->url()) }}"
                           target="_blank"
                           class="share-btn bg-sky-500 text-white px-4 py-2 rounded-xl text-xs font-semibold flex items-center gap-1.5">
                            𝕏 Twitter
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                           target="_blank"
                           class="share-btn bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-semibold flex items-center gap-1.5">
                            Facebook
                        </a>
                        <button onclick="navigator.clipboard.writeText(window.location.href).then(()=>alert('Link copied!'))"
                           class="share-btn bg-gray-100 text-gray-600 px-4 py-2 rounded-xl text-xs font-semibold flex items-center gap-1.5 hover:bg-gray-200">
                            🔗 Copy Link
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related -->
        @if($related->count())
        <div class="mt-10">
            <h2 class="text-xl font-extrabold text-gray-900 mb-5">Related Articles</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach($related as $r)
                <a href="{{ route('blog.show', $r) }}" class="related-card bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden block">
                    @if($r->thumbnail)
                        <img src="{{ Storage::url($r->thumbnail) }}" class="w-full h-36 object-cover">
                    @else
                        <div class="w-full h-36 bg-indigo-50 flex items-center justify-center text-3xl">📝</div>
                    @endif
                    <div class="p-4">
                        <p class="text-sm font-bold text-gray-800 line-clamp-2 leading-snug mb-1">{{ $r->title }}</p>
                        <p class="text-xs text-gray-400">{{ $r->published_at?->format('M d, Y') }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </article>

    <!-- Sidebar -->
    <aside class="w-full lg:w-64 flex-shrink-0 space-y-5 lg:sticky lg:top-6">

        <!-- Recent Posts -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-gray-900 mb-4 text-sm">Recent Posts</h3>
            <div class="space-y-4">
                @foreach($recent as $r)
                <a href="{{ route('blog.show', $r) }}" class="flex gap-3 group">
                    <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0 bg-indigo-50">
                        @if($r->thumbnail)
                            <img src="{{ Storage::url($r->thumbnail) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-lg">📝</div>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-800 group-hover:text-indigo-600 line-clamp-2 leading-snug">{{ $r->title }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $r->published_at?->format('M d') }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Product CTA -->
        <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-5 text-white text-center">
            <div class="text-3xl mb-2">🚀</div>
            <h3 class="font-bold mb-1 text-sm">Ready to Build?</h3>
            <p class="text-indigo-200 text-xs mb-4">Get our premium scripts and save weeks of development</p>
            <a href="{{ route('products.index') }}"
               class="block bg-white text-indigo-600 font-bold py-2 rounded-xl text-xs hover:bg-indigo-50 transition-colors">
                Browse Products
            </a>
        </div>

        <!-- Back to Blog -->
        <a href="{{ route('blog.index') }}"
           class="block bg-white rounded-2xl border border-gray-100 shadow-sm p-4 text-center text-sm font-semibold text-gray-600 hover:text-indigo-600 hover:border-indigo-200 transition-colors">
            ← Back to Blog
        </a>
    </aside>
</div>
@endsection