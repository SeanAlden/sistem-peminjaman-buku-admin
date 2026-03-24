{{-- @extends('layouts.app')

@section('content')
    <div class="container px-4 py-6 mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="mb-4 text-2xl font-bold dark:text-white">Barang Keluar</h1>
            <!-- Tombol untuk memunculkan modal tambah -->
            <button onclick="openAddModal()"
                class="px-4 py-2 text-white bg-blue-600 rounded cursor-pointer hover:bg-blue-700">+ Tambah Barang
                Keluar</button>
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

        <!-- Modal Tambah Data -->
        <div id="addModal" class="fixed inset-0 z-10 items-center justify-center hidden"
            style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="w-full max-w-xl p-6 bg-white rounded shadow-lg">
                <h2 class="mb-4 text-xl font-semibold">Tambah Barang Keluar</h2>
                <form action="{{ route('exit_books.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label>Buku</label>
                            <select name="book_id" class="w-full p-2 border rounded">
                                @foreach ($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Supplier</label>
                            <select name="supplier_id" class="w-full p-2 border rounded">
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Jumlah Keluar</label>
                            <input type="number" name="stock_out" class="w-full p-2 border rounded" min="1"
                                required>
                        </div>
                        <div>
                            <label>Alasan</label>
                            <input type="text" name="reason" class="w-full p-2 border rounded"
                                placeholder="Rusak, robek, dll">
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="closeAddModal()" class="mr-2 text-gray-600">Batal</button>
                        <button class="px-4 py-2 text-white bg-blue-600 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit Data -->
        <div id="editModal" class="fixed inset-0 z-10 items-center justify-center hidden"
            style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="w-full max-w-xl p-6 bg-white rounded shadow-lg">
                <h2 class="mb-4 text-xl font-semibold">Edit Barang Keluar</h2>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label>Buku</label>
                            <select name="book_id" id="edit_book_id" class="w-full p-2 border rounded">
                                @foreach ($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Supplier</label>
                            <select name="supplier_id" id="edit_supplier_id" class="w-full p-2 border rounded">
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Jumlah Keluar</label>
                            <input type="number" name="stock_out" id="edit_stock_out" class="w-full p-2 border rounded"
                                min="1" required>
                        </div>
                        <div>
                            <label>Alasan</label>
                            <input type="text" name="reason" id="edit_reason" class="w-full p-2 border rounded">
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="closeEditModal()" class="mr-2 text-gray-600">Batal</button>
                        <button class="px-4 py-2 text-white bg-green-600 rounded">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Fitur Search dan Items per Page -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <form action="{{ route('exit_books.index') }}" method="GET" class="flex items-center">
                    <label for="per_page" class="mr-2 text-sm text-gray-600 dark:text-white">Show:</label>
                    <select name="per_page" id="per_page"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        onchange="this.form.submit()">
                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <input type="hidden" name="search" value="{{ $search }}">
                </form>
            </div>
            <div class="flex items-center">
                <form action="{{ route('exit_books.index') }}" method="GET" class="flex items-center">
                    <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>
        <!-- End Fitur -->

        <!-- Tabel Data -->
        <table class="min-w-full bg-white border">
            <thead>
                <tr class="text-left bg-gray-200 dark:bg-gray-600">
                    <th class="px-4 py-2 border dark:text-white">Gambar</th> <!-- Tambahkan ini -->
                    <th class="px-4 py-2 border dark:text-white">Buku</th>
                    <th class="px-4 py-2 border dark:text-white">Supplier</th>
                    <th class="px-4 py-2 border dark:text-white">Stok Sebelum</th>
                    <th class="px-4 py-2 border dark:text-white">Jumlah Keluar</th>
                    <th class="px-4 py-2 border dark:text-white">Stok Setelah</th>
                    <th class="px-4 py-2 border dark:text-white">Alasan</th>
                    <th class="px-4 py-2 border dark:text-white">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($exits as $exit)
                    <tr class="border-b dark:border-white hover:bg-gray-50 dark:hover:bg-gray-600 dark:bg-gray-500">
                        <td class="px-4 py-2 text-center border dark:border-white">
                            @if ($exit->book->image_url)
                                <img src="{{ $exit->book->image_url ? Storage::disk('s3')->url($exit->book->image_url) : asset('assets/images/avatar.png') }}"
                                    alt="Gambar Buku" class="object-cover w-16 h-20 mx-auto rounded" />
                            @else
                                <img src="{{ asset('assets/images/avatar.png') }}" alt="Gambar Buku"
                                    class="object-cover w-16 h-20 mx-auto rounded" />
                            @endif
                        </td>
                        <td class="px-4 py-2 border dark:border-white dark:text-white">{{ $exit->book->title }}</td>
                        <td class="px-4 py-2 border dark:border-white dark:text-white">{{ $exit->supplier->name }}</td>
                        <td class="px-4 py-2 border dark:border-white dark:text-white">{{ $exit->stock_before }}</td>
                        <td class="px-4 py-2 font-bold text-red-500">- {{ $exit->stock_out }}</td>
                        <td class="px-4 py-2 border dark:border-white dark:text-white">{{ $exit->stock_after }}</td>
                        <td class="px-4 py-2 border dark:border-white dark:text-white">{{ $exit->reason }}</td>
                        <td class="px-4 py-2 border dark:border-white dark:text-white">
                            <button onclick="openEditModal({{ $exit }})"
                                class="mr-2 text-blue-500 hover:underline dark:text-blue-300">Edit</button>
                            <form action="{{ route('exit_books.destroy', $exit->id) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus?')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 dark:text-red-300 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Fitur Pagination -->
        <div class="flex items-center justify-between mt-4">
            <div>
                @if ($exits->total() > 0)
                    <p class="text-sm text-gray-700 dark:text-white">
                        Showing {{ $exits->firstItem() }} to {{ $exits->lastItem() }} of {{ $exits->total() }}
                        exits
                    </p>
                @endif
            </div>
            <div>
                @if ($exits->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                        @if ($exits->onFirstPage())
                            <span
                                class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                        @else
                            <a href="{{ $exits->previousPageUrl() }}" rel="prev"
                                class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                        @endif

                        @php
                            $currentPage = $exits->currentPage();
                            $lastPage = $exits->lastPage();
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
                                <span
                                    class="px-3 py-1 mr-1 text-gray-500 bg-white border rounded">{{ $link }}</span>
                            @elseif ($link == $currentPage)
                                <span
                                    class="px-3 py-1 mr-1 text-white bg-blue-500 border border-blue-500 rounded">{{ $link }}</span>
                            @else
                                <a href="{{ $exits->url($link) }}"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                            @endif
                        @endforeach

                        @if ($exits->hasMorePages())
                            <a href="{{ $exits->nextPageUrl() }}" rel="next"
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

    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addModal').classList.remove('flex');
        }

        function openEditModal(data) {
            const route = `/exit-books/${data.id}`;
            document.getElementById('editForm').action = route;

            document.getElementById('edit_book_id').value = data.book_id;
            document.getElementById('edit_supplier_id').value = data.supplier_id;
            document.getElementById('edit_stock_out').value = data.stock_out;
            document.getElementById('edit_reason').value = data.reason ?? '';

            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
        }
    </script>
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="container px-4 py-6 mx-auto min-h-screen">
        <div class="flex items-center justify-between mb-6">
            <h1 class="mb-4 text-2xl font-bold dark:text-white">Barang Keluar</h1>
            <button onclick="openCreateModal()"
                class="px-4 py-2 text-white bg-blue-600 rounded shadow-md cursor-pointer hover:bg-blue-700 transition">
                + Tambah Barang Keluar
            </button>
        </div>

        @if (session('success'))
            <div id="success-alert"
                class="px-4 py-3 mb-6 text-green-700 transition-opacity duration-500 bg-green-100 border border-green-400 rounded shadow-sm"
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
                class="px-4 py-3 mb-6 text-red-700 transition-opacity duration-500 bg-red-100 border border-red-400 rounded shadow-sm"
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
            <div class="flex items-center w-full sm:w-auto">
                <label for="per_page" class="mr-2 text-sm text-gray-600 dark:text-white">Show:</label>
                <select id="per_page" onchange="fetchData()"
                    class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 sm:w-auto">
                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
            <div class="flex items-center w-full sm:w-auto">
                <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                <input type="text" id="search" oninput="handleSearch()"
                    class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 sm:w-64"
                    value="{{ $search }}" placeholder="Cari buku/supplier...">
            </div>
        </div>
        <div id="dynamic-content">
            <div class="overflow-x-auto rounded-lg shadow-lg dark:bg-gray-800">
                <table class="min-w-full bg-white border-collapse dark:bg-gray-800">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr class="text-left text-sm tracking-wider text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-200">
                            <th class="px-4 py-3 font-semibold border dark:border-gray-600 text-center">Gambar</th>
                            <th class="px-4 py-3 font-semibold border dark:border-gray-600">Buku</th>
                            <th class="px-4 py-3 font-semibold border dark:border-gray-600">Supplier</th>
                            <th class="px-4 py-3 font-semibold border dark:border-gray-600 text-center">Stok Sebelum</th>
                            <th class="px-4 py-3 font-semibold border dark:border-gray-600 text-center">Jumlah Keluar</th>
                            <th class="px-4 py-3 font-semibold border dark:border-gray-600 text-center">Stok Setelah</th>
                            <th class="px-4 py-3 font-semibold border dark:border-gray-600">Alasan</th>
                            <th class="px-4 py-3 font-semibold border dark:border-gray-600 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 dark:text-gray-200 text-sm">
                        @forelse($exits as $exit)
                            <tr class="transition-colors border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 dark:bg-gray-500">
                                <td class="px-4 py-2 text-center border dark:border-gray-700">
                                    <img src="{{ $exit->book->image_url ? Storage::disk('s3')->url($exit->book->image_url) : asset('assets/images/avatar.png') }}"
                                        alt="Gambar Buku" class="object-cover w-12 h-16 mx-auto rounded shadow-sm"
                                        onerror="this.onerror=null;this.src='{{ asset('assets/images/avatar.png') }}';" />
                                </td>
                                <td class="px-4 py-2 border font-medium dark:border-gray-700">{{ $exit->book->title }}</td>
                                <td class="px-4 py-2 border dark:border-gray-700">{{ $exit->supplier->name ?? '-' }}</td>
                                <td class="px-4 py-2 border text-center dark:border-gray-700">{{ $exit->stock_before }}</td>
                                <td class="px-4 py-2 font-bold text-center text-red-600 dark:text-red-400 border dark:border-gray-700">- {{ $exit->stock_out }}</td>
                                <td class="px-4 py-2 border text-center font-semibold dark:border-gray-700">{{ $exit->stock_after }}</td>
                                <td class="px-4 py-2 border dark:border-gray-700">{{ $exit->reason ?? '-' }}</td>
                                <td class="px-4 py-2 border text-center dark:border-gray-700">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" onclick='openEditModal(@json($exit))'
                                            class="px-3 py-1.5 text-xs font-medium text-white transition bg-yellow-500 rounded hover:bg-yellow-600 shadow-sm">
                                            Edit
                                        </button>
                                        <button type="button" onclick="openDeleteModal({{ $exit->id }})"
                                            class="px-3 py-1.5 text-xs font-medium text-white transition bg-red-600 rounded hover:bg-red-700 shadow-sm">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-gray-500 dark:text-gray-400">Belum ada data barang keluar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="pagination-links" class="flex flex-col items-center justify-between mt-6 sm:flex-row">
                <div class="mb-4 sm:mb-0">
                    @if ($exits->total() > 0)
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Showing {{ $exits->firstItem() }} to {{ $exits->lastItem() }} of {{ $exits->total() }} exits
                        </p>
                    @endif
                </div>
                <div>
                    @if ($exits->hasPages())
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                            @if ($exits->onFirstPage())
                                <span class="px-3 py-1 mr-1 text-gray-400 bg-white border border-gray-300 rounded cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500">Prev</span>
                            @else
                                <a href="{{ $exits->previousPageUrl() }}" rel="prev" class="px-3 py-1 mr-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">Prev</a>
                            @endif

                            @php
                                $currentPage = $exits->currentPage();
                                $lastPage = $exits->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            @endphp

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $currentPage)
                                    <span class="px-3 py-1 mr-1 text-white bg-blue-600 border border-blue-600 rounded dark:bg-blue-600 dark:border-blue-600">{{ $i }}</span>
                                @else
                                    <a href="{{ $exits->url($i) }}" class="px-3 py-1 mr-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">{{ $i }}</a>
                                @endif
                            @endfor

                            @if ($exits->hasMorePages())
                                <a href="{{ $exits->nextPageUrl() }}" rel="next" class="px-3 py-1 ml-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">Next</a>
                            @else
                                <span class="px-3 py-1 ml-1 text-gray-400 bg-white border border-gray-300 rounded cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500">Next</span>
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

        // Fungsi Debounce untuk Pengetikan Pencarian
        function handleSearch() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetchData();
            }, 100);
        }

        // Fetch Data Utama SPA
        function fetchData(targetUrl = null) {
            if (typeof targetUrl !== 'string') targetUrl = null;

            const search = document.getElementById('search').value;
            const perPage = document.getElementById('per_page').value;

            // Route target
            let urlString = targetUrl || `{{ route('exit_books.index') }}`;
            const urlObj = new URL(urlString, window.location.origin);

            // Fix Vercel HTTPS Protocol Error
            if (window.location.protocol === 'https:') {
                urlObj.protocol = 'https:';
            }

            urlObj.searchParams.set('search', search);
            urlObj.searchParams.set('per_page', perPage);

            const finalUrl = urlObj.toString();

            // Cek Cache (0ms Delay)
            if (pageCache[finalUrl]) {
                renderDOM(pageCache[finalUrl]);
                window.history.pushState({ path: finalUrl }, '', finalUrl);
                return;
            }

            // Batalkan request lama jika mengetik cepat
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

        // INTENT PREDICTION (Hover Fetching)
        document.addEventListener('mouseover', function (e) {
            const link = e.target.closest('#pagination-links a');
            if (link) {
                const hoverUrlObj = new URL(link.href, window.location.origin);
                if (window.location.protocol === 'https:') hoverUrlObj.protocol = 'https:';
                const safeHoverUrl = hoverUrlObj.toString();

                if (!pageCache[safeHoverUrl]) {
                    fetch(safeHoverUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(res => res.text())
                        .then(html => pageCache[safeHoverUrl] = html)
                        .catch(() => { });
                }
            }
        });

        // EVENT DELEGATION UNTUK PAGINASI
        document.addEventListener('click', function(e) {
            const link = e.target.closest('#pagination-links a');
            if (link) {
                e.preventDefault();
                fetchData(link.href);
            }
        });

        // SPA Navigation Back/Forward
        window.addEventListener('popstate', function(e) {
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

        // --- Helper: Build Options Dropdown dari Blade ---
        function buildBookSelect(selectedId = '') {
            let options = '<option value="">-- Pilih Buku --</option>';
            @foreach ($books as $book)
                options += `<option value="{{ $book->id }}" ${selectedId == {{ $book->id }} ? 'selected' : ''}>{{ addslashes($book->title) }}</option>`;
            @endforeach
            return options;
        }

        function buildSupplierSelect(selectedId = '') {
            let options = '<option value="">-- Opsional --</option>';
            @foreach ($suppliers as $supplier)
                options += `<option value="{{ $supplier->id }}" ${selectedId == {{ $supplier->id }} ? 'selected' : ''}>{{ addslashes($supplier->name) }}</option>`;
            @endforeach
            return options;
        }
        // --------------------------------------------------

        // ADD MODAL
        function openCreateModal() {
            Swal.fire({
                title: 'Tambah Barang Keluar',
                background: swalBg(),
                color: swalText(),
                width: '600px', // Modal sedikit lebih lebar
                html: `
                    <form id="createForm" action="{{ route('exit_books.store') }}" method="POST" class="text-left text-sm space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="block mb-1 font-medium">Buku</label>
                                <select name="book_id" required class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500">
                                    ${buildBookSelect()}
                                </select>
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Supplier (Tujuan)</label>
                                <select name="supplier_id" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500">
                                    ${buildSupplierSelect()}
                                </select>
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Jumlah Keluar</label>
                                <input type="number" name="stock_out" min="1" required class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" placeholder="10" />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Alasan</label>
                                <input type="text" name="reason" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" placeholder="Rusak, robek, dll" />
                            </div>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#2563eb', // Blue-600
                cancelButtonColor: '#6b7280',
                preConfirm: () => {
                    const form = document.getElementById('createForm');
                    if (form.checkValidity()) {
                        form.submit();
                        return false;
                    } else {
                        form.reportValidity();
                        return false;
                    }
                }
            });
        }

        // EDIT MODAL (Data Injection via @json)
        function openEditModal(exitData) {
            Swal.fire({
                title: 'Edit Barang Keluar',
                background: swalBg(),
                color: swalText(),
                width: '600px',
                html: `
                    <form id="editForm" action="/admin/exit-books/${exitData.id}" method="POST" class="text-left text-sm space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="block mb-1 font-medium">Buku (Tidak dapat diubah)</label>
                                <select disabled class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-500 cursor-not-allowed dark:bg-gray-800 dark:border-gray-600">
                                    ${buildBookSelect(exitData.book_id)}
                                </select>
                                <input type="hidden" name="book_id" value="${exitData.book_id}">
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Supplier (Tujuan)</label>
                                <select name="supplier_id" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500">
                                    ${buildSupplierSelect(exitData.supplier_id)}
                                </select>
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Jumlah Keluar</label>
                                <input type="number" name="stock_out" value="${exitData.stock_out}" min="1" required class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Alasan</label>
                                <input type="text" name="reason" value="${exitData.reason || ''}" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" />
                            </div>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Simpan Perubahan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#eab308', // Yellow-500
                cancelButtonColor: '#6b7280',
                preConfirm: () => {
                    const form = document.getElementById('editForm');
                    if (form.checkValidity()) {
                        form.submit();
                        return false;
                    } else {
                        form.reportValidity();
                        return false;
                    }
                }
            });
        }

        // DELETE MODAL
        function openDeleteModal(exitId) {
            Swal.fire({
                title: 'Hapus Catatan?',
                text: "Apakah Anda yakin ingin menghapus data barang keluar ini? Stok buku akan dikembalikan.",
                icon: 'warning',
                background: swalBg(),
                color: swalText(),
                showCancelButton: true,
                confirmButtonColor: '#dc2626', // Red-600
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('globalDeleteForm');
                    // Eksekusi rute Delete
                    form.action = `/admin/exit-books/${exitId}`;
                    form.submit();
                }
            });
        }
    </script>
@endsection
