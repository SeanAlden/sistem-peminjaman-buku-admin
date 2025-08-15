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

{{-- @extends('layouts.app')

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
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 mt-6">

        <h2 class="text-3xl font-bold mb-6 text-gray-800 text-center">📚 Daftar Buku</h2>

        <div class="text-right mb-6 flex justify-end items-center gap-4">
            <a href="{{ route('books.inactive') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded transition duration-300">
                🚫 Lihat Buku Nonaktif
            </a>

            <a href="{{ route('books.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
                ➕ Tambah Buku
            </a>
        </div>

        <!-- Fitur Search dan Items per Page -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <form action="{{ route('books.index') }}" method="GET" class="flex items-center">
                    <label for="per_page" class="mr-2 text-sm text-gray-600">Show:</label>
                    <select name="per_page" id="per_page"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        onchange="this.form.submit()">
                        <option value="6" {{ $perPage == 6 ? 'selected' : '' }}>6</option>
                        <option value="12" {{ $perPage == 12 ? 'selected' : '' }}>12</option>
                        <option value="27" {{ $perPage == 27 ? 'selected' : '' }}>27</option>
                        <option value="51" {{ $perPage == 51 ? 'selected' : '' }}>51</option>
                        <option value="101" {{ $perPage == 101 ? 'selected' : '' }}>101</option>
                    </select>
                    <input type="hidden" name="search" value="{{ $search }}">
                </form>
            </div>
            <div class="flex items-center">
                <form action="{{ route('books.index') }}" method="GET" class="flex items-center">
                    <label for="search" class="mr-2 text-sm text-gray-600">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>
        <!-- End Fitur -->

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
                            <p class="text-sm text-gray-600 mb-1"><span class="font-medium">Stok:</span> {{ $book->stock }}</p>
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
                                onsubmit="return confirm('Nonaktifkan buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white text-sm py-2 px-4 rounded transition duration-300">
                                    🚫 Nonaktifkan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Fitur Pagination -->
        <div class="flex items-center justify-between mt-4">
            <div>
                @if ($books->total() > 0)
                    <p class="text-sm text-gray-700">
                        Showing {{ $books->firstItem() }} to {{ $books->lastItem() }} of {{ $books->total() }}
                        entries
                    </p>
                @endif
            </div>
            <div>
                @if ($books->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                        {{-- Previous Page Link --}}
                        @if ($books->onFirstPage())
                            <span class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                        @else
                            <a href="{{ $books->previousPageUrl() }}" rel="prev"
                                class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                        @endif

                        @php
                            $currentPage = $books->currentPage();
                            $lastPage = $books->lastPage();
                            $links = [];

                            // Logic untuk menampilkan link pagination
                            if ($lastPage <= 7) {
                                for ($i = 1; $i <= $lastPage; $i++) {
                                    $links[] = $i;
                                }
                            } else {
                                $links[] = 1;
                                if ($currentPage > 4) {
                                    $links[] = '...';
                                }

                                $start = max(2, $currentPage - 1);
                                $end = min($lastPage - 1, $currentPage + 1);

                                if ($currentPage <= 4) {
                                    $start = 2;
                                    $end = 5;
                                }

                                if ($currentPage >= $lastPage - 3) {
                                    $start = $lastPage - 4;
                                    $end = $lastPage - 1;
                                }

                                for ($i = $start; $i <= $end; $i++) {
                                    $links[] = $i;
                                }

                                if ($currentPage < $lastPage - 3) {
                                    $links[] = '...';
                                }
                                $links[] = $lastPage;
                            }
                        @endphp

                        @foreach ($links as $link)
                            @if ($link === '...')
                                <span class="px-3 py-1 mr-1 text-gray-500 bg-white border rounded">{{ $link }}</span>
                            @elseif ($link == $currentPage)
                                <span class="px-3 py-1 mr-1 text-white bg-blue-500 border border-blue-500 rounded">{{ $link }}</span>
                            @else
                                <a href="{{ $books->url($link) }}"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($books->hasMorePages())
                            <a href="{{ $books->nextPageUrl() }}" rel="next"
                                class="px-3 py-1 ml-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Next</a>
                        @else
                            <span class="px-3 py-1 ml-1 text-gray-400 bg-white border rounded cursor-not-allowed">Next</span>
                        @endif
                    </nav>
                @endif
            </div>
        </div>
        <!-- End Fitur Pagination -->
    </div>
@endsection