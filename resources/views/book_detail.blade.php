{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Buku</h2>
    <div class="card">
        <img src="{{ asset('storage/' . $book->image_url) }}" class="card-img-top" alt="book image">
        <div class="card-body">
            <h5 class="card-title">{{ $book->title }}</h5>
            <p class="card-text"><strong>Penulis:</strong> {{ $book->author }}</p>
            <p class="card-text"><strong>Stok:</strong> {{ $book->stock }}</p>
            <p class="card-text"><strong>Deskripsi:</strong> {{ $book->description }}</p>
            <p class="card-text"><strong>Kategori:</strong> {{ $book->category->name }}</p>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">📖 Detail Buku</h2>

    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
        <img src="{{ asset('storage/' . $book->image_url) }}"
             alt="book image"
             class="w-full h-100 object-contain object-center">

        <div class="p-6 space-y-3">
            <h5 class="text-xl font-semibold text-gray-900">{{ $book->title }}</h5>
            <p class="text-gray-700"><strong>Penulis:</strong> {{ $book->author }}</p>
            <p class="text-gray-700"><strong>Stok:</strong> {{ $book->stock }}</p>
            <p class="text-gray-700"><strong>Deskripsi:</strong> {{ $book->description }}</p>
            <p class="text-gray-700"><strong>Durasi Pinjam:</strong> {{ $book->loan_duration }}</p>
            <p class="text-gray-700"><strong>Kategori:</strong> {{ $book->category->name }}</p>

            <a href="{{ route('books.index') }}"
               class="inline-block mt-4 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
                ⬅️ Kembali
            </a>
        </div>
    </div>
</div>
@endsection
