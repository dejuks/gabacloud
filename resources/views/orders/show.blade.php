@extends('layouts.app')
@section('title', 'Order Detail')
@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('orders.my') }}" class="text-indigo-600 text-sm hover:underline mb-4 inline-block">← My Orders</a>

    <div class="bg-white rounded-2xl shadow p-6 space-y-5">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-xl font-bold">{{ $order->product->title }}</h1>
                <p class="text-sm text-gray-400 font-mono mt-1">{{ $order->tx_ref }}</p>
            </div>
            @php $c = ['paid'=>'green','pending'=>'yellow','failed'=>'red','refunded'=>'gray'][$order->status] ?? 'gray'; @endphp
            <span class="px-3 py-1 rounded-full text-sm font-semibold bg-{{ $c }}-100 text-{{ $c }}-700">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm border-t pt-5">
            <div>
                <p class="text-gray-400 mb-0.5">Amount Paid</p>
                <p class="font-bold text-lg text-indigo-600">ETB {{ number_format($order->amount, 2) }}</p>
            </div>
            <div>
                <p class="text-gray-400 mb-0.5">Purchase Date</p>
                <p class="font-medium">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-400 mb-0.5">Payment Method</p>
                <p class="font-medium">{{ $order->payment->payment_method ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-400 mb-0.5">Chapa Ref</p>
                <p class="font-mono text-sm">{{ $order->payment->chapa_reference ?? '—' }}</p>
            </div>
        </div>

        @if($order->status === 'paid')
        <div class="border-t pt-5">
            <a href="{{ route('orders.download', $order) }}"
               class="inline-block bg-green-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-green-700">
                ⬇️ Download {{ $order->product->title }}
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
