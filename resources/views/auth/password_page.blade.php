{{-- @extends('layouts.app')

@section('content')
    <h1 class="mb-4 text-xl font-bold">Ubah Password</h1>

    @if(session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.password.update') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Password Saat Ini</label>
            <input type="password" name="current_password" class="w-full px-4 py-2 border rounded" required>
            @error('current_password') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Password Baru</label>
            <input type="password" name="new_password" class="w-full px-4 py-2 border rounded" required>
            @error('new_password') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation" class="w-full px-4 py-2 border rounded" required>
        </div>

        <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">Ubah Password</button>
    </form>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen transition-colors duration-300 bg-gray-100 dark:bg-gray-900">
    <div class="w-full max-w-lg p-8 bg-white shadow-lg rounded-2xl dark:bg-gray-800">
        <h1 class="mb-6 text-2xl font-bold text-center text-gray-800 dark:text-gray-100">Ubah Password</h1>

        @if(session('success'))
            <div class="px-4 py-3 mb-5 text-green-800 bg-green-100 border border-green-300 rounded-lg dark:bg-green-900 dark:text-green-200 dark:border-green-700">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.password.update') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Password Saat Ini</label>
                <input type="password" name="current_password" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                @error('current_password') 
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Password Baru</label>
                <input type="password" name="new_password" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                @error('new_password') 
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
            </div>

            <div class="flex items-center justify-end pt-4">
                <button type="submit"
                    class="px-5 py-2 text-white transition bg-green-600 rounded-lg shadow hover:bg-green-700 focus:ring-2 focus:ring-green-400">
                    Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
