<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * List all orders (Admin)
     */
    public function index()
    {
        $orders = Order::with([
            'user',
            'product',
            'payment'
        ])
        ->latest()
        ->paginate(15);

        return view('orders.index', compact('orders'));
    }

    /**
     * Logged-in user's orders
     */
    public function myOrders()
    {
        $orders = Order::with([
            'product',
            'payment'
        ])
        ->where('user_id', Auth::id())
        ->latest()
        ->paginate(10);

        return view('orders.my-orders', compact('orders'));
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        if (
            Auth::id() != $order->user_id &&
            Auth::user()->role != 'admin'
        ) {
            abort(403);
        }

        $order->load([
            'user',
            'product',
            'payment'
        ]);

        return view('orders.show', compact('order'));
    }

    /**
     * Success page
     */
    public function success(Order $order)
    {
        if (
            Auth::id() != $order->user_id &&
            Auth::user()->role != 'admin'
        ) {
            abort(403);
        }

        return view('orders.success', compact('order'));
    }

    /**
     * Cancel pending order
     */
    public function cancel(Order $order)
    {
        if (
            Auth::id() != $order->user_id &&
            Auth::user()->role != 'admin'
        ) {
            abort(403);
        }

        if ($order->status != 'pending') {

            return back()->with(
                'error',
                'Only pending orders can be cancelled.'
            );
        }

        $order->update([
            'status' => 'failed'
        ]);

        return back()->with(
            'success',
            'Order cancelled successfully.'
        );
    }

    /**
     * Delete order
     */
    public function destroy(Order $order)
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $order->delete();

        return redirect()
            ->route('orders.index')
            ->with(
                'success',
                'Order deleted successfully.'
            );
    }
}