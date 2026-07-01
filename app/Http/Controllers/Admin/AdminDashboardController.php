<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Order, Product, User};

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_revenue'  => Order::where('status', 'paid')->sum('amount'),
            'total_orders'   => Order::count(),
            'total_products' => Product::count(),
            'total_users'    => User::where('role', 'customer')->count(),
        ];
        $recent_orders = Order::with(['user', 'product'])->latest()->take(10)->get();
        return view('admin.dashboard', compact('stats', 'recent_orders'));
    }
}