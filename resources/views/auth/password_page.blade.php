@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-bold mb-4">Ubah Password</h1>

    @if(session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.password.update') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Password Saat Ini</label>
            <input type="password" name="current_password" class="w-full border px-4 py-2 rounded" required>
            @error('current_password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Password Baru</label>
            <input type="password" name="new_password" class="w-full border px-4 py-2 rounded" required>
            @error('new_password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation" class="w-full border px-4 py-2 rounded" required>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Ubah Password</button>
    </form>
@endsection
