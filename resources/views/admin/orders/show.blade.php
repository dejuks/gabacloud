@extends('layouts.admin')
@section('title', 'Order Detail')
@section('content')

<div class="max-w-3xl">
    <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 text-sm hover:underline mb-4 inline-block">← Back to Orders</a>

    <div class="bg-white rounded-2xl shadow p-6 space-y-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-xl font-bold">Order #{{ $order->id }}</h2>
                <p class="text-sm text-gray-400 font-mono">{{ $order->tx_ref }}</p>
            </div>
            @php $c = ['paid'=>'green','pending'=>'yellow','failed'=>'red','refunded'=>'gray'][$order->status] ?? 'gray'; @endphp
            <span class="px-3 py-1 rounded-full text-sm font-semibold bg-{{ $c }}-100 text-{{ $c }}-700">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-6 text-sm">
            <div>
                <p class="text-gray-500 mb-1">Customer</p>
                <p class="font-medium">{{ $order->user->name }}</p>
                <p class="text-gray-400">{{ $order->user->email }}</p>
            </div>
            <div>
                <p class="text-gray-500 mb-1">Product</p>
                <p class="font-medium">{{ $order->product->title }}</p>
                <p class="text-gray-400">ETB {{ number_format($order->amount, 2) }}</p>
            </div>
            <div>
                <p class="text-gray-500 mb-1">Payment</p>
                <p class="font-medium">{{ $order->payment->payment_method ?? 'N/A' }}</p>
                <p class="text-gray-400">Ref: {{ $order->payment->chapa_reference ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-500 mb-1">Date</p>
                <p class="font-medium">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <!-- Update Status -->
        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST"
              class="flex items-center gap-3 pt-4 border-t">
            @csrf @method('PATCH')
            <select name="status" class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                @foreach(['pending','paid','failed','refunded'] as $s)
                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-indigo-700">
                Update Status
            </button>
            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline"
                  onsubmit="return confirm('Delete this order?')">
                @csrf @method('DELETE')
                <button class="bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm hover:bg-red-200">Delete</button>
            </form>
        </form>
    </div>
</div>
@endsection