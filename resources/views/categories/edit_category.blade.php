@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto">
    <h2 class="text-2xl font-bold mb-4">Edit Kategori</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block mb-1 font-medium">Nama</label>
            <input type="text" name="name" value="{{ $category->name }}" class="w-full border px-3 py-2 rounded" required>
        </div>
        <div>
            <label class="block mb-1 font-medium">Deskripsi</label>
            <textarea name="description" class="w-full border px-3 py-2 rounded" required>{{ $category->description }}</textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Perbarui</button>
    </form>
</div>
@endsection
