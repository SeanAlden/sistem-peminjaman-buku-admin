{{-- @extends('layouts.app')

@section('content')
    <div class="container px-4 mx-auto">
        <h1 class="mb-6 text-3xl font-bold text-gray-800 dark:text-white">📦 Daftar Pengadaan</h1>

        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('purchases.create') }}"
                class="inline-flex items-center px-4 py-2 text-white transition bg-blue-600 rounded shadow hover:bg-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Tambah Pengadaan
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

        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <form action="{{ route('purchases.index') }}" method="GET" class="flex items-center">
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
                <form action="{{ route('purchases.index') }}" method="GET" class="flex items-center">
                    <label for="search" class="mr-2 text-sm text-gray-600 dark:text-gray-300">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full overflow-hidden bg-white border-collapse rounded-lg shadow-md table-auto">
                <thead>
                    <tr class="text-sm tracking-wider text-gray-700 uppercase bg-gray-200 dark:bg-gray-600">
                        <th class="px-4 py-3 border dark:text-white">Buku</th>
                        <th class="px-4 py-3 border dark:text-white">Supplier</th>
                        <th class="px-4 py-3 border dark:text-white">Tanggal</th>
                        <th class="px-4 py-3 border dark:text-white">Jumlah (Sisa / Awal)</th>
                        <th class="px-4 py-3 text-center bg-gray-300 border dark:bg-gray-700 dark:text-white">Total
                            Pengadaan (Buku Ini)</th>
                        <th class="px-4 py-3 border dark:text-white">Total Harga</th>
                        <th class="px-4 py-3 border dark:text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    @php $currentBookId = null; @endphp

                    @forelse($purchases as $purchase)
                        @if ($purchase->book_id !== $currentBookId && $currentBookId !== null)
                            <tr class="bg-gray-200">
                                <td colspan="7" class="py-1"></td>
                            </tr>
                        @endif

                        <tr class="transition hover:bg-gray-100 dark:hover:bg-gray-700 dark:bg-gray-500">
                            <td class="px-4 py-2 font-semibold border dark:text-white">{{ $purchase->book->title }}</td>
                            <td class="px-4 py-2 border dark:text-white">{{ $purchase->supplier->name }}</td>
                            <td class="px-4 py-2 text-center border dark:text-white">
                                {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}</td>
                            <td class="px-4 py-2 text-center border">
                                <div class="text-sm font-semibold dark:text-white">
                                    {{ $purchase->quantity }} / {{ $purchase->initial_quantity }}
                                </div>
                                @php
                                    $percentage =
                                        $purchase->initial_quantity > 0
                                            ? ($purchase->quantity / $purchase->initial_quantity) * 100
                                            : 0;
                                @endphp
                                <div class="w-full h-2 mt-1 bg-gray-200 rounded-full">
                                    <div class="h-2 bg-blue-600 rounded-full" style="width: {{ $percentage }}%;"></div>
                                </div>
                            </td>

                            @if ($purchase->book_id !== $currentBookId)
                                <td class="px-4 py-2 text-lg font-bold text-center align-middle border bg-gray-50 dark:bg-gray-400 dark:text-white"
                                    rowspan="{{ $purchases->where('book_id', $purchase->book_id)->count() }}">
                                    {{ $bookTotalQuantities[$purchase->book_id] ?? 'N/A' }}
                                </td>
                            @endif

                            <td class="px-4 py-2 text-right border dark:text-white">
                                Rp{{ number_format($purchase->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 text-center border">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('purchases.edit', $purchase->id) }}"
                                        class="inline-flex items-center px-3 py-1 text-white transition bg-yellow-400 rounded hover:bg-yellow-500">✏️
                                        Edit</a>
                                    <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1 text-white transition bg-red-500 rounded hover:bg-red-600">🗑️
                                            Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @php $currentBookId = $purchase->book_id; @endphp
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-gray-500">Belum ada data pengadaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Fitur Pagination -->
        <div class="flex items-center justify-between mt-4">
            <div>
                @if ($purchases->total() > 0)
                    <p class="text-sm text-gray-700 dark:text-white">
                        Showing {{ $purchases->firstItem() }} to {{ $purchases->lastItem() }} of
                        {{ $purchases->total() }}
                        entries
                    </p>
                @endif
            </div>
            <div>
                @if ($purchases->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                        @if ($purchases->onFirstPage())
                            <span
                                class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                        @else
                            <a href="{{ $purchases->previousPageUrl() }}" rel="prev"
                                class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                        @endif

                        @php
                            $currentPage = $purchases->currentPage();
                            $lastPage = $purchases->lastPage();
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
                                <a href="{{ $purchases->url($link) }}"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                            @endif
                        @endforeach

                        @if ($purchases->hasMorePages())
                            <a href="{{ $purchases->nextPageUrl() }}" rel="next"
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

@extends('layouts.app')

@section('content')
    <div class="container px-4 mx-auto min-h-screen py-8">
        <h1 class="mb-6 text-3xl font-bold text-gray-800 dark:text-white">📦 Daftar Pengadaan</h1>

        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('purchases.create') }}"
                class="inline-flex items-center px-4 py-2 text-white transition bg-blue-600 rounded shadow-md hover:bg-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Tambah Pengadaan
            </a>
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

        <div class="flex flex-col gap-3 mb-6 sm:flex-row sm:items-center sm:justify-between">
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
                <label for="search" class="mr-2 text-sm text-gray-600 dark:text-gray-300">Search:</label>
                <input type="text" id="search" oninput="handleSearch()"
                    class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 sm:w-64"
                    value="{{ $search }}" placeholder="Cari buku atau supplier...">
            </div>
        </div>

        <div id="dynamic-content">
            <div class="overflow-x-auto bg-white rounded-lg shadow-lg dark:bg-gray-800">
                <table class="w-full overflow-hidden bg-white border-collapse rounded-lg shadow-md table-auto dark:bg-gray-800">
                    <thead>
                        <tr class="text-sm tracking-wider text-left text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-200">
                            <th class="px-4 py-3 border dark:border-gray-600">Buku</th>
                            <th class="px-4 py-3 border dark:border-gray-600">Supplier</th>
                            <th class="px-4 py-3 border dark:border-gray-600 text-center">Tanggal</th>
                            <th class="px-4 py-3 border dark:border-gray-600 text-center">Jumlah (Sisa / Awal)</th>
                            <th class="px-4 py-3 text-center bg-gray-300 border dark:bg-gray-600 dark:border-gray-500">Total Pengadaan (Buku Ini)</th>
                            <th class="px-4 py-3 border dark:border-gray-600 text-right">Total Harga</th>
                            <th class="px-4 py-3 border dark:border-gray-600 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700 dark:text-gray-200">
                        @php $currentBookId = null; @endphp

                        @forelse($purchases as $purchase)
                            {{-- Menambahkan garis pemisah antar grup buku --}}
                            @if ($purchase->book_id !== $currentBookId && $currentBookId !== null)
                                <tr class="bg-gray-100 dark:bg-gray-900">
                                    <td colspan="7" class="py-1"></td>
                                </tr>
                            @endif

                            <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-700 dark:bg-gray-800">
                                <td class="px-4 py-3 font-semibold border dark:border-gray-700">{{ $purchase->book->title }}</td>
                                <td class="px-4 py-3 border dark:border-gray-700">{{ $purchase->supplier->name }}</td>
                                <td class="px-4 py-3 text-center border dark:border-gray-700">
                                    {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 text-center border dark:border-gray-700">
                                    <div class="text-sm font-semibold">
                                        {{ $purchase->quantity }} / {{ $purchase->initial_quantity }}
                                    </div>
                                    @php
                                        $percentage = $purchase->initial_quantity > 0 ? ($purchase->quantity / $purchase->initial_quantity) * 100 : 0;
                                    @endphp
                                    <div class="w-full h-2 mt-1 bg-gray-200 rounded-full dark:bg-gray-600">
                                        <div class="h-2 bg-blue-600 rounded-full" style="width: {{ $percentage }}%;"></div>
                                    </div>
                                </td>

                                {{-- Logika untuk menampilkan total hanya sekali per grup --}}
                                @if ($purchase->book_id !== $currentBookId)
                                    <td class="px-4 py-3 text-lg font-bold text-center align-middle border bg-gray-50 dark:bg-gray-700 dark:border-gray-600"
                                        rowspan="{{ $purchases->where('book_id', $purchase->book_id)->count() }}">
                                        {{ $bookTotalQuantities[$purchase->book_id] ?? 'N/A' }}
                                    </td>
                                @endif

                                <td class="px-4 py-3 text-right border dark:border-gray-700">
                                    Rp {{ number_format($purchase->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-center border dark:border-gray-700">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('purchases.edit', $purchase->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white transition bg-yellow-500 rounded hover:bg-yellow-600 shadow-sm">
                                            ✏️ Edit
                                        </a>

                                        <button type="button" onclick="openDeleteModal({{ $purchase->id }})"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white transition bg-red-600 rounded hover:bg-red-700 shadow-sm">
                                            🗑️ Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            {{-- Update ID buku saat ini --}}
                            @php $currentBookId = $purchase->book_id; @endphp
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada data pengadaan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="pagination-links" class="flex flex-col items-center justify-between mt-6 sm:flex-row">
                <div class="mb-4 sm:mb-0">
                    @if ($purchases->total() > 0)
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Showing {{ $purchases->firstItem() }} to {{ $purchases->lastItem() }} of {{ $purchases->total() }} entries
                        </p>
                    @endif
                </div>
                <div>
                    @if ($purchases->hasPages())
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                            @if ($purchases->onFirstPage())
                                <span class="px-3 py-1 mr-1 text-gray-400 bg-white border border-gray-300 rounded cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500">Prev</span>
                            @else
                                <a href="{{ $purchases->previousPageUrl() }}" rel="prev" class="px-3 py-1 mr-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">Prev</a>
                            @endif

                            @php
                                $currentPage = $purchases->currentPage();
                                $lastPage = $purchases->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            @endphp

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $currentPage)
                                    <span class="px-3 py-1 mr-1 text-white bg-blue-600 border border-blue-600 rounded dark:bg-blue-600 dark:border-blue-600">{{ $i }}</span>
                                @else
                                    <a href="{{ $purchases->url($i) }}" class="px-3 py-1 mr-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">{{ $i }}</a>
                                @endif
                            @endfor

                            @if ($purchases->hasMorePages())
                                <a href="{{ $purchases->nextPageUrl() }}" rel="next" class="px-3 py-1 ml-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">Next</a>
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

        // Fungsi Debounce (Jeda 100ms agar ringan ke server)
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

            // Sesuaikan route dengan target controller Anda
            let urlString = targetUrl || `{{ route('purchases.index') }}`;
            const urlObj = new URL(urlString, window.location.origin);

            // Fix Vercel HTTPS Protocol Error (Wajib!)
            if (window.location.protocol === 'https:') {
                urlObj.protocol = 'https:';
            }

            urlObj.searchParams.set('search', search);
            urlObj.searchParams.set('per_page', perPage);

            const finalUrl = urlObj.toString();

            // Cek Cache (0ms response)
            if (pageCache[finalUrl]) {
                renderDOM(pageCache[finalUrl]);
                window.history.pushState({ path: finalUrl }, '', finalUrl);
                return;
            }

            // Batalkan fetch lama jika user ngetik cepat (Anti Race-Condition)
            if (currentAbortController) {
                currentAbortController.abort();
            }
            currentAbortController = new AbortController();

            // Opacity transisi saat muat data baru
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

        // Render HTML ke div dynamic
        function renderDOM(html) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const dynamicElement = doc.getElementById('dynamic-content');

            if (dynamicElement) {
                document.getElementById('dynamic-content').innerHTML = dynamicElement.innerHTML;
            }
            document.getElementById('dynamic-content').style.opacity = '1';
        }

        // TAHAP 4: INTENT PREDICTION (Fetch data saat hover tombol page)
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

        // TAHAP 5: EVENT DELEGATION (Aman dari overwrite DOM)
        document.addEventListener('click', function(e) {
            const link = e.target.closest('#pagination-links a');
            if (link) {
                e.preventDefault();
                fetchData(link.href);
            }
        });

        // TAHAP 6: HANDLE TOMBOL BROWSER (Back / Forward)
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

        function openDeleteModal(purchaseId) {
            Swal.fire({
                title: 'Hapus Data Pengadaan?',
                text: "Apakah Anda yakin ingin menghapus data pengadaan ini? Stok buku akan disesuaikan kembali secara otomatis.",
                icon: 'warning',
                background: swalBg(),
                color: swalText(),
                showCancelButton: true,
                confirmButtonColor: '#dc2626', // Red-600
                cancelButtonColor: '#6b7280',  // Gray-500
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('globalDeleteForm');
                    // Ganti placeholder dengan ID pengadaan sebenarnya
                    const baseAction = "{{ route('purchases.destroy', 'ID_PLACEHOLDER') }}";
                    form.action = baseAction.replace('ID_PLACEHOLDER', purchaseId);
                    form.submit();
                }
            });
        }
    </script>
@endsection
