@extends('layouts.admin')
@section('title', 'Edit User')
@section('content')
<div class="max-w-lg">
    <a href="{{ route('admin.users.index') }}" class="text-indigo-600 text-sm hover:underline mb-4 inline-block">← Back</a>
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="font-semibold text-lg mb-4">Edit: {{ $user->name }}</h2>
        @if($errors->any())
            <div class="bg-red-50 text-red-700 p-3 rounded mb-4 text-sm">
                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
            @csrf @method('PATCH')
            <div>
                <label class="block text-sm font-medium mb-1">Name</label>
                <input name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input name="email" type="email" value="{{ old('email', $user->email) }}" required
                    class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Role</label>
                <select name="role"
                    class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                    <option value="customer" {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="admin"    {{ old('role', $user->role) === 'admin'    ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">New Password <span class="text-gray-400 font-normal">(leave blank to keep)</span></label>
                <input name="password" type="password"
                    class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Confirm Password</label>
                <input name="password_confirmation" type="password"
                    class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>
            <button class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-indigo-700">
                Save Changes
            </button>
        </form>
    </div>
</div>
@endsection