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
    <div class="max-w-3xl px-4 py-8 mx-auto">
        <h2 class="mb-6 text-2xl font-bold text-gray-800 dark:text-white">📖 Detail Buku</h2>

        <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-md">
            {{-- <img src="{{ asset('storage/' . $book->image_url) }}" alt="book image"
                class="object-contain object-center w-full h-100"> --}}
            <img src="{{ $book->image_url
        ? Storage::disk('s3')->url($book->image_url)
        : asset('assets/images/avatar.png') }}"
                onerror="this.onerror=null; this.src='{{ asset('assets/images/avatar.png') }}';" alt="book image"
                class="object-contain object-center w-full h-100 dark:bg-gray-500">

            <div class="p-6 space-y-3 dark:bg-gray-500">
                <h5 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $book->title }}</h5>
                <p class="text-gray-700 dark:text-white"><strong>Penulis:</strong> {{ $book->author }}</p>
                <p class="text-gray-700 dark:text-white"><strong>Stok:</strong> {{ $book->stock }}</p>
                <p class="text-gray-700 dark:text-white"><strong>Deskripsi:</strong> {{ $book->description }}</p>
                <p class="text-gray-700 dark:text-white"><strong>Durasi Pinjam:</strong> {{ $book->loan_duration }}</p>
                <p class="text-gray-700 dark:text-white"><strong>Kategori:</strong> {{ $book->category->name }}</p>

                <a href="{{ route('books.index') }}"
                    class="inline-block px-4 py-2 mt-4 font-semibold text-white transition duration-300 bg-gray-600 rounded hover:bg-gray-700">
                    ⬅️ Kembali
                </a>
            </div>
        </div>
    </div>
@endsection