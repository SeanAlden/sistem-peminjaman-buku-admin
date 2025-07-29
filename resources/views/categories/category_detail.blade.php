@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">📂 Detail Kategori</h1>
        <p class="text-gray-600 mt-2"><strong>Nama:</strong> {{ $category->name }}</p>
        <p class="text-gray-600"><strong>Deskripsi:</strong> {{ $category->description }}</p>
    </div>

    <h2 class="text-2xl font-semibold text-gray-800 mb-4">📚 Buku dalam Kategori Ini</h2>

    @if ($category->books->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($category->books as $book)
                <div class="bg-white rounded-lg shadow p-4">
                    @if ($book->image_url)
                        <img src="{{ asset('storage/' . $book->image_url) }}" alt="{{ $book->title }}"
                            class="h-40 w-full object-contain rounded mb-3">
                    @else
                        <div class="h-40 w-full bg-gray-200 flex items-center justify-center rounded mb-3">
                            <span class="text-gray-500 text-sm">Tidak ada gambar</span>
                        </div>
                    @endif

                    <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $book->title }}</h3>
                    <p class="text-sm text-gray-600"><strong>Penulis:</strong> {{ $book->author }}</p>
                    <p class="text-sm text-gray-600"><strong>Durasi Pinjam:</strong> {{ $book->loan_duration }} hari</p>
                    <p class="text-sm text-gray-600"><strong>Stok:</strong> {{ $book->stock }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500 italic">Kategori ini belum memiliki buku.</p>
    @endif
</div>
@endsection
