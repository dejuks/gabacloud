@extends('layouts.admin')
@section('title', 'Add Category')
@section('content')
<div class="max-w-lg">
    <a href="{{ route('admin.categories.index') }}" class="text-indigo-600 text-sm hover:underline mb-4 inline-block">← Back</a>
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="font-semibold text-lg mb-4">New Category</h2>
        @if($errors->any())
            <div class="bg-red-50 text-red-700 p-3 rounded mb-4 text-sm">
                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Name</label>
                <input name="name" value="{{ old('name') }}" required
                    class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Description</label>
                <textarea name="description" rows="3"
                    class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">{{ old('description') }}</textarea>
            </div>
            <button class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-indigo-700">
                Create Category
            </button>
        </form>
    </div>
</div>
@endsection