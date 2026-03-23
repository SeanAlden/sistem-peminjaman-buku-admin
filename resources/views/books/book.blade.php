{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Buku</h2>
    <a href="{{ route('books.create') }}" class="mb-3 btn btn-primary">Tambah Buku</a>
    @foreach ($books as $book)
    <div class="mb-3 card">
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

    <h2 class="mb-6 text-2xl font-bold text-gray-800">📚 Daftar Buku</h2>

    <a href="{{ route('books.create') }}"
        class="inline-block px-4 py-2 mb-6 font-semibold text-white transition duration-300 bg-blue-600 rounded hover:bg-blue-700">
        ➕ Tambah Buku
    </a>

    @foreach ($books as $book)
    <div class="mb-6 overflow-hidden bg-white border border-gray-200 rounded-lg shadow-md">
        <div class="flex flex-col md:flex-row">
            <div class="md:w-1/3">
                <img src="{{ asset('storage/' . $book->image_url) }}" alt="book image" class="w-40 h-40 object-fit">
            </div>
            <div class="p-4 md:w-2/3">
                <h5 class="mb-2 text-xl font-semibold text-gray-900">{{ $book->title }}</h5>
                <p class="mb-1 text-gray-700"><span class="font-medium">Penulis:</span> {{ $book->author }}</p>
                <p class="mb-4 text-gray-700"><span class="font-medium">Kategori:</span> {{ $book->category->name }}
                </p>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('books.show', $book->id) }}"
                        class="px-4 py-2 text-sm text-white transition duration-300 rounded bg-cyan-600 hover:bg-cyan-700">
                        🔍 Detail
                    </a>

                    <a href="{{ route('books.edit', $book->id) }}"
                        class="px-4 py-2 text-sm text-white transition duration-300 bg-yellow-500 rounded hover:bg-yellow-600">
                        ✏️ Edit
                    </a>

                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline-block"
                        onsubmit="return confirm('Hapus buku ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 text-sm text-white transition duration-300 bg-red-600 rounded hover:bg-red-700">
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
<div class="container px-4 mx-auto mt-6">

    <h2 class="mb-6 text-3xl font-bold text-center text-gray-800">📚 Daftar Buku</h2>

    <div class="mb-6 text-right">
        <a href="{{ route('books.create') }}"
            class="inline-block px-4 py-2 font-semibold text-white transition duration-300 bg-blue-600 rounded hover:bg-blue-700">
            ➕ Tambah Buku
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($books as $book)
        <div
            class="flex flex-col transition duration-300 bg-white border border-gray-200 shadow-md rounded-xl hover:shadow-lg">

            <img src="{{ asset('storage/' . $book->image_url) }}" alt="book image"
                class="object-contain w-full h-48 rounded-t-xl"
                onerror="this.onerror=null;this.src='{{ asset('assets/images/avatar.png') }}';">


            <div class="flex flex-col justify-between flex-grow p-4">
                <div>
                    <h3 class="mb-1 text-lg font-semibold text-gray-900">{{ $book->title }}</h3>
                    <p class="mb-1 text-sm text-gray-600"><span class="font-medium">Penulis:</span> {{ $book->author }}
                    </p>
                    <p class="mb-1 text-sm text-gray-600"><span class="font-medium">Stok:</span> {{ $book->stock }}
                    </p>
                    <p class="mb-4 text-sm text-gray-600"><span class="font-medium">Kategori:</span>
                        {{ $book->category->name }}</p>
                </div>

                <div class="flex flex-wrap gap-2 mt-auto">
                    <a href="{{ route('books.show', $book->id) }}"
                        class="px-4 py-2 text-sm text-white transition duration-300 rounded bg-cyan-600 hover:bg-cyan-700">
                        🔍 Detail
                    </a>

                    <a href="{{ route('books.edit', $book->id) }}"
                        class="px-4 py-2 text-sm text-white transition duration-300 bg-yellow-500 rounded hover:bg-yellow-600">
                        ✏️ Edit
                    </a>

                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline-block"
                        onsubmit="return confirm('Hapus buku ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 text-sm text-white transition duration-300 bg-red-600 rounded hover:bg-red-700">
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

{{-- @extends('layouts.app')

@section('content')
<div class="container px-4 mx-auto mt-6">

    <h2 class="mb-6 text-3xl font-bold text-center text-gray-800 dark:text-white">📚 Daftar Buku</h2>

    <div class="flex items-center justify-end gap-4 mb-6 text-right">
        <a href="{{ route('books.inactive') }}"
            class="px-4 py-2 font-semibold text-white transition duration-300 bg-gray-500 rounded hover:bg-gray-600">
            🚫 Lihat Buku Nonaktif
        </a>

        <a href="{{ route('books.create') }}"
            class="px-4 py-2 font-semibold text-white transition duration-300 bg-blue-600 rounded hover:bg-blue-700">
            ➕ Tambah Buku
        </a>
    </div>

    <!-- Fitur Search dan Items per Page -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
            <form action="{{ route('books.index') }}" method="GET" class="flex items-center">
                <label for="per_page" class="mr-2 text-sm text-gray-600 dark:text-white">Show:</label>
                <select name="per_page" id="per_page"
                    class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    onchange="this.form.submit()">
                    <option value="6" {{ $perPage==6 ? 'selected' : '' }}>6</option>
                    <option value="12" {{ $perPage==12 ? 'selected' : '' }}>12</option>
                    <option value="27" {{ $perPage==27 ? 'selected' : '' }}>27</option>
                    <option value="51" {{ $perPage==51 ? 'selected' : '' }}>51</option>
                    <option value="101" {{ $perPage==101 ? 'selected' : '' }}>101</option>
                </select>
                <input type="hidden" name="search" value="{{ $search }}">
            </form>
        </div>
        <div class="flex items-center">
            <form action="{{ route('books.index') }}" method="GET" class="flex items-center">
                <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                <input type="text" name="search" id="search"
                    class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ $search }}" placeholder="Search...">
                <input type="hidden" name="per_page" value="{{ $perPage }}">
            </form>
        </div>
    </div>
    <!-- End Fitur -->

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($books as $book)
        <div
            class="flex flex-col transition duration-300 bg-white border border-gray-200 shadow-md dark:bg-gray-500 rounded-xl dark:border-gray-700 hover:shadow-lg">

            <img src="{{ asset('storage/' . $book->image_url) }}" alt="book image"
                class="object-contain w-full h-48 rounded-t-xl"
                onerror="this.onerror=null;this.src='{{ asset('assets/images/avatar.png') }}';">

            <div class="flex flex-col justify-between flex-grow p-4">
                <div>
                    <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $book->title }}</h3>
                    <p class="mb-1 text-sm text-gray-600 dark:text-white"><span class="font-medium">Penulis:</span> {{
                        $book->author }}
                    </p>
                    <p class="mb-1 text-sm text-gray-600 dark:text-white"><span class="font-medium">Stok:</span> {{
                        $book->stock }}</p>
                    <p class="mb-4 text-sm text-gray-600 dark:text-white"><span class="font-medium">Kategori:</span>
                        {{ $book->category->name }}</p>
                </div>

                <div class="flex flex-wrap gap-2 mt-auto">
                    <a href="{{ route('books.show', $book->id) }}"
                        class="px-4 py-2 text-sm text-white transition duration-300 rounded bg-cyan-600 hover:bg-cyan-700">
                        🔍 Detail
                    </a>

                    <a href="{{ route('books.edit', $book->id) }}"
                        class="px-4 py-2 text-sm text-white transition duration-300 bg-yellow-500 rounded hover:bg-yellow-600">
                        ✏️ Edit
                    </a>

                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline-block"
                        onsubmit="return confirm('Nonaktifkan buku ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 text-sm text-white transition duration-300 bg-red-600 rounded hover:bg-red-700">
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
            <p class="text-sm text-gray-700 dark:text-white">
                Showing {{ $books->firstItem() }} to {{ $books->lastItem() }} of {{ $books->total() }}
                entries
            </p>
            @endif
        </div>
        <div>
            @if ($books->hasPages())
            <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
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
                if ($lastPage <= 7) { for ($i=1; $i <=$lastPage; $i++) { $links[]=$i; } } else { $links[]=1; if
                    ($currentPage> 4) {
                    $links[] = '...';
                    }

                    $start = max(2, $currentPage - 1);
                    $end = min($lastPage - 1, $currentPage + 1);

                    if ($currentPage <= 4) { $start=2; $end=5; } if ($currentPage>= $lastPage - 3) {
                        $start = $lastPage - 4;
                        $end = $lastPage - 1;
                        }

                        for ($i = $start; $i <= $end; $i++) { $links[]=$i; } if ($currentPage < $lastPage - 3) {
                            $links[]='...' ; } $links[]=$lastPage; } @endphp @foreach ($links as $link) @if
                            ($link==='...' ) <span class="px-3 py-1 mr-1 text-gray-500 bg-white border rounded">{{ $link
                            }}</span>
                            @elseif ($link == $currentPage)
                            <span class="px-3 py-1 mr-1 text-white bg-blue-500 border border-blue-500 rounded">{{ $link
                                }}</span>
                            @else
                            <a href="{{ $books->url($link) }}"
                                class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link
                                }}</a>
                            @endif
                            @endforeach

                            @if ($books->hasMorePages())
                            <a href="{{ $books->nextPageUrl() }}" rel="next"
                                class="px-3 py-1 ml-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Next</a>
                            @else
                            <span
                                class="px-3 py-1 ml-1 text-gray-400 bg-white border rounded cursor-not-allowed">Next</span>
                            @endif
            </nav>
            @endif
        </div>
    </div>
    <!-- End Fitur Pagination -->
</div>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
    <div class="container px-4 mx-auto mt-6">

        <h2 class="mb-6 text-3xl font-bold text-center text-gray-800 dark:text-white">📚 Daftar Buku</h2>

        <div class="flex items-center justify-end gap-4 mb-6 text-right">
            <a href="{{ route('books.inactive') }}"
                class="px-4 py-2 font-semibold text-white transition duration-300 bg-gray-500 rounded hover:bg-gray-600">
                🚫 Lihat Buku Nonaktif
            </a>

            <a href="{{ route('books.create') }}"
                class="px-4 py-2 font-semibold text-white transition duration-300 bg-blue-600 rounded hover:bg-blue-700">
                ➕ Tambah Buku
            </a>
        </div>

        @if (session('success'))
            <div id="success-alert" class="px-4 py-3 mb-6 text-green-700 bg-green-100 border border-green-400 rounded transition-opacity duration-500"
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
            <div id="error-alert" class="px-4 py-3 mb-6 text-red-700 bg-red-100 border border-red-400 rounded transition-opacity duration-500"
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

        <!-- Fitur Search, Items per Page, dan View Mode -->
        <div class="flex flex-col gap-3 mb-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <form action="{{ route('books.index') }}" method="GET" class="flex items-center">
                    <label for="per_page" class="mr-2 text-sm text-gray-600 dark:text-white">Show:</label>
                    <select name="per_page" id="per_page"
                        class="block px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm"
                        onchange="this.form.submit()">
                        <option value="6" {{ $perPage == 6 ? 'selected' : '' }}>6</option>
                        <option value="12" {{ $perPage == 12 ? 'selected' : '' }}>12</option>
                        <option value="27" {{ $perPage == 27 ? 'selected' : '' }}>27</option>
                        <option value="51" {{ $perPage == 51 ? 'selected' : '' }}>51</option>
                        <option value="101" {{ $perPage == 101 ? 'selected' : '' }}>101</option>
                    </select>
                    <input type="hidden" name="search" value="{{ $search }}">
                    <input type="hidden" name="view" value="{{ $view }}">
                </form>

                <form action="{{ route('books.index') }}" method="GET" class="flex items-center">
                    <label for="view" class="mr-2 text-sm text-gray-600 dark:text-white">View:</label>
                    <select name="view" id="view"
                        class="block px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm"
                        onchange="this.form.submit()">
                        <option value="card" {{ $view == 'card' ? 'selected' : '' }}>Card</option>
                        <option value="list" {{ $view == 'list' ? 'selected' : '' }}>List</option>
                    </select>
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                    <input type="hidden" name="search" value="{{ $search }}">
                </form>
            </div>

            <div class="flex items-center">
                <form action="{{ route('books.index') }}" method="GET" class="flex items-center">
                    <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                    <input type="hidden" name="view" value="{{ $view }}">
                </form>
            </div>
        </div>
        <!-- End Fitur -->

        @if ($view === 'card')
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($books as $book)
                    <div
                        class="flex flex-col transition duration-300 bg-white border border-gray-200 shadow-md dark:bg-gray-500 rounded-xl dark:border-gray-700 hover:shadow-lg">

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

                            <div class="flex flex-wrap gap-2 mt-auto">
                                <a href="{{ route('books.show', $book->id) }}"
                                    class="px-4 py-2 text-sm text-white rounded bg-cyan-600 hover:bg-cyan-700">🔍 Detail</a>
                                <a href="{{ route('books.edit', $book->id) }}"
                                    class="px-4 py-2 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">✏️ Edit</a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Nonaktifkan buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 text-sm text-white bg-red-600 rounded hover:bg-red-700">🚫
                                        Nonaktifkan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <div class="overflow-x-auto bg-white rounded shadow dark:bg-gray-700">
                <table class="min-w-full border border-gray-200 dark:border-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-600">
                        <tr>
                            <th class="px-4 py-2 border dark:text-white">Cover</th>
                            <th class="px-4 py-2 border dark:text-white">Judul</th>
                            <th class="px-4 py-2 border dark:text-white">Penulis</th>
                            <th class="px-4 py-2 border dark:text-white">Stok</th>
                            <th class="px-4 py-2 border dark:text-white">Kategori</th>
                            <th class="px-4 py-2 border dark:text-white">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-4 py-2 text-center border dark:border-white">
                                    <img src="{{ Storage::disk('s3')->url($book->image_url) }}" alt="book image"
                                        class="object-contain w-16 h-20 mx-auto"
                                        onerror="this.onerror=null;this.src='{{ asset('assets/images/avatar.png') }}';">
                                </td>
                                <td class="px-4 py-2 border dark:text-white">{{ $book->title }}</td>
                                <td class="px-4 py-2 border dark:text-white">{{ $book->author }}</td>
                                <td class="px-4 py-2 text-center border dark:text-white">{{ $book->stock }}</td>
                                <td class="px-4 py-2 border dark:text-white">{{ $book->category->name }}</td>
                                <td class="px-4 py-2 text-center border dark:border-white">
                                    <a href="{{ route('books.show', $book->id) }}"
                                        class="px-3 py-1 text-sm text-white rounded bg-cyan-600 hover:bg-cyan-700">🔍</a>
                                    <a href="{{ route('books.edit', $book->id) }}"
                                        class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">✏️</a>
                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline-block"
                                        onsubmit="return confirm('Nonaktifkan buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700">🚫</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Fitur Pagination -->
        <div class="flex items-center justify-between mt-4">
            <div>
                @if ($books->total() > 0)
                    <p class="text-sm text-gray-700 dark:text-white">
                        Showing {{ $books->firstItem() }} to {{ $books->lastItem() }} of {{ $books->total() }}
                        entries
                    </p>
                @endif
            </div>
            <div>
                @if ($books->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
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
                                <span class="px-3 py-1 mr-1 text-gray-500 bg-white border rounded">
                                    {{ $link }}
                                </span>
                            @elseif ($link == $currentPage)
                                <span class="px-3 py-1 mr-1 text-white bg-blue-500 border border-blue-500 rounded">{{ $link
                                                                                                }}</span>
                            @else
                                <a href="{{ $books->url($link) }}"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link
                                                                                                }}</a>
                            @endif
                        @endforeach

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
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="container px-4 mx-auto mt-6">

        <h2 class="mb-6 text-3xl font-bold text-center text-gray-800 dark:text-white">📚 Daftar Buku</h2>

        <div class="flex items-center justify-end gap-4 mb-6 text-right">
            <a href="{{ route('books.inactive') }}"
                class="px-4 py-2 font-semibold text-white transition duration-300 bg-gray-500 rounded hover:bg-gray-600">
                🚫 Lihat Buku Nonaktif
            </a>

            <a href="{{ route('books.create') }}"
                class="px-4 py-2 font-semibold text-white transition duration-300 bg-blue-600 rounded hover:bg-blue-700">
                ➕ Tambah Buku
            </a>
        </div>

        @if (session('success'))
            <div id="success-alert"
                class="px-4 py-3 mb-6 text-green-700 transition-opacity duration-500 bg-green-100 border border-green-400 rounded"
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
                class="px-4 py-3 mb-6 text-red-700 transition-opacity duration-500 bg-red-100 border border-red-400 rounded"
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

        <div class="flex flex-col gap-3 mb-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <div class="flex items-center">
                    <label for="per_page" class="mr-2 text-sm text-gray-600 dark:text-white">Show:</label>
                    <select id="per_page" onchange="fetchData()"
                        class="block px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="6" {{ $perPage == 6 ? 'selected' : '' }}>6</option>
                        <option value="12" {{ $perPage == 12 ? 'selected' : '' }}>12</option>
                        <option value="27" {{ $perPage == 27 ? 'selected' : '' }}>27</option>
                        <option value="51" {{ $perPage == 51 ? 'selected' : '' }}>51</option>
                        <option value="101" {{ $perPage == 101 ? 'selected' : '' }}>101</option>
                    </select>
                </div>

                <div class="flex items-center">
                    <label for="view" class="mr-2 text-sm text-gray-600 dark:text-white">View:</label>
                    <select id="view" onchange="fetchData()"
                        class="block px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="card" {{ $view == 'card' ? 'selected' : '' }}>Card</option>
                        <option value="list" {{ $view == 'list' ? 'selected' : '' }}>List</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center">
                <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                <input type="text" id="search" oninput="handleSearch()"
                    class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ $search }}" placeholder="Ketik judul buku...">
            </div>
        </div>
        <div id="dynamic-content">

            {{-- Mode CARD --}}
            @if ($view === 'card')
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($books as $book)
                        <div
                            class="flex flex-col transition duration-300 bg-white border border-gray-200 shadow-md dark:bg-gray-500 rounded-xl dark:border-gray-700 hover:shadow-lg">
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

                                <div class="flex flex-wrap gap-2 mt-auto">
                                    <a href="{{ route('books.show', $book->id) }}"
                                        class="px-4 py-2 text-sm text-white rounded bg-cyan-600 hover:bg-cyan-700">🔍 Detail</a>

                                    <a href="{{ route('books.edit', $book->id) }}"
                                        class="px-4 py-2 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">✏️ Edit</a>

                                    <button type="button" onclick="openDeleteModal({{ $book->id }})"
                                        class="px-4 py-2 text-sm text-white bg-red-600 rounded hover:bg-red-700">🚫
                                        Nonaktifkan</button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-10 text-gray-500 dark:text-white">
                            Tidak ada buku ditemukan.
                        </div>
                    @endforelse
                </div>

                {{-- Mode LIST --}}
            @else
                <div class="overflow-x-auto bg-white rounded shadow dark:bg-gray-700">
                    <table class="min-w-full border border-gray-200 dark:border-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-600">
                            <tr>
                                <th class="px-4 py-2 border dark:text-white">Cover</th>
                                <th class="px-4 py-2 border dark:text-white">Judul</th>
                                <th class="px-4 py-2 border dark:text-white">Penulis</th>
                                <th class="px-4 py-2 border dark:text-white">Stok</th>
                                <th class="px-4 py-2 border dark:text-white">Kategori</th>
                                <th class="px-4 py-2 border dark:text-white">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($books as $book)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-4 py-2 text-center border dark:border-white">
                                        <img src="{{ $book->image_url ? Storage::disk('s3')->url($book->image_url) : asset('assets/images/avatar.png') }}"
                                            alt="book image" class="object-contain w-16 h-20 mx-auto"
                                            onerror="this.onerror=null;this.src='{{ asset('assets/images/avatar.png') }}';">
                                    </td>
                                    <td class="px-4 py-2 border dark:text-white">{{ $book->title }}</td>
                                    <td class="px-4 py-2 border dark:text-white">{{ $book->author }}</td>
                                    <td class="px-4 py-2 text-center border dark:text-white">{{ $book->stock }}</td>
                                    <td class="px-4 py-2 border dark:text-white">{{ $book->category->name }}</td>
                                    <td class="px-4 py-2 text-center border dark:border-white">
                                        <a href="{{ route('books.show', $book->id) }}"
                                            class="px-3 py-1 text-sm text-white rounded bg-cyan-600 hover:bg-cyan-700">🔍</a>

                                        <a href="{{ route('books.edit', $book->id) }}"
                                            class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">✏️</a>

                                        <button type="button" onclick="openDeleteModal({{ $book->id }})"
                                            class="px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700">🚫</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500 dark:text-white">
                                        Tidak ada buku ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            <div id="pagination-links" class="flex items-center justify-between mt-4">
                <div>
                    @if ($books->total() > 0)
                        <p class="text-sm text-gray-700 dark:text-white">
                            Showing {{ $books->firstItem() }} to {{ $books->lastItem() }} of {{ $books->total() }} entries
                        </p>
                    @endif
                </div>
                <div>
                    @if ($books->hasPages())
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                            @if ($books->onFirstPage())
                                <span class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                            @else
                                <a href="{{ $books->previousPageUrl() }}"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                            @endif

                            @php
                                $currentPage = $books->currentPage();
                                $lastPage = $books->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            @endphp

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $currentPage)
                                    <span class="px-3 py-1 mr-1 text-white bg-blue-500 border border-blue-500 rounded">{{ $i }}</span>
                                @else
                                    <a href="{{ $books->url($i) }}"
                                        class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $i }}</a>
                                @endif
                            @endfor

                            @if ($books->hasMorePages())
                                <a href="{{ $books->nextPageUrl() }}"
                                    class="px-3 py-1 ml-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Next</a>
                            @else
                                <span class="px-3 py-1 ml-1 text-gray-400 bg-white border rounded cursor-not-allowed">Next</span>
                            @endif
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form id="globalDeleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('scripts')
    <script>
        // =========================================================
        // 1. ENGINE SPA (PREFETCH, CACHE, & REAL-TIME SEARCH)
        // =========================================================
        const pageCache = {};
        let currentAbortController = null;
        let debounceTimer;

        // Fungsi Debounce agar tidak spam server saat user ngetik cepat
        function handleSearch() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetchData();
            }, 100);
        }

        // Fungsi Inti Fetch Data SPA
        function fetchData(targetUrl = null) {
            if (typeof targetUrl !== 'string') targetUrl = null;

            const search = document.getElementById('search').value;
            const perPage = document.getElementById('per_page').value;
            const view = document.getElementById('view').value; // Mengambil status View (Card/List)

            let urlString = targetUrl || `{{ route('books.index') }}`;
            const urlObj = new URL(urlString, window.location.origin);

            // Paksa HTTPS jika berjalan di production/Vercel
            if (window.location.protocol === 'https:') {
                urlObj.protocol = 'https:';
            }

            // Pasang semua parameter ke URL
            urlObj.searchParams.set('search', search);
            urlObj.searchParams.set('per_page', perPage);
            urlObj.searchParams.set('view', view);

            const finalUrl = urlObj.toString();

            // Cek Cache (Sihir 0ms delay)
            if (pageCache[finalUrl]) {
                renderDOM(pageCache[finalUrl]);
                window.history.pushState({ path: finalUrl }, '', finalUrl);
                return;
            }

            if (currentAbortController) {
                currentAbortController.abort();
            }
            currentAbortController = new AbortController();

            document.getElementById('dynamic-content').style.opacity = '0.5';

            fetch(finalUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                signal: currentAbortController.signal
            })
                .then(response => {
                    if (!response.ok) throw new Error("Gagal memuat server");
                    return response.text();
                })
                .then(html => {
                    pageCache[finalUrl] = html;
                    renderDOM(html);
                    window.history.pushState({ path: finalUrl }, '', finalUrl);
                })
                .catch(error => {
                    if (error.name !== 'AbortError') {
                        console.error('Fetch Error:', error);
                        document.getElementById('dynamic-content').style.opacity = '1';
                    }
                });
        }

        function renderDOM(html) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const dynamicElement = doc.getElementById('dynamic-content');

            if (dynamicElement) {
                document.getElementById('dynamic-content').innerHTML = dynamicElement.innerHTML;
            }
            document.getElementById('dynamic-content').style.opacity = '1';
        }

        // TAHAP 4: INTENT PREDICTION (SIHIR 0ms)
        document.addEventListener('mouseover', function (e) {
            const link = e.target.closest('#pagination-links a');
            if (link) {
                const hoverUrlObj = new URL(link.href, window.location.origin);
                if (window.location.protocol === 'https:') {
                    hoverUrlObj.protocol = 'https:';
                }
                const safeHoverUrl = hoverUrlObj.toString();

                if (!pageCache[safeHoverUrl]) {
                    fetch(safeHoverUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(res => res.text())
                        .then(html => pageCache[safeHoverUrl] = html)
                        .catch(() => { });
                }
            }
        });

        // TAHAP 5: EVENT DELEGATION UNTUK KLIK PAGINATION
        document.addEventListener('click', function (e) {
            const link = e.target.closest('#pagination-links a');
            if (link) {
                e.preventDefault();
                fetchData(link.href);
            }
        });

        // TAHAP 6: HANDLE TOMBOL BACK/FORWARD BROWSER
        window.addEventListener('popstate', function (e) {
            if (e.state && e.state.path) {
                fetchData(e.state.path);
            } else {
                fetchData(window.location.href);
            }
        });

        // =========================================================
        // 2. SWEETALERT MODALS LOGIC
        // =========================================================
        const isDark = () => document.documentElement.classList.contains('dark');
        const swalBg = () => isDark() ? '#1f2937' : '#ffffff';
        const swalText = () => isDark() ? '#ffffff' : '#374151';

        // SweetAlert untuk Konfirmasi Nonaktifkan/Hapus Buku
        function openDeleteModal(bookId) {
            Swal.fire({
                title: 'Nonaktifkan Buku?',
                text: "Apakah Anda yakin ingin menonaktifkan buku ini? Buku tidak akan dihapus secara permanen.",
                icon: 'warning',
                background: swalBg(),
                color: swalText(),
                showCancelButton: true,
                confirmButtonColor: '#dc2626', // Red
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Nonaktifkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('globalDeleteForm');
                    // Mengganti placeholder ID dengan bookId yang dipilih
                    const baseAction = "{{ route('books.destroy', 'ID_PLACEHOLDER') }}";
                    form.action = baseAction.replace('ID_PLACEHOLDER', bookId);
                    form.submit();
                }
            });
        }
    </script>
@endsection
