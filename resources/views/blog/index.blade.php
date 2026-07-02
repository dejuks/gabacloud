@extends('layouts.app')
@section('title', 'Blog')
@section('content')

<style>
    .blog-card { transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
    .blog-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(99,102,241,0.12); }
    .blog-card:hover .blog-img { transform: scale(1.06); }
    .blog-img { transition: transform 0.4s ease; }
    .line-clamp-2 { display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden; }
    .line-clamp-3 { display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden; }
</style>

<!-- Hero -->
<div class="bg-gradient-to-r from-indigo-900 via-indigo-700 to-purple-700 rounded-3xl p-10 mb-10 text-white text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle at 20% 50%, white 1px, transparent 1px),radial-gradient(circle at 80% 20%, white 1px, transparent 1px);background-size:40px 40px;"></div>
    <div class="relative z-10">
        <p class="text-indigo-300 text-xs font-bold tracking-widest uppercase mb-2">Knowledge Hub</p>
        <h1 class="text-4xl font-extrabold mb-3">Our Blog</h1>
        <p class="text-indigo-200 mb-6">Tutorials, tips, and insights on software development</p>
        <form method="GET" action="{{ route('blog.index') }}" class="flex max-w-md mx-auto gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search articles..."
                class="flex-1 px-4 py-2.5 rounded-xl text-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            <button class="bg-indigo-500 hover:bg-indigo-400 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                Search
            </button>
        </form>
    </div>
</div>

<div class="flex flex-col lg:flex-row gap-8">

    <!-- Posts Grid -->
    <div class="flex-1">
        <!-- Featured Post --> 
        @if($featured && !request()->hasAny(['search','category']))
        <div class="mb-8">
            <p class="text-xs font-bold text-indigo-600 uppercase tracking-widest mb-3">⭐ Featured Post</p>
            <a href="{{ route('blog.show', $featured) }}"
               class="blog-card block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    @if($featured->thumbnail)
                        <div class="md:w-2/5 h-52 md:h-auto overflow-hidden">
                            <img src="{{ Storage::url($featured->thumbnail) }}" alt="{{ $featured->title }}"
                                 class="blog-img w-full h-full object-cover">
                        </div>
                    @else
                        <div class="md:w-2/5 h-52 bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center text-5xl">📝</div>
                    @endif
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div>
                            @if($featured->category)
                                <span class="text-xs bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full font-semibold">{{ $featured->category->name }}</span>
                            @endif
                            <h2 class="text-xl font-extrabold text-gray-900 mt-3 mb-2 line-clamp-2">{{ $featured->title }}</h2>
                            <p class="text-gray-500 text-sm line-clamp-3">{{ $featured->excerpt ?? Str::limit(strip_tags($featured->content), 150) }}</p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <span>✍️ {{ $featured->author->name }}</span>
                                <span>•</span>
                                <span>{{ $featured->published_at?->format('M d, Y') }}</span>
                                <span>•</span>
                                <span>{{ $featured->read_time }}</span>
                            </div>
                            <span class="text-indigo-600 text-xs font-bold">Read more →</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endif

        <!-- Filter Chips -->
        <div class="flex items-center flex-wrap gap-2 mb-6">
            <a href="{{ route('blog.index', request()->except('category')) }}"
               class="px-4 py-1.5 rounded-xl text-sm font-medium border transition-all
                      {{ !request('category') ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:border-indigo-400' }}">
                All
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('blog.index', array_merge(request()->query(), ['category' => $cat->id])) }}"
                   class="px-4 py-1.5 rounded-xl text-sm font-medium border transition-all
                          {{ request('category') == $cat->id ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:border-indigo-400' }}">
                    {{ $cat->name }} <span class="opacity-60">({{ $cat->blogs_count }})</span>
                </a>
            @endforeach
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($posts as $post)
            <a href="{{ route('blog.show', $post) }}"
               class="blog-card block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-hidden h-44">
                    @if($post->thumbnail)
                        <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}"
                             class="blog-img w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center text-4xl">📝</div>
                    @endif
                </div>
                <div class="p-4">
                    @if($post->category)
                        <span class="text-xs bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full font-semibold">{{ $post->category->name }}</span>
                    @endif
                    <h3 class="font-bold text-gray-900 mt-2 mb-1 line-clamp-2 text-sm leading-snug">{{ $post->title }}</h3>
                    <p class="text-gray-400 text-xs line-clamp-2 mb-3">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 90) }}</p>
                    <div class="flex items-center justify-between text-xs text-gray-400 pt-3 border-t border-gray-50">
                        <span>{{ $post->published_at?->format('M d, Y') }}</span>
                        <span>{{ $post->read_time }}</span>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-3 py-20 text-center">
                <div class="text-5xl mb-4">📭</div>
                <p class="text-gray-500 font-medium">No articles found</p>
                @if(request('search'))
                    <a href="{{ route('blog.index') }}" class="text-indigo-600 text-sm mt-2 inline-block hover:underline">Clear search</a>
                @endif
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="mt-8">{{ $posts->appends(request()->query())->links() }}</div>
        @endif
    </div>

    <!-- Sidebar -->
    <aside class="w-full lg:w-72 flex-shrink-0 space-y-6">

        <!-- Recent Posts -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-gray-900 mb-4 text-sm">Recent Posts</h3>
            <div class="space-y-4">
                @foreach($recent as $r)
                <a href="{{ route('blog.show', $r) }}" class="flex gap-3 group">
                    <div class="w-14 h-14 rounded-xl overflow-hidden flex-shrink-0 bg-indigo-50">
                        @if($r->thumbnail)
                            <img src="{{ Storage::url($r->thumbnail) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xl">📝</div>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800 group-hover:text-indigo-600 line-clamp-2 leading-snug">{{ $r->title }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $r->published_at?->format('M d, Y') }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Categories -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-gray-900 mb-4 text-sm">Categories</h3>
            <div class="space-y-2">
                @foreach($categories as $cat)
                <a href="{{ route('blog.index', ['category' => $cat->id]) }}"
                   class="flex items-center justify-between py-2 px-3 rounded-xl hover:bg-indigo-50 group transition-colors">
                    <span class="text-sm text-gray-600 group-hover:text-indigo-600">{{ $cat->name }}</span>
                    <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">{{ $cat->blogs_count }}</span>
                </a>
                @endforeach
            </div>
        </div>

        <!-- CTA -->
        <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-5 text-white text-center">
            <div class="text-3xl mb-2">🛍️</div>
            <h3 class="font-bold mb-1">Browse Products</h3>
            <p class="text-indigo-200 text-xs mb-4">Premium scripts & templates for your next project</p>
            <a href="{{ route('products.index') }}"
               class="block bg-white text-indigo-600 font-bold py-2 rounded-xl text-sm hover:bg-indigo-50 transition-colors">
                View Products
            </a>
        </div>

    </aside>
</div>
@endsection