{{-- @extends('layouts.app')

@section('content')
    <h1 class="mb-4 text-xl font-bold">Edit Profil</h1>

    @if(session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                class="w-full px-4 py-2 border rounded" required>
            @error('name') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                class="w-full px-4 py-2 border rounded" required>
            @error('email') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Gambar Profil</label>
            <input type="file" name="profile_image" class="w-full px-4 py-2 border rounded">
            @error('profile_image') <p class="text-sm text-red-500">{{ $message }}</p> @enderror

            @if($user->profile_image)
                <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}" class="w-20 h-20 mt-2 rounded-full">
            @endif
        </div>

        <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">Simpan</button>
    </form>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen transition-colors duration-300 bg-gray-100 dark:bg-gray-900">
    <div class="w-full max-w-2xl p-8 bg-white shadow-lg rounded-2xl dark:bg-gray-800">
        <h1 class="mb-6 text-2xl font-bold text-center text-gray-800 dark:text-gray-100">Edit Profil</h1>

        @if(session('success'))
            <div class="px-4 py-3 mb-5 text-green-800 bg-green-100 border border-green-300 rounded-lg dark:bg-green-900 dark:text-green-200 dark:border-green-700">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                @error('name') 
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                @error('email') 
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Gambar Profil</label>
                <input type="file" name="profile_image"
                    class="w-full px-4 py-2 border rounded-lg cursor-pointer focus:ring-2 focus:ring-indigo-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                @error('profile_image') 
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p> 
                @enderror

                @if($user->profile_image)
                    <div class="mt-4">
                        <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}" 
                             class="w-24 h-24 border-2 border-gray-300 rounded-full shadow-md dark:border-gray-600">
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-end pt-4">
                <button type="submit"
                    class="px-5 py-2 text-white transition bg-green-600 rounded-lg shadow hover:bg-green-700 focus:ring-2 focus:ring-green-400">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
