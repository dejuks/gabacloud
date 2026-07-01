@extends('layouts.app')
@section('title', 'My Orders')
@section('content')

<h1 class="text-2xl font-bold mb-6">My Orders</h1>

@if($orders->isEmpty())
    <div class="bg-white rounded-2xl shadow p-16 text-center">
        <p class="text-4xl mb-4">🛒</p>
        <p class="text-gray-500 mb-4">You haven't purchased anything yet.</p>
        <a href="{{ route('products.index') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
            Browse Products
        </a>
    </div>
@else
    <div class="space-y-4">
        @foreach($orders as $order)
        <div class="bg-white rounded-2xl shadow p-5 flex items-center gap-5">
            <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">
                📦
            </div>
            <div class="flex-1">
                <h3 class="font-semibold">{{ $order->product->title }}</h3>
                <p class="text-sm text-gray-400">{{ $order->created_at->format('d M Y') }} · {{ $order->tx_ref }}</p>
            </div>
            <div class="text-right">
                <p class="font-bold text-indigo-600">ETB {{ number_format($order->amount, 2) }}</p>
                @php $c = ['paid'=>'green','pending'=>'yellow','failed'=>'red','refunded'=>'gray'][$order->status] ?? 'gray'; @endphp
                <span class="text-xs px-2 py-0.5 rounded-full bg-{{ $c }}-100 text-{{ $c }}-700">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div class="flex flex-col gap-2 ml-4">
                <a href="{{ route('orders.show', $order) }}"
                   class="text-indigo-600 hover:underline text-sm text-center">Details</a>
                @if($order->status === 'paid')
                    <a href="{{ route('orders.download', $order) }}"
                       class="bg-green-600 text-white px-3 py-1.5 rounded-lg text-sm hover:bg-green-700 text-center">
                        ⬇️ Download
                    </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-6">{{ $orders->links() }}</div>
@endif
@endsection