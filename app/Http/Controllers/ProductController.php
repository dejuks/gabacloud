<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->with('category');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Sort
        match ($request->get('sort', 'latest')) {
            'popular'    => $query->orderByDesc('downloads'),
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            default      => $query->latest(),
        };

        $products       = $query->paginate(12)->withQueryString();
        $categories     = Category::all();
        $totalProducts  = Product::where('is_active', true)->count();
        $totalDownloads = Product::where('is_active', true)->sum('downloads');

        // Format downloads for display
        $totalDownloads = $totalDownloads >= 1000
            ? round($totalDownloads / 1000, 1) . 'K+'
            : $totalDownloads . '+';

        return view('products.index', compact(
            'products', 'categories', 'totalProducts', 'totalDownloads'
        ));
    }

    public function show(Product $product)
    {
        $alreadyPurchased = false;
        $userOrder = null;

        if (Auth::check()) {
            $userOrder = Order::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->where('status', 'paid')
                ->first();
            $alreadyPurchased = (bool) $userOrder;
        }

        // Related products (same category, exclude current)
        $related = Product::where('is_active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'alreadyPurchased', 'userOrder', 'related'));
    }
}