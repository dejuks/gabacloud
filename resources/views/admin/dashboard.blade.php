@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    @php
        $cards = [
            ['label' => 'Total Revenue',  'value' => 'ETB ' . number_format($stats['total_revenue'], 2), 'color' => 'indigo', 'icon' => '💰'],
            ['label' => 'Total Orders',   'value' => $stats['total_orders'],   'color' => 'green',  'icon' => '🛒'],
            ['label' => 'Total Products', 'value' => $stats['total_products'], 'color' => 'yellow', 'icon' => '📦'],
            ['label' => 'Total Users',    'value' => $stats['total_users'],    'color' => 'purple', 'icon' => '👥'],
        ];
    @endphp
    @foreach($cards as $card)
    <div class="bg-white rounded-2xl shadow p-6 flex items-center gap-4">
        <div class="text-3xl">{{ $card['icon'] }}</div>
        <div>
            <p class="text-sm text-gray-500">{{ $card['label'] }}</p>
            <p class="text-2xl font-bold text-gray-800">{{ $card['value'] }}</p>
        </div>
    </div>
    @endforeach
</div>

<!-- Recent Orders -->
<div class="bg-white rounded-2xl shadow overflow-hidden">
    <div class="px-6 py-4 border-b flex items-center justify-between">
        <h2 class="font-semibold text-gray-700">Recent Orders</h2>
        <a href="#" class="text-indigo-600 text-sm hover:underline">View all</a>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">TX Ref</th>
                <th class="px-6 py-3 text-left">Customer</th>
                <th class="px-6 py-3 text-left">Product</th>
                <th class="px-6 py-3 text-left">Amount</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Date</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($recent_orders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 font-mono text-xs text-gray-500">{{ $order->tx_ref }}</td>
                <td class="px-6 py-3">{{ $order->user->name }}</td>
                <td class="px-6 py-3">{{ Str::limit($order->product->title, 30) }}</td>
                <td class="px-6 py-3 font-semibold">ETB {{ number_format($order->amount, 2) }}</td>
                <td class="px-6 py-3">
                    @php
                        $colors = ['paid'=>'green','pending'=>'yellow','failed'=>'red','refunded'=>'gray'];
                        $c = $colors[$order->status] ?? 'gray';
                    @endphp
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $c }}-100 text-{{ $c }}-700">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td class="px-6 py-3 text-gray-400">{{ $order->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">No orders yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection