@extends('layouts.admin')
@section('title', 'Users')
@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-semibold">Users ({{ $users->total() }})</h2>
    <form method="GET" class="flex gap-2">
        <input name="search" value="{{ request('search') }}" placeholder="Name or email..."
            class="border rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
        <select name="role" class="border rounded-lg px-3 py-1.5 text-sm">
            <option value="">All Roles</option>
            <option value="admin"    {{ request('role') === 'admin'    ? 'selected' : '' }}>Admin</option>
            <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
        </select>
        <button class="bg-indigo-600 text-white px-4 py-1.5 rounded-lg text-sm">Filter</button>
    </form>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">Name</th>
                <th class="px-6 py-3 text-left">Email</th>
                <th class="px-6 py-3 text-left">Role</th>
                <th class="px-6 py-3 text-left">Orders</th>
                <th class="px-6 py-3 text-left">Joined</th>
                <th class="px-6 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 font-medium">{{ $user->name }}</td>
                <td class="px-6 py-3 text-gray-500">{{ $user->email }}</td>
                <td class="px-6 py-3">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                        {{ $user->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td class="px-6 py-3">{{ $user->orders_count }}</td>
                <td class="px-6 py-3 text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
                <td class="px-6 py-3 flex gap-3">
                    <a href="{{ route('admin.users.show', $user) }}" class="text-indigo-600 hover:underline text-xs">View</a>
                    <a href="{{ route('admin.users.edit', $user) }}" class="text-yellow-600 hover:underline text-xs">Edit</a>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                          onsubmit="return confirm('Delete this user?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline text-xs">Delete</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-10 text-center text-gray-400">No users found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">{{ $users->links() }}</div>
</div>
@endsection