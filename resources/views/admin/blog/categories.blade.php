@extends('layouts.admin')
@section('title', 'Blog Categories')
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.blog.index') }}" class="text-indigo-600 text-sm hover:underline mb-4 inline-block">← Back to Posts</a>
    <div class="grid grid-cols-1 gap-6">

        <!-- Add Category Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-lg mb-4">Add New Category</h2>
            @if($errors->any())
                <div class="bg-red-50 text-red-700 p-3 rounded-xl mb-4 text-sm">
                    @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                </div>
            @endif
            <form method="POST" action="{{ route('admin.blog-categories.store') }}" class="flex gap-3">
                @csrf
                <input name="name" placeholder="Category name..." required
                    class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                <button class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700">
                    Add
                </button>
            </form>
        </div>

        <!-- Categories List -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50">
                <h2 class="font-bold text-gray-800">All Categories ({{ $categories->count() }})</h2>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-400 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Slug</th>
                        <th class="px-6 py-3 text-left">Posts</th>
                        <th class="px-6 py-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($categories as $cat)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-semibold text-gray-800">{{ $cat->name }}</td>
                        <td class="px-6 py-3 font-mono text-xs text-gray-400">{{ $cat->slug }}</td>
                        <td class="px-6 py-3">{{ $cat->blogs_count }}</td>
                        <td class="px-6 py-3">
                            <form action="{{ route('admin.blog-categories.destroy', $cat) }}" method="POST"
                                  onsubmit="return confirm('Delete this category?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:underline text-xs">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400">No categories yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection