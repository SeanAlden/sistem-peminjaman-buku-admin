{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Buku</h2>
    <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Tambah Buku</a>
    @foreach ($books as $book)
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-3">
                <img src="{{ asset('storage/' . $book->image_url) }}" class="img-fluid" alt="book image">
            </div>
            <div class="col-md-9">
                <div class="card-body">
                    <h5 class="card-title">{{ $book->title }}</h5>
                    <p class="card-text">Penulis: {{ $book->author }}</p>
                    <p class="card-text">Kategori: {{ $book->category->name }}</p>
                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-info">Detail</a>
                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Hapus buku ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection --}}


{{-- @extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6">

    <h2 class="text-2xl font-bold mb-6 text-gray-800">📚 Daftar Buku</h2>

    <a href="{{ route('books.create') }}"
        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded mb-6 transition duration-300">
        ➕ Tambah Buku
    </a>

    @foreach ($books as $book)
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6 border border-gray-200">
        <div class="flex flex-col md:flex-row">
            <div class="md:w-1/3">
                <img src="{{ asset('storage/' . $book->image_url) }}" alt="book image" class="w-40 h-40 object-fit">
            </div>
            <div class="md:w-2/3 p-4">
                <h5 class="text-xl font-semibold text-gray-900 mb-2">{{ $book->title }}</h5>
                <p class="text-gray-700 mb-1"><span class="font-medium">Penulis:</span> {{ $book->author }}</p>
                <p class="text-gray-700 mb-4"><span class="font-medium">Kategori:</span> {{ $book->category->name }}
                </p>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('books.show', $book->id) }}"
                        class="bg-cyan-600 hover:bg-cyan-700 text-white text-sm py-2 px-4 rounded transition duration-300">
                        🔍 Detail
                    </a>

                    <a href="{{ route('books.edit', $book->id) }}"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm py-2 px-4 rounded transition duration-300">
                        ✏️ Edit
                    </a>

                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline-block"
                        onsubmit="return confirm('Hapus buku ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white text-sm py-2 px-4 rounded transition duration-300">
                            🗑️ Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 mt-6">

        <h2 class="text-3xl font-bold mb-6 text-gray-800 text-center">📚 Daftar Buku</h2>

        <div class="text-right mb-6">
            <a href="{{ route('books.create') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
                ➕ Tambah Buku
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($books as $book)
                <div
                    class="bg-white rounded-xl shadow-md border border-gray-200 hover:shadow-lg transition duration-300 flex flex-col">

                    <img src="{{ asset('storage/' . $book->image_url) }}" alt="book image"
                        class="w-full h-48 object-contain rounded-t-xl"
                        onerror="this.onerror=null;this.src='{{ asset('assets/images/avatar.png') }}';">


                    <div class="p-4 flex flex-col justify-between flex-grow">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-600 mb-1"><span class="font-medium">Penulis:</span> {{ $book->author }}
                            </p>
                            <p class="text-sm text-gray-600 mb-1"><span class="font-medium">Stok:</span> {{ $book->stock }}
                            </p>
                            <p class="text-sm text-gray-600 mb-4"><span class="font-medium">Kategori:</span>
                                {{ $book->category->name }}</p>
                        </div>

                        <div class="mt-auto flex flex-wrap gap-2">
                            <a href="{{ route('books.show', $book->id) }}"
                                class="bg-cyan-600 hover:bg-cyan-700 text-white text-sm py-2 px-4 rounded transition duration-300">
                                🔍 Detail
                            </a>

                            <a href="{{ route('books.edit', $book->id) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm py-2 px-4 rounded transition duration-300">
                                ✏️ Edit
                            </a>

                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Hapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white text-sm py-2 px-4 rounded transition duration-300">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection