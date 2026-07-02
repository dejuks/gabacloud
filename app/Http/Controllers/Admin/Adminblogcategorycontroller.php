<?php
// app/Http/Controllers/Admin/AdminBlogCategoryController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::withCount('blogs')->latest()->get();
        return view('admin.blog.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:blog_categories,name']);
        BlogCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return back()->with('success', 'Category created.');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();
        return back()->with('success', 'Category deleted.');
    }
}