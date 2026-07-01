@extends('layouts.admin')
@section('title', 'Categories')
@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-semibold">Categories</h2>
    <a href="{{ route('admin.categories.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">+ Add Category</a>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">Name</th>
                <th class="px-6 py-3 text-left">Slug</th>
                <th class="px-6 py-3 text-left">Products</th>
                <th class="px-6 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($categories as $category)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 font-medium">{{ $category->name }}</td>
                <td class="px-6 py-3 text-gray-400 font-mono text-xs">{{ $category->slug }}</td>
                <td class="px-6 py-3">{{ $category->products_count }}</td>
                <td class="px-6 py-3 flex gap-3">
                    <a href="{{ route('admin.categories.edit', $category) }}"
                       class="text-indigo-600 hover:underline text-xs">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                          onsubmit="return confirm('Delete this category?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline text-xs">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-10 text-center text-gray-400">No categories yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection