<?php
// app/Http/Controllers/Admin/AdminBlogController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminBlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with(['author', 'category']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $posts = $query->latest()->paginate(15)->withQueryString();
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'excerpt'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'thumbnail'        => 'nullable|image|max:3072',
            'status'           => 'required|in:draft,published',
        ]);

        $validated['content'] = strip_tags($validated['content'],
            '<p><br><strong><em><u><ul><ol><li><a><h1><h2><h3><h4><blockquote><table><thead><tbody><tr><td><th><img><figure><figcaption>'
        );

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('blog/thumbnails', 'public');
        }

        $validated['user_id']      = Auth::id();
        $validated['slug']         = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['published_at'] = $validated['status'] === 'published' ? now() : null;

        Blog::create($validated);

        return redirect()->route('admin.blog.index')->with('success', 'Post created successfully!');
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::all();
        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'excerpt'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'thumbnail'        => 'nullable|image|max:3072',
            'status'           => 'required|in:draft,published',
        ]);

        $validated['content'] = strip_tags($validated['content'],
            '<p><br><strong><em><u><ul><ol><li><a><h1><h2><h3><h4><blockquote><table><thead><tbody><tr><td><th><img><figure><figcaption>'
        );

        if ($request->hasFile('thumbnail')) {
            if ($blog->thumbnail) Storage::disk('public')->delete($blog->thumbnail);
            $validated['thumbnail'] = $request->file('thumbnail')->store('blog/thumbnails', 'public');
        }

        if ($validated['status'] === 'published' && !$blog->published_at) {
            $validated['published_at'] = now();
        }

        $blog->update($validated);

        return redirect()->route('admin.blog.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->thumbnail) Storage::disk('public')->delete($blog->thumbnail);
        $blog->delete();
        return back()->with('success', 'Post deleted.');
    }

    public function toggle(Blog $blog)
    {
        $blog->update([
            'status'       => $blog->status === 'published' ? 'draft' : 'published',
            'published_at' => $blog->status !== 'published' ? now() : $blog->published_at,
        ]);
        return back()->with('success', 'Post status toggled.');
    }
}