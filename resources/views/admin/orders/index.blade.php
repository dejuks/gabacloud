@extends('layouts.admin')
@section('title', 'Orders')
@section('content')

<div class="bg-white rounded-2xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b flex flex-wrap gap-3 items-center justify-between">
        <h2 class="font-semibold text-gray-700">All Orders</h2>
        <form method="GET" class="flex gap-2">
            <input name="search" value="{{ request('search') }}" placeholder="Search tx_ref or user..."
                class="border rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
            <select name="status" class="border rounded-lg px-3 py-1.5 text-sm">
                <option value="">All Status</option>
                @foreach(['pending','paid','failed','refunded'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button class="bg-indigo-600 text-white px-4 py-1.5 rounded-lg text-sm">Filter</button>
        </form>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">#</th>
                <th class="px-6 py-3 text-left">Customer</th>
                <th class="px-6 py-3 text-left">Product</th>
                <th class="px-6 py-3 text-left">Amount</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Date</th>
                <th class="px-6 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($orders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 text-gray-400 text-xs font-mono">{{ $order->tx_ref }}</td>
                <td class="px-6 py-3">
                    <div class="font-medium">{{ $order->user->name }}</div>
                    <div class="text-xs text-gray-400">{{ $order->user->email }}</div>
                </td>
                <td class="px-6 py-3">{{ Str::limit($order->product->title, 25) }}</td>
                <td class="px-6 py-3 font-semibold">ETB {{ number_format($order->amount, 2) }}</td>
                <td class="px-6 py-3">
                    @php $c = ['paid'=>'green','pending'=>'yellow','failed'=>'red','refunded'=>'gray'][$order->status] ?? 'gray'; @endphp
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $c }}-100 text-{{ $c }}-700">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td class="px-6 py-3 text-gray-400">{{ $order->created_at->format('d M Y') }}</td>
                <td class="px-6 py-3">
                    <a href="{{ route('admin.orders.show', $order) }}"
                       class="text-indigo-600 hover:underline text-xs">View</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-6 py-10 text-center text-gray-400">No orders found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">{{ $orders->links() }}</div>
</div>
@endsection