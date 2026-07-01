@extends('layouts.admin')
@section('title', 'User Detail')
@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.users.index') }}" class="text-indigo-600 text-sm hover:underline mb-4 inline-block">← Back</a>
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold">{{ $user->name }}</h2>
                <p class="text-gray-400 text-sm">{{ $user->email }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-medium
                {{ $user->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-600' }}">
                {{ ucfirst($user->role) }}
            </span>
        </div>
        <p class="text-sm text-gray-400 mt-2">Joined {{ $user->created_at->format('d M Y') }}</p>
        <a href="{{ route('admin.users.edit', $user) }}"
           class="mt-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">
            Edit User
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold">Order History ({{ $user->orders->count() }})</h3>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Product</th>
                    <th class="px-6 py-3 text-left">Amount</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($user->orders as $order)
                <tr>
                    <td class="px-6 py-3">{{ $order->product->title }}</td>
                    <td class="px-6 py-3 font-semibold">ETB {{ number_format($order->amount, 2) }}</td>
                    <td class="px-6 py-3">
                        @php $c = ['paid'=>'green','pending'=>'yellow','failed'=>'red','refunded'=>'gray'][$order->status] ?? 'gray'; @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs bg-{{ $c }}-100 text-{{ $c }}-700">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-gray-400">{{ $order->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-6 text-center text-gray-400">No orders.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection