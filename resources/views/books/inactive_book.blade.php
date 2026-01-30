@extends('layouts.app')

@section('content')
    <div class="container px-4 mx-auto mt-6">

        <h2 class="mb-6 text-3xl font-bold text-center text-gray-800 dark:text-white">🚫 Buku Nonaktif</h2>

        <div class="mb-6 text-right">
            <a href="{{ route('books.index') }}"
                class="px-4 py-2 font-semibold text-white transition duration-300 bg-gray-600 rounded hover:bg-gray-700">
                ⬅️ Kembali ke Buku Aktif
            </a>
        </div>

        @if (session('success'))
            <div id="success-alert"
                class="px-4 py-3 mb-6 text-green-700 bg-green-100 border border-green-400 rounded transition-opacity duration-500"
                role="alert">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => {
                    const alert = document.getElementById('success-alert');
                    if (alert) {
                        alert.classList.add('opacity-0');
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 2000);
            </script>
        @endif
        @if (session('error'))
            <div id="error-alert"
                class="px-4 py-3 mb-6 text-red-700 bg-red-100 border border-red-400 rounded transition-opacity duration-500"
                role="alert">
                {{ session('error') }}
            </div>
            <script>
                setTimeout(() => {
                    const alert = document.getElementById('error-alert');
                    if (alert) {
                        alert.classList.add('opacity-0');
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 2000);
            </script>
        @endif

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($books as $book)
                <div
                    class="flex flex-col transition duration-300 bg-white border shadow-md border-rgray-200 dark:border-white dark:bg-gray-500 rounded-xl hover:shadow-lg">

                    <img src="{{ $book->image_url ? Storage::disk('s3')->url($book->image_url) : asset('assets/images/avatar.png') }}"
                        alt="book image" class="object-contain w-full h-48 rounded-t-xl"
                        onerror="this.onerror=null;this.src='{{ asset('assets/images/avatar.png') }}';">

                    <div class="flex flex-col justify-between flex-grow p-4">
                        <div>
                            <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $book->title }}</h3>
                            <p class="mb-1 text-sm text-gray-600 dark:text-white"><span class="font-medium">Penulis:</span>
                                {{ $book->author }}</p>
                            <p class="mb-1 text-sm text-gray-600 dark:text-white"><span class="font-medium">Stok:</span>
                                {{ $book->stock }}</p>
                            <p class="mb-4 text-sm text-gray-600 dark:text-white"><span class="font-medium">Kategori:</span>
                                {{ $book->category->name }}</p>
                        </div>

                        <form action="{{ route('books.restore', $book->id) }}" method="POST" class="inline-block mt-auto">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="w-full px-4 py-2 text-sm text-white transition duration-300 bg-green-600 rounded hover:bg-green-700">
                                ✅ Aktifkan Kembali
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
