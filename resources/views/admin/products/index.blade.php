@extends('layouts.admin')
@section('title', 'Products')
@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-semibold">Products ({{ $products->total() }})</h2>
    <a href="{{ route('admin.products.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">+ Add Product</a>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">Product</th>
                <th class="px-6 py-3 text-left">Category</th>
                <th class="px-6 py-3 text-left">Price</th>
                <th class="px-6 py-3 text-left">Downloads</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($products as $product)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3">
                    <div class="font-medium">{{ Str::limit($product->title, 35) }}</div>
                    <div class="text-xs text-gray-400">{{ $product->type }}</div>
                </td>
                <td class="px-6 py-3 text-gray-500">{{ $product->category->name }}</td>
                <td class="px-6 py-3 font-semibold">ETB {{ number_format($product->price, 2) }}</td>
                <td class="px-6 py-3">{{ $product->downloads }}</td>
                <td class="px-6 py-3">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                        {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-6 py-3 flex items-center gap-3">
                    <a href="{{ route('admin.products.edit', $product) }}"
                       class="text-indigo-600 hover:underline text-xs">Edit</a>
                    <form action="{{ route('admin.products.toggle', $product) }}" method="POST">
                        @csrf
                        <button class="text-yellow-600 hover:underline text-xs">
                            {{ $product->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                          onsubmit="return confirm('Delete this product?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline text-xs">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-10 text-center text-gray-400">No products yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">{{ $products->links() }}</div>
</div>
@endsection