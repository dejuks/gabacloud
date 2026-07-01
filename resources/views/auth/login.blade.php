@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="max-w-md mx-auto bg-white rounded-2xl shadow p-8 mt-10">
    <h1 class="text-2xl font-bold mb-6 text-center">Sign In</h1>

    @if($errors->any())
        <div class="bg-red-50 text-red-700 p-3 rounded mb-4 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
        </div>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="remember"> Remember me
        </label>
        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 font-semibold">
            Login
        </button>
    </form>
    <p class="text-center text-sm mt-4 text-gray-500">
        No account? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Register</a>
    </p>
</div>
@endsection