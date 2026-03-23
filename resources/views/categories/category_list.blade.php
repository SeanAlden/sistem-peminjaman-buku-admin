{{-- @extends('layouts.app')

@section('content')
    <div x-data="{
        showAddModal: false,
        showEditModal: false,
        editCategory: {}, // Untuk menyimpan data kategori yang akan diedit
        editFormUrl: '' // Untuk menyimpan URL action form edit
    }" class="container px-4 py-8 mx-auto sm:px-6 lg:px-8">

        <div class="flex flex-col items-center justify-between gap-4 mb-6 sm:flex-row">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-300">📚 Daftar Kategori</h1>

            <button @click="showAddModal = true"
                class="inline-block px-6 py-2 font-medium text-white transition duration-300 bg-green-600 rounded-lg shadow hover:bg-green-700">
                + Tambah Kategori
            </button>
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

        <!-- Fitur Search dan Items per Page -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <form action="{{ route('categories.index') }}" method="GET" class="flex items-center">
                    <label for="per_page" class="mr-2 text-sm text-gray-600 dark:text-gray-300">Show:</label>
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
                <form action="{{ route('categories.index') }}" method="GET" class="flex items-center">
                    <label for="search" class="mr-2 text-sm text-gray-600 dark:text-gray-300">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>
        <!-- End Fitur -->

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full bg-white divide-y divide-gray-200 dark:bg-gray-500">
                <thead class="bg-gray-100 dark:bg-gray-300">
                    <tr>
                        <th class="px-6 py-3 text-sm font-semibold text-left text-gray-700">Nama</th>
                        <th class="px-6 py-3 text-sm font-semibold text-left text-gray-700">Deskripsi</th>
                        <th class="px-6 py-3 text-sm font-semibold text-left text-gray-700">Buku dalam Kategori</th>
                        <th class="px-6 py-3 text-sm font-semibold text-left text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td
                                class="px-6 py-4 text-sm font-medium text-blue-600 whitespace-nowrap dark:text-blue-300 hover:underline">
                                <a href="{{ route('categories.show', $category->id) }}">
                                    {{ $category->name }}
                                </a>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-white">
                                {{ \Illuminate\Support\Str::limit($category->description, 20, '...') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-white">
                                @if ($category->books->count())
                                    <ul class="space-y-1 list-disc list-inside">
                                        @foreach ($category->books as $book)
                                            <li>{{ $book->title }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="italic text-gray-400">Tidak ada buku</span>
                                @endif
                            </td>

                            <td class="flex items-center gap-4 px-6 py-4 text-sm">
                                <button
                                    @click="
                                                            fetch('{{ route('categories.edit', $category->id) }}')
                                                                .then(response => response.json())
                                                                .then(data => {
                                                                    editCategory = data;
                                                                    editFormUrl = '{{ route('categories.update', $category->id) }}';
                                                                    showEditModal = true;
                                                                })
                                                        "
                                    class="font-medium text-blue-600 transition hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">Edit</button>

                                @if ($category->books->count() === 0)
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="font-medium text-red-600 transition hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                                    </form>
                                @else
                                    <button class="font-medium text-gray-400 cursor-not-allowed dark:text-gray-500"
                                        disabled>Hapus</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 italic text-center text-gray-500">
                                Tidak ada kategori tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Fitur Pagination -->
        <div class="flex items-center justify-between mt-4">
            <div>
                @if ($categories->total() > 0)
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of
                        {{ $categories->total() }}
                        entries
                    </p>
                @endif
            </div>
            <div>
                @if ($categories->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                        @if ($categories->onFirstPage())
                            <span
                                class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                        @else
                            <a href="{{ $categories->previousPageUrl() }}" rel="prev"
                                class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                        @endif

                        @php
                            $currentPage = $categories->currentPage();
                            $lastPage = $categories->lastPage();
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
                                <a href="{{ $categories->url($link) }}"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                            @endif
                        @endforeach

                        @if ($categories->hasMorePages())
                            <a href="{{ $categories->nextPageUrl() }}" rel="next"
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

        <div x-show="showAddModal" @keydown.escape.window="showAddModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-auto"
            style="background-color: rgba(0, 0, 0, 0.5);">
            <div @click.away="showAddModal = false"
                class="w-full max-w-lg p-6 mx-4 bg-white rounded-lg shadow-xl dark:bg-gray-800">
                <h2 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200">Tambah Kategori Baru</h2>
                <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name_add" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Nama</label>
                        <input id="name_add" type="text" name="name"
                            class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                            required>
                    </div>
                    <div>
                        <label for="description_add"
                            class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                        <textarea id="description_add" name="description"
                            class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required></textarea>
                    </div>
                    <div class="flex justify-end pt-4 space-x-2">
                        <button type="button" @click="showAddModal = false"
                            class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 font-medium text-white bg-green-600 rounded hover:bg-green-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="showEditModal" @keydown.escape.window="showEditModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-auto"
            style="background-color: rgba(0, 0, 0, 0.5);">
            <div @click.away="showEditModal = false"
                class="w-full max-w-lg p-6 mx-4 bg-white rounded-lg shadow-xl dark:bg-gray-800">
                <h2 class="mb-4 text-2xl font-bold text-gray-800 dark:text-gray-200">Edit Kategori</h2>
                <form :action="editFormUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="name_edit"
                            class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Nama</label>
                        <input id="name_edit" type="text" name="name" x-model="editCategory.name"
                            class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                            required>
                    </div>
                    <div>
                        <label for="description_edit"
                            class="block mb-1 font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                        <textarea id="description_edit" name="description" x-model="editCategory.description"
                            class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required></textarea>
                    </div>
                    <div class="flex justify-end pt-4 space-x-2">
                        <button type="button" @click="showEditModal = false"
                            class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 font-medium text-white bg-blue-600 rounded hover:bg-blue-700">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection --}}

@extends('layouts.app')

@section('content')
    {{-- Alpine x-data untuk modal sudah dihapus karena kita pakai SweetAlert murni --}}
    <div class="container px-4 py-8 mx-auto sm:px-6 lg:px-8">

        <div class="flex flex-col items-center justify-between gap-4 mb-6 sm:flex-row">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-300">📚 Daftar Kategori</h1>

            {{-- Tombol Tambah Kategori memanggil fungsi JS SweetAlert --}}
            <button onclick="openCreateModal()"
                class="inline-block px-6 py-2 font-medium text-white transition duration-300 bg-green-600 rounded-lg shadow hover:bg-green-700">
                + Tambah Kategori
            </button>
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

        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <label for="per_page" class="mr-2 text-sm text-gray-600 dark:text-gray-300">Show:</label>
                {{-- Hapus form, gunakan onchange --}}
                <select id="per_page" onchange="fetchData()"
                    class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
            <div class="flex items-center">
                <label for="search" class="mr-2 text-sm text-gray-600 dark:text-gray-300">Search:</label>
                {{-- Hapus form, gunakan oninput untuk real-time --}}
                <input type="text" id="search" oninput="handleSearch()"
                    class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ $search }}" placeholder="Cari kategori...">
            </div>
        </div>
        <div id="dynamic-content">
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="min-w-full bg-white divide-y divide-gray-200 dark:bg-gray-500">
                    <thead class="bg-gray-100 dark:bg-gray-300">
                        <tr>
                            <th class="px-6 py-3 text-sm font-semibold text-left text-gray-700">Nama</th>
                            <th class="px-6 py-3 text-sm font-semibold text-left text-gray-700">Deskripsi</th>
                            <th class="px-6 py-3 text-sm font-semibold text-left text-gray-700">Buku dalam Kategori</th>
                            <th class="px-6 py-3 text-sm font-semibold text-left text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td
                                    class="px-6 py-4 text-sm font-medium text-blue-600 whitespace-nowrap dark:text-blue-300 hover:underline">
                                    <a href="{{ route('categories.show', $category->id) }}">
                                        {{ $category->name }}
                                    </a>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-white">
                                    {{ \Illuminate\Support\Str::limit($category->description, 30, '...') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-white">
                                    @if ($category->books->count())
                                        <ul class="space-y-1 list-disc list-inside">
                                            @foreach ($category->books as $book)
                                                <li>{{ $book->title }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="italic text-gray-400 dark:text-gray-300">Tidak ada buku</span>
                                    @endif
                                </td>

                                <td class="flex items-center gap-4 px-6 py-4 text-sm">
                                    {{-- Menggunakan @json langsung untuk efisiensi ekstrim tanpa fetch API --}}
                                    <button onclick='openEditModal(@json($category))'
                                        class="font-medium text-blue-600 transition hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        Edit
                                    </button>

                                    @if ($category->books->count() === 0)
                                        <button type="button" onclick="openDeleteModal({{ $category->id }})"
                                            class="font-medium text-red-600 transition hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                            Hapus
                                        </button>
                                    @else
                                        <button class="font-medium text-gray-400 cursor-not-allowed dark:text-gray-500" disabled
                                            title="Kategori memiliki buku, tidak bisa dihapus">
                                            Hapus
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 italic text-center text-gray-500 dark:text-gray-300">
                                    Tidak ada kategori tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="pagination-links" class="flex items-center justify-between mt-4">
                <div>
                    @if ($categories->total() > 0)
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of
                            {{ $categories->total() }} entries
                        </p>
                    @endif
                </div>
                <div>
                    @if ($categories->hasPages())
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                            @if ($categories->onFirstPage())
                                <span class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                            @else
                                <a href="{{ $categories->previousPageUrl() }}" rel="prev"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                            @endif

                            @php
                                $currentPage = $categories->currentPage();
                                $lastPage = $categories->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            @endphp

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $currentPage)
                                    <span class="px-3 py-1 mr-1 text-white bg-blue-500 border border-blue-500 rounded">{{ $i }}</span>
                                @else
                                    <a href="{{ $categories->url($i) }}"
                                        class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $i }}</a>
                                @endif
                            @endfor

                            @if ($categories->hasMorePages())
                                <a href="{{ $categories->nextPageUrl() }}" rel="next"
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

            // Route disesuaikan dengan categories.index
            let urlString = targetUrl || `{{ route('categories.index') }}`;
            const urlObj = new URL(urlString, window.location.origin);

            // Paksa HTTPS untuk Vercel
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

        // ADD MODAL
        function openCreateModal() {
            Swal.fire({
                title: 'Tambah Kategori Baru',
                background: swalBg(),
                color: swalText(),
                html: `
                        <form id="createForm" action="{{ route('categories.store') }}" method="POST" class="text-left text-sm space-y-4">
                            @csrf
                            <div>
                                <label class="block mb-1 font-medium">Nama Kategori</label>
                                <input name="name" required class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Contoh: Fiksi, Sains..." />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Deskripsi</label>
                                <textarea name="description" rows="3" required class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Deskripsi singkat..."></textarea>
                            </div>
                        </form>
                    `,
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#16a34a', // Green-600
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

        // EDIT MODAL
        function openEditModal(category) {
            Swal.fire({
                title: 'Edit Kategori',
                background: swalBg(),
                color: swalText(),
                html: `
                        <form id="editForm" action="/admin/categories/${category.id}" method="POST" class="text-left text-sm space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block mb-1 font-medium">Nama Kategori</label>
                                <input name="name" value="${category.name}" required class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Deskripsi</label>
                                <textarea name="description" rows="3" required class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white">${category.description || ''}</textarea>
                            </div>
                        </form>
                    `,
                showCancelButton: true,
                confirmButtonText: 'Perbarui',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#2563eb', // Blue-600
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
        function openDeleteModal(categoryId) {
            Swal.fire({
                title: 'Hapus Kategori?',
                text: "Kategori ini akan dihapus permanen dari sistem.",
                icon: 'warning',
                background: swalBg(),
                color: swalText(),
                showCancelButton: true,
                confirmButtonColor: '#dc2626', // Red
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('globalDeleteForm');
                    form.action = `/admin/categories/${categoryId}`;
                    form.submit();
                }
            });
        }
    </script>
@endsection
