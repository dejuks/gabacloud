<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::published()->with(['author', 'category'])->latest('published_at');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q
                ->where('title', 'like', "%$s%")
                ->orWhere('excerpt', 'like', "%$s%")
                ->orWhere('content', 'like', "%$s%")
            );
        }

        if ($request->filled('category')) {
            $query->where('blog_category_id', $request->category);
        }

        $posts      = $query->paginate(9)->withQueryString();
        $categories = BlogCategory::withCount('blogs')->get();
        $featured   = Blog::published()->orderByDesc('views')->first();
        $recent     = Blog::published()->latest('published_at')->take(5)->get();

        return view('blog.index', compact('posts', 'categories', 'featured', 'recent'));
    }

    public function show(Blog $blog)
    {
        if ($blog->status !== 'published') {
            abort(404);
        }

        $blog->increment('views');

        $related = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where('blog_category_id', $blog->blog_category_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        $recent = Blog::published()
            ->where('id', '!=', $blog->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('blog.show', compact('blog', 'related', 'recent'));
    }
}