@extends('layouts.app')

@section('content')
<div class="container px-4 py-8 mx-auto sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">📂 Detail Kategori</h1>
        <p class="mt-2 text-gray-600 dark:text-white"><strong>Nama:</strong> {{ $category->name }}</p>
        <p class="text-gray-600 dark:text-white"><strong>Deskripsi:</strong> {{ $category->description }}</p>
    </div>

    <h2 class="mb-4 text-2xl font-semibold text-gray-800 dark:text-white">📚 Buku dalam Kategori Ini</h2>

    @if ($category->books->count())
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($category->books as $book)
                <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-500">
                    @if ($book->image_url)
                        <img src="{{ $book->image_url ? Storage::disk('s3')->url($book->image_url) : asset('assets/images/avatar.png') }}" alt="{{ $book->title }}"
                            class="object-contain w-full h-40 mb-3 rounded">
                    @else
                        <img src="{{ asset('assets/images/avatar.png') }}" alt="{{ $book->title }}"
                            class="object-contain w-full h-40 mb-3 rounded">
                    @endif

                    <h3 class="mb-1 text-lg font-bold text-gray-800 dark:text-white">{{ $book->title }}</h3>
                    <p class="text-sm text-gray-600 dark:text-white"><strong>Penulis:</strong> {{ $book->author }}</p>
                    <p class="text-sm text-gray-600 dark:text-white"><strong>Durasi Pinjam:</strong> {{ $book->loan_duration }} hari</p>
                    <p class="text-sm text-gray-600 dark:text-white"><strong>Stok:</strong> {{ $book->stock }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p class="italic text-gray-500">Kategori ini belum memiliki buku.</p>
    @endif
</div>
@endsection
