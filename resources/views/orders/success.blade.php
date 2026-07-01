@extends('layouts.app')
@section('title', 'Payment Successful')
@section('content')
<div class="max-w-lg mx-auto text-center mt-10">
    <div class="bg-white rounded-2xl shadow p-10">
        <div class="text-6xl mb-4">🎉</div>
        <h1 class="text-2xl font-bold text-green-600 mb-2">Payment Successful!</h1>
        <p class="text-gray-500 mb-1">You purchased</p>
        <p class="text-xl font-semibold mb-1">{{ $order->product->title }}</p>
        <p class="text-indigo-600 font-bold text-lg mb-6">ETB {{ number_format($order->amount, 2) }}</p>

        <div class="flex flex-col gap-3">
            <a href="{{ route('orders.download', $order) }}"
               class="bg-green-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-green-700">
                ⬇️ Download Now
            </a>
            <a href="{{ route('orders.index') }}"
               class="border border-gray-300 text-gray-600 px-8 py-3 rounded-xl hover:bg-gray-50">
                My Orders
            </a>
        </div>
    </div>
</div>
@endsection