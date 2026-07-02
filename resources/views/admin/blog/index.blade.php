@extends('layouts.admin')
@section('title', 'Blog Posts')
@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-semibold">Blog Posts ({{ $posts->total() }})</h2>
    <a href="{{ route('admin.blog.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 flex items-center gap-2">
        ✍️ New Post
    </a>
</div>

<!-- Filter -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-5 flex flex-wrap gap-3 items-center">
    <form method="GET" class="flex gap-2 flex-1 flex-wrap">
        <input name="search" value="{{ request('search') }}" placeholder="Search posts..."
            class="border rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 flex-1 min-w-0">
        <select name="status" class="border rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
            <option value="">All Status</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>Draft</option>
        </select>
        <button class="bg-indigo-600 text-white px-4 py-1.5 rounded-lg text-sm">Filter</button>
        @if(request()->hasAny(['search','status']))
            <a href="{{ route('admin.blog.index') }}" class="text-red-500 text-sm self-center">✕ Clear</a>
        @endif
    </form>
    <a href="{{ route('admin.blog-categories.index') }}"
       class="text-indigo-600 text-sm font-medium hover:underline whitespace-nowrap">
        🗂️ Manage Categories
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-400 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">Post</th>
                <th class="px-6 py-3 text-left">Category</th>
                <th class="px-6 py-3 text-left">Author</th>
                <th class="px-6 py-3 text-left">Views</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Date</th>
                <th class="px-6 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($posts as $post)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3">
                    <div class="flex items-center gap-3">
                        @if($post->thumbnail)
                            <img src="{{ Storage::url($post->thumbnail) }}" class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                        @else
                            <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center text-lg flex-shrink-0">📝</div>
                        @endif
                        <div>
                            <p class="font-semibold text-gray-800 line-clamp-1">{{ $post->title }}</p>
                            <p class="text-xs text-gray-400">{{ $post->read_time }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-3 text-gray-500">{{ $post->category?->name ?? '—' }}</td>
                <td class="px-6 py-3 text-gray-500">{{ $post->author->name }}</td>
                <td class="px-6 py-3 text-gray-500">{{ number_format($post->views) }}</td>
                <td class="px-6 py-3">
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                        {{ $post->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($post->status) }}
                    </span>
                </td>
                <td class="px-6 py-3 text-gray-400 text-xs">
                    {{ $post->published_at?->format('d M Y') ?? 'Draft' }}
                </td>
                <td class="px-6 py-3">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('blog.show', $post) }}" target="_blank"
                           class="text-gray-400 hover:text-indigo-600 text-xs">View</a>
                        <a href="{{ route('admin.blog.edit', $post) }}"
                           class="text-indigo-600 hover:underline text-xs">Edit</a>
                        <form action="{{ route('admin.blog.toggle', $post) }}" method="POST">
                            @csrf
                            <button class="text-yellow-600 hover:underline text-xs">
                                {{ $post->status === 'published' ? 'Unpublish' : 'Publish' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.blog.destroy', $post) }}" method="POST"
                              onsubmit="return confirm('Delete this post?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:underline text-xs">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-16 text-center text-gray-400">
                    <div class="text-4xl mb-2">📝</div>
                    No posts yet. <a href="{{ route('admin.blog.create') }}" class="text-indigo-600 hover:underline">Create your first post</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">{{ $posts->links() }}</div>
</div>
@endsection