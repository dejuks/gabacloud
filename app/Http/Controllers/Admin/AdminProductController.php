<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Category, Product};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'type'        => 'required|in:software,template,plugin,other',
            'thumbnail' => 'nullable|image|max:51200',
            'file' => 'required|file|max:10485760',
            'preview_url' => 'nullable|url',
            'is_active'   => 'boolean',
        ]);

        $filePath  = $request->file('file')->store('products/files', 'private');
        $thumbnail = $request->hasFile('thumbnail')
            ? $request->file('thumbnail')->store('products/thumbnails', 'public')
            : null;

        Product::create([
            'category_id' => $validated['category_id'],
            'title'       => $validated['title'],
            'slug'        => Str::slug($validated['title']) . '-' . Str::random(5),
            'description' => $validated['description'],
            'price'       => $validated['price'],
            'type'        => $validated['type'],
            'thumbnail'   => $thumbnail,
            'file_path'   => $filePath,
            'preview_url' => $validated['preview_url'] ?? null,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'type'        => 'required|in:software,template,plugin,other',
            'thumbnail'   => 'nullable|image|max:2048',
            'file'        => 'nullable|file|max:51200',
            'preview_url' => 'nullable|url',
        ]);

        $data = [
            'category_id' => $validated['category_id'],
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'price'       => $validated['price'],
            'type'        => $validated['type'],
            'preview_url' => $validated['preview_url'] ?? null,
            'is_active'   => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail) Storage::disk('public')->delete($product->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('products/thumbnails', 'public');
        }

        if ($request->hasFile('file')) {
            Storage::disk('private')->delete($product->file_path);
            $data['file_path'] = $request->file('file')->store('products/files', 'private');
        }

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Product updated!');
    }

    public function destroy(Product $product)
    {
        Storage::disk('private')->delete($product->file_path);
        if ($product->thumbnail) Storage::disk('public')->delete($product->thumbnail);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    public function toggle(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        return back()->with('success', 'Product status toggled.');
    }
}