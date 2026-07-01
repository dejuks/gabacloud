@extends('layouts.admin')
@section('title', 'Add Product')
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.products.index') }}" class="text-indigo-600 text-sm hover:underline mb-4 inline-block">← Back</a>
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="font-semibold text-lg mb-6">New Product</h2>
        @if($errors->any())
            <div class="bg-red-50 text-red-700 p-3 rounded mb-4 text-sm">
                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-1">Title</label>
                    <input name="title" value="{{ old('title') }}" required
                        class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Category</label>
                    <select name="category_id" required
                        class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                        <option value="">Select...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Type</label>
                    <select name="type" required
                        class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                        @foreach(['software','template','plugin','other'] as $t)
                            <option value="{{ $t }}" {{ old('type') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Price (ETB)</label>
                    <input name="price" type="number" step="0.01" value="{{ old('price') }}" required
                        class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Preview URL</label>
                    <input name="preview_url" type="url" value="{{ old('preview_url') }}"
                        class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" id="description" rows="8"
                        class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Thumbnail (image)</label>
                    <input name="thumbnail" type="file" accept="image/*"
                        class="w-full border rounded-lg px-4 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Product File (zip/rar)</label>
                    <input name="file" type="file" required
                        class="w-full border rounded-lg px-4 py-2 text-sm">
                </div>
                <div class="col-span-2">
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="is_active" value="1" checked> Active (visible to customers)
                    </label>
                </div>
            </div>
            <button class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-indigo-700">
                Create Product
            </button>
        </form>
    </div>
</div>

<!-- CKEditor 5 (Classic Build via CDN) -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'underline', 'link', '|',
                'bulletedList', 'numberedList', 'blockQuote', '|',
                'insertTable', 'undo', 'redo'
            ]
        })
        .then(editor => {
            // Ensure the textarea value updates before form submit
            const form = editor.sourceElement.closest('form');
            form.addEventListener('submit', () => {
                editor.updateSourceElement();
            });
        })
        .catch(error => {
            console.error('CKEditor failed to load:', error);
        });
</script>
@endsection