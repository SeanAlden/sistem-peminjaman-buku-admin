@extends('layouts.app')

@section('content')
    <h1 class="text-xl font-bold mb-4">Edit Profil</h1>

    @if(session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                class="w-full border px-4 py-2 rounded" required>
            @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                class="w-full border px-4 py-2 rounded" required>
            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Gambar Profil</label>
            <input type="file" name="profile_image" class="w-full border px-4 py-2 rounded">
            @error('profile_image') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            @if($user->profile_image)
                <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}" class="mt-2 w-20 h-20 rounded-full">
            @endif
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
    </form>
@endsection
