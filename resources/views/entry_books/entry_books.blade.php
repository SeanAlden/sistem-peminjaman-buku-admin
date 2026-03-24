{{-- @extends('layouts.app')

@section('content')
    <div class="container px-4 py-6 mx-auto" x-data="entryBookApp()">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold dark:text-white">Barang Masuk</h2>
            <button @click="openAddModal()"
                class="px-4 py-2 text-white bg-blue-600 rounded cursor-pointer hover:bg-blue-700">+ Tambah
                Barang Masuk</button>
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

        <!-- Fitur Search dan Items per Page -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <form action="{{ route('entry_books.index') }}" method="GET" class="flex items-center">
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
                <form action="{{ route('entry_books.index') }}" method="GET" class="flex items-center">
                    <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>
        <!-- End Fitur -->

        <table class="min-w-full bg-white border">
            <thead class="bg-gray-100">
                <tr class="text-left bg-gray-200 dark:bg-gray-600">
                    <th class="px-4 py-2 border dark:text-white">Gambar</th>
                    <th class="px-4 py-2 border dark:text-white">Nama Buku</th>
                    <th class="px-4 py-2 border dark:text-white">Kategori</th>
                    <th class="px-4 py-2 border dark:text-white">Stok Sebelum</th>
                    <th class="px-4 py-2 border dark:text-white">Jumlah Masuk</th>
                    <th class="px-4 py-2 border dark:text-white">Stok Setelah</th>
                    <th class="px-4 py-2 border dark:text-white">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($entries as $entry)
                    <tr class="border-b dark:border-white hover:bg-gray-50 dark:hover:bg-gray-600 dark:bg-gray-500">
                        <td class="px-4 py-2 text-center border dark:border-white">
                            @if ($entry->book->image_url)
                                <img src="{{ $entry->book->image_url ? Storage::disk('s3')->url($entry->book->image_url) : asset('assets/images/avatar.png') }}"
                                    alt="Gambar Buku" class="object-cover w-16 h-20 mx-auto rounded" />
                            @else
                                <img src="{{ asset('assets/images/avatar.png') }}" alt="Gambar Buku"
                                    class="object-cover w-16 h-20 mx-auto rounded" />
                            @endif
                        </td>
                        <td class="px-4 py-2 border dark:border-white dark:text-white">{{ $entry->book->title }}</td>
                        <td class="px-4 py-2 border dark:border-white dark:text-white">
                            {{ $entry->book->category->name ?? '-' }}</td>
                        <td class="px-4 py-2 border dark:border-white dark:text-white">{{ $entry->stock_before }}</td>
                        <td class="px-4 py-2 font-bold text-green-500">+ {{ $entry->stock_in }}</td>
                        <td class="px-4 py-2 border dark:border-white dark:text-white">{{ $entry->stock_after }}</td>
                        <td class="px-4 py-2 border dark:border-white">
                            <button
                                @click="openEditModal({{ $entry->id }}, {{ $entry->book_id }}, {{ $entry->stock_in }})"
                                class="mr-2 text-blue-500 dark:text-blue-300 hover:underline">Edit</button>
                            <form action="{{ route('entry_books.destroy', $entry->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 dark:text-red-300 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <!-- Fitur Pagination -->
        <div class="flex items-center justify-between mt-4">
            <div>
                @if ($entries->total() > 0)
                    <p class="text-sm text-gray-700 dark:text-white">
                        Showing {{ $entries->firstItem() }} to {{ $entries->lastItem() }} of {{ $entries->total() }}
                        entries
                    </p>
                @endif
            </div>
            <div>
                @if ($entries->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                        @if ($entries->onFirstPage())
                            <span
                                class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                        @else
                            <a href="{{ $entries->previousPageUrl() }}" rel="prev"
                                class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                        @endif

                        @php
                            $currentPage = $entries->currentPage();
                            $lastPage = $entries->lastPage();
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
                                <a href="{{ $entries->url($link) }}"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                            @endif
                        @endforeach
                        @if ($entries->hasMorePages())
                            <a href="{{ $entries->nextPageUrl() }}" rel="next"
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

        <!-- Modal Tambah/Ubah -->
        <div class="fixed inset-0 z-50 flex items-center justify-center" x-show="isModalOpen"
            style="display: none; background-color: rgba(0, 0, 0, 0.5);">
            <div class="w-full max-w-md p-6 bg-white rounded shadow" @click.away="closeModal">
                <h3 class="mb-4 text-lg font-semibold" x-text="isEdit ? 'Ubah Barang Masuk' : 'Tambah Barang Masuk'"></h3>
                <form :action="formAction" method="POST">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT" />
                    </template>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Pilih Buku</label>
                        <select name="book_id" x-model="selectedBookId" :disabled="isEdit"
                            class="w-full px-3 py-2 border rounded">
                            <option value="">-- Pilih Buku --</option>
                            @foreach ($books as $book)
                                <option value="{{ $book->id }}">
                                    {{ $book->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Jumlah Stok Masuk</label>
                        <input type="number" name="stock_in" x-model="stockIn"
                            :placeholder="`Masukkan jumlah (maksimal ${maxStock})`" class="w-full px-3 py-2 border rounded"
                            min="1" :max="maxStock" />
                        <span class="text-sm text-gray-500">Maksimal: <span x-text="maxStock"></span></span>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" @click="closeModal" class="px-4 py-2 mr-2 border rounded">Batal</button>
                        <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function entryBookApp() {
            return {
                isModalOpen: false,
                isEdit: false,
                formAction: '',
                selectedBookId: '',
                stockIn: '',
                maxStock: 0,
                purchaseStockMap: @json($purchaseStockMap),

                openAddModal() {
                    this.isModalOpen = true;
                    this.isEdit = false;
                    this.formAction = '{{ route('entry_books.store') }}';
                    this.selectedBookId = '';
                    this.stockIn = '';
                    this.maxStock = 0;
                },

                openEditModal(id, bookId, stockIn) {
                    this.isModalOpen = true;
                    this.isEdit = true;
                    this.formAction = `/entry-books/${id}`;
                    this.selectedBookId = bookId;
                    this.stockIn = stockIn;
                    this.maxStock = this.purchaseStockMap[bookId] ?? 0;
                },

                closeModal() {
                    this.isModalOpen = false;
                    this.selectedBookId = '';
                    this.stockIn = '';
                    this.maxStock = 0;
                },

                init() {
                    // Update max stock dynamically if selected book changes
                    this.$watch('selectedBookId', (bookId) => {
                        this.maxStock = this.purchaseStockMap[bookId] ?? 0;
                    });
                }
            }
        }
    </script>
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="container px-4 py-6 mx-auto min-h-screen">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold dark:text-white">Barang Masuk</h2>
            <button onclick="openCreateModal()"
                class="px-4 py-2 text-white transition bg-blue-600 rounded cursor-pointer shadow-md hover:bg-blue-700">
                + Tambah Barang Masuk
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
                    value="{{ $search }}" placeholder="Cari buku atau kategori...">
            </div>
        </div>
        <div id="dynamic-content">
            <div class="overflow-x-auto rounded-lg shadow-lg dark:bg-gray-800">
                <table class="min-w-full bg-white border-collapse dark:bg-gray-800">
                    <thead class="bg-gray-100">
                        <tr class="text-left bg-gray-200 dark:bg-gray-700">
                            <th class="px-4 py-3 font-semibold border dark:border-gray-600 dark:text-white text-center">Gambar</th>
                            <th class="px-4 py-3 font-semibold border dark:border-gray-600 dark:text-white">Nama Buku</th>
                            <th class="px-4 py-3 font-semibold border dark:border-gray-600 dark:text-white">Kategori</th>
                            <th class="px-4 py-3 font-semibold border dark:border-gray-600 dark:text-white text-center">Stok Sebelum</th>
                            <th class="px-4 py-3 font-semibold border dark:border-gray-600 dark:text-white text-center">Jumlah Masuk</th>
                            <th class="px-4 py-3 font-semibold border dark:border-gray-600 dark:text-white text-center">Stok Setelah</th>
                            <th class="px-4 py-3 font-semibold border dark:border-gray-600 dark:text-white text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 dark:text-gray-200">
                        @forelse($entries as $entry)
                            <tr class="transition-colors border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-4 py-2 text-center border dark:border-gray-700">
                                    <img src="{{ $entry->book->image_url ? Storage::disk('s3')->url($entry->book->image_url) : asset('assets/images/avatar.png') }}"
                                        alt="Gambar Buku" class="object-cover w-12 h-16 mx-auto rounded shadow-sm"
                                        onerror="this.onerror=null;this.src='{{ asset('assets/images/avatar.png') }}';" />
                                </td>
                                <td class="px-4 py-2 border dark:border-gray-700 font-medium">{{ $entry->book->title }}</td>
                                <td class="px-4 py-2 border dark:border-gray-700">{{ $entry->book->category->name ?? '-' }}</td>
                                <td class="px-4 py-2 border dark:border-gray-700 text-center">{{ $entry->stock_before }}</td>
                                <td class="px-4 py-2 border dark:border-gray-700 text-center font-bold text-green-600 dark:text-green-400">+ {{ $entry->stock_in }}</td>
                                <td class="px-4 py-2 border dark:border-gray-700 text-center font-semibold">{{ $entry->stock_after }}</td>
                                <td class="px-4 py-2 border dark:border-gray-700 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" onclick='openEditModal(@json($entry))'
                                            class="px-3 py-1.5 text-xs font-medium text-white transition bg-yellow-500 rounded hover:bg-yellow-600 shadow-sm">
                                            Edit
                                        </button>
                                        <button type="button" onclick="openDeleteModal({{ $entry->id }})"
                                            class="px-3 py-1.5 text-xs font-medium text-white transition bg-red-600 rounded hover:bg-red-700 shadow-sm">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada data barang masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="pagination-links" class="flex flex-col items-center justify-between mt-6 sm:flex-row">
                <div class="mb-4 sm:mb-0">
                    @if ($entries->total() > 0)
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Showing {{ $entries->firstItem() }} to {{ $entries->lastItem() }} of {{ $entries->total() }} entries
                        </p>
                    @endif
                </div>
                <div>
                    @if ($entries->hasPages())
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                            {{-- Previous Page --}}
                            @if ($entries->onFirstPage())
                                <span class="px-3 py-1 mr-1 text-gray-400 bg-white border border-gray-300 rounded cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500">Prev</span>
                            @else
                                <a href="{{ $entries->previousPageUrl() }}" rel="prev" class="px-3 py-1 mr-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">Prev</a>
                            @endif

                            @php
                                $currentPage = $entries->currentPage();
                                $lastPage = $entries->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            @endphp

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $currentPage)
                                    <span class="px-3 py-1 mr-1 text-white bg-blue-600 border border-blue-600 rounded dark:bg-blue-600 dark:border-blue-600">{{ $i }}</span>
                                @else
                                    <a href="{{ $entries->url($i) }}" class="px-3 py-1 mr-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">{{ $i }}</a>
                                @endif
                            @endfor

                            {{-- Next Page --}}
                            @if ($entries->hasMorePages())
                                <a href="{{ $entries->nextPageUrl() }}" rel="next" class="px-3 py-1 ml-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">Next</a>
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
        const purchaseStockMap = @json($purchaseStockMap);
    </script>

    <script>
        // =========================================================
        // 1. ENGINE SPA (PREFETCH, CACHE, & REAL-TIME SEARCH)
        // =========================================================
        const pageCache = {};
        let currentAbortController = null;
        let debounceTimer;

        function handleSearch() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetchData();
            }, 100);
        }

        function fetchData(targetUrl = null) {
            if (typeof targetUrl !== 'string') targetUrl = null;

            const search = document.getElementById('search').value;
            const perPage = document.getElementById('per_page').value;

            let urlString = targetUrl || `{{ route('entry_books.index') }}`;
            const urlObj = new URL(urlString, window.location.origin);

            if (window.location.protocol === 'https:') {
                urlObj.protocol = 'https:';
            }

            urlObj.searchParams.set('search', search);
            urlObj.searchParams.set('per_page', perPage);

            const finalUrl = urlObj.toString();

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

        document.addEventListener('click', function(e) {
            const link = e.target.closest('#pagination-links a');
            if (link) {
                e.preventDefault();
                fetchData(link.href);
            }
        });

        window.addEventListener('popstate', function(e) {
            if (e.state && e.state.path) {
                fetchData(e.state.path);
            } else {
                fetchData(window.location.href);
            }
        });


        // =========================================================
        // 2. SWEETALERT MODALS LOGIC (ENTRY BOOKS)
        // =========================================================
        const isDark = () => document.documentElement.classList.contains('dark');
        const swalBg = () => isDark() ? '#1f2937' : '#ffffff';
        const swalText = () => isDark() ? '#ffffff' : '#374151';

        // --- Helper: Build Options untuk Pilih Buku ---
        function buildBookSelect(selectedId = '') {
            let options = '<option value="">-- Pilih Buku --</option>';
            @foreach ($books as $book)
                options += `<option value="{{ $book->id }}" ${selectedId == {{ $book->id }} ? 'selected' : ''}>{{ addslashes($book->title) }}</option>`;
            @endforeach
            return options;
        }

        // ADD MODAL
        function openCreateModal() {
            Swal.fire({
                title: 'Tambah Barang Masuk',
                background: swalBg(),
                color: swalText(),
                html: `
                    <form id="createForm" action="{{ route('entry_books.store') }}" method="POST" class="text-left text-sm space-y-4">
                        @csrf
                        <div>
                            <label class="block mb-1 font-medium">Pilih Buku</label>
                            <select id="swalBookSelect" name="book_id" required class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500">
                                ${buildBookSelect()}
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Jumlah Stok Masuk</label>
                            <input type="number" id="swalStockIn" name="stock_in" required min="1" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" placeholder="Masukkan jumlah..." />
                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maksimal: <span id="swalMaxStock" class="font-bold">0</span></div>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#2563eb', // Blue-600
                cancelButtonColor: '#6b7280',
                didOpen: () => {
                    // MENGGANTIKAN x-watch ALPINE: Mengawasi perubahan select buku di dalam SweetAlert
                    const bookSelect = document.getElementById('swalBookSelect');
                    const stockInput = document.getElementById('swalStockIn');
                    const maxStockLabel = document.getElementById('swalMaxStock');

                    bookSelect.addEventListener('change', function() {
                        const bookId = this.value;
                        const maxStock = purchaseStockMap[bookId] ?? 0; // Ambil dari variabel map global

                        maxStockLabel.innerText = maxStock;
                        stockInput.max = maxStock;
                        stockInput.placeholder = `Maksimal ${maxStock}`;
                        stockInput.value = ''; // Reset nilai jika buku diganti
                    });
                },
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

        // EDIT MODAL (Menggunakan JSON Injection)
        function openEditModal(entry) {
            const maxStock = purchaseStockMap[entry.book_id] ?? 0;

            Swal.fire({
                title: 'Ubah Barang Masuk',
                background: swalBg(),
                color: swalText(),
                html: `
                    <form id="editForm" action="/admin/entry-books/${entry.id}" method="POST" class="text-left text-sm space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block mb-1 font-medium">Buku (Tidak dapat diubah)</label>
                            <select name="book_id" disabled class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-500 cursor-not-allowed dark:bg-gray-800 dark:border-gray-600">
                                ${buildBookSelect(entry.book_id)}
                            </select>
                            <input type="hidden" name="book_id" value="${entry.book_id}">
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Jumlah Stok Masuk</label>
                            <input type="number" name="stock_in" value="${entry.stock_in}" required min="1" max="${maxStock}" class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" />
                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maksimal: <span class="font-bold">${maxStock}</span></div>
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
        function openDeleteModal(entryId) {
            Swal.fire({
                title: 'Hapus Barang Masuk?',
                text: "Yakin ingin menghapus catatan barang masuk ini? Stok buku akan disesuaikan kembali.",
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
                    form.action = `/admin/entry-books/${entryId}`;
                    form.submit();
                }
            });
        }
    </script>
@endsection
