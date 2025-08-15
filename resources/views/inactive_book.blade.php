@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 mt-6">

        <h2 class="text-3xl font-bold mb-6 text-gray-800 text-center">🚫 Buku Nonaktif</h2>

        <div class="text-right mb-6">
            <a href="{{ route('books.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
                ⬅️ Kembali ke Buku Aktif
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($books as $book)
                <div class="bg-white rounded-xl shadow-md border border-gray-200 hover:shadow-lg transition duration-300 flex flex-col">

                    <img src="{{ asset('storage/' . $book->image_url) }}" alt="book image"
                        class="w-full h-48 object-contain rounded-t-xl"
                        onerror="this.onerror=null;this.src='{{ asset('assets/images/avatar.png') }}';">

                    <div class="p-4 flex flex-col justify-between flex-grow">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-600 mb-1"><span class="font-medium">Penulis:</span> {{ $book->author }}</p>
                            <p class="text-sm text-gray-600 mb-1"><span class="font-medium">Stok:</span> {{ $book->stock }}</p>
                            <p class="text-sm text-gray-600 mb-4"><span class="font-medium">Kategori:</span> {{ $book->category->name }}</p>
                        </div>

                        <form action="{{ route('books.restore', $book->id) }}" method="POST" class="inline-block mt-auto">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white text-sm py-2 px-4 rounded transition duration-300 w-full">
                                ✅ Aktifkan Kembali
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
