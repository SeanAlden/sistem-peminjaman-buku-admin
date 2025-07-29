@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto">
    <h2 class="text-2xl font-bold mb-4">Tambah Kategori</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1 font-medium">Nama</label>
            <input type="text" name="name" class="w-full border px-3 py-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1 font-medium">Deskripsi</label>
            <textarea name="description" class="w-full border px-3 py-2 rounded" required></textarea>
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
    </form>
</div>
@endsection
