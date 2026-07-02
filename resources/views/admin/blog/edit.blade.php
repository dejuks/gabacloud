@extends('layouts.admin')
@section('title', 'Edit Post')
@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.blog.index') }}" class="text-indigo-600 text-sm hover:underline mb-4 inline-block">← Back to Posts</a>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="font-bold text-lg mb-6">Edit: {{ Str::limit($blog->title, 50) }}</h2>
        @if($errors->any())
            <div class="bg-red-50 text-red-700 p-3 rounded-xl mb-4 text-sm">
                @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('admin.blog.update', $blog) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold mb-1.5 text-gray-700">Post Title <span class="text-red-500">*</span></label>
                <input name="title" value="{{ old('title', $blog->title) }}" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-1.5 text-gray-700">Category</label>
                    <select name="blog_category_id"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                        <option value="">No Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('blog_category_id', $blog->blog_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1.5 text-gray-700">Status</label>
                    <select name="status" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                        <option value="draft"     {{ old('status', $blog->status) === 'draft'     ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $blog->status) === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1.5 text-gray-700">Excerpt</label>
                <textarea name="excerpt" rows="2" maxlength="500"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">{{ old('excerpt', $blog->excerpt) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1.5 text-gray-700">Thumbnail</label>
                @if($blog->thumbnail)
                    <img src="{{ Storage::url($blog->thumbnail) }}" class="h-24 rounded-xl object-cover mb-2">
                @endif
                <input name="thumbnail" type="file" accept="image/*"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm">
                <p class="text-xs text-gray-400 mt-1">Leave blank to keep current image</p>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1.5 text-gray-700">Content <span class="text-red-500">*</span></label>
                <textarea name="content" id="blog_content" rows="10"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">{{ old('content', $blog->content) }}</textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700">
                    Save Changes
                </button>
                <a href="{{ route('blog.show', $blog) }}" target="_blank"
                   class="border border-gray-200 text-gray-600 px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-50">
                    👁 Preview
                </a>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#blog_content'), {
    toolbar: ['heading','|','bold','italic','underline','link','|','bulletedList','numberedList','blockQuote','|','insertTable','|','undo','redo']
}).then(editor => {
    editor.sourceElement.closest('form').addEventListener('submit', () => editor.updateSourceElement());
}).catch(console.error);
</script>
@endsection