{{-- @extends('layouts.app')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <h1 class="mb-6 text-3xl font-bold text-gray-800 dark:text-white">📖 Daftar Peminjaman</h1>

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
                <form action="{{ route('loans.index') }}" method="GET" class="flex items-center">
                    <label for="per_page" class="mr-2 text-sm text-gray-600 dark:text-white">Show:</label>
                    <select name="per_page" id="per_page"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
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
                <form action="{{ route('loans.index') }}" method="GET" class="flex items-center">
                    <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>

        <div class="overflow-x-auto rounded shadow-lg">
            <table class="min-w-full bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-sm font-medium text-left text-gray-700 dark:text-gray-300">Buku</th>
                        <th class="px-6 py-3 text-sm font-medium text-left text-gray-700 dark:text-gray-300">Peminjam</th>
                        <th class="px-6 py-3 text-sm font-medium text-left text-gray-700 dark:text-gray-300">Tgl. Pinjam
                        </th>
                        <th class="px-6 py-3 text-sm font-medium text-left text-gray-700 dark:text-gray-300">Tgl. Kembali
                        </th>
                        <th class="px-6 py-3 text-sm font-medium text-center text-gray-700 dark:text-gray-300">Status</th>
                        <th class="px-6 py-3 text-sm font-medium text-center text-gray-700 dark:text-gray-300">Catatan</th>
                        <th class="px-6 py-3 text-sm font-medium text-left text-gray-700 dark:text-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($loans as $loan)
                        <tr class="transition duration-300 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 font-semibold dark:text-white">{{ $loan->book->title }}</td>
                            <td class="px-6 py-4 dark:text-white">{{ $loan->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 dark:text-white">{{ $loan->loan_date->format('d M Y') }}</td>
                            <td class="px-6 py-4 dark:text-white">
                                {{ $loan->actual_returned_at ? $loan->actual_returned_at->format('d M Y') : '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                @if ($loan->status === 'returned')
                                    <span
                                        class="inline-block px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">
                                        Dikembalikan
                                    </span>
                                @elseif ($loan->status === 'pending_return')
                                    <span
                                        class="inline-block px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                        Menunggu Konfirmasi
                                    </span>
                                @else
                                    <span
                                        class="inline-block px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
                                        Dipinjam
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 dark:text-white">{{ $loan->return_status_note ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if ($loan->status === 'pending_return')
                                    <form action="{{ route('loans.confirmReturn', $loan->id) }}" method="POST"
                                        onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1 text-sm font-medium text-white bg-green-600 rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            Confirm
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('loans.show', $loan->id) }}"
                                        class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Detail</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Fitur Pagination -->
        <div class="flex items-center justify-between mt-4">
            <div>
                @if ($loans->total() > 0)
                    <p class="text-sm text-gray-700 dark:text-white">
                        Showing {{ $loans->firstItem() }} to {{ $loans->lastItem() }} of {{ $loans->total() }}
                        entries
                    </p>
                @endif
            </div>
            <div>
                @if ($loans->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                        @if ($loans->onFirstPage())
                            <span
                                class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                        @else
                            <a href="{{ $loans->previousPageUrl() }}" rel="prev"
                                class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                        @endif

                        @php
                            $currentPage = $loans->currentPage();
                            $lastPage = $loans->lastPage();
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
                                <span
                                    class="px-3 py-1 mr-1 text-white bg-blue-500 border border-blue-500 rounded">{{ $link }}</span>
                            @else
                                <a href="{{ $loans->url($link) }}"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                            @endif
                        @endforeach

                        @if ($loans->hasMorePages())
                            <a href="{{ $loans->nextPageUrl() }}" rel="next"
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
    <div class="container px-4 py-8 mx-auto">
        <h1 class="mb-6 text-3xl font-bold text-gray-800 dark:text-white">📖 Daftar Peminjaman</h1>

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
                <label for="per_page" class="mr-2 text-sm text-gray-600 dark:text-white">Show:</label>
                <select id="per_page" onchange="fetchData()"
                    class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
            <div class="flex items-center">
                <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                <input type="text" id="search" oninput="handleSearch()"
                    class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                    value="{{ $search }}" placeholder="Cari buku/peminjam...">
            </div>
        </div>

        <div id="dynamic-content">
            <div class="overflow-x-auto rounded shadow-lg">
                <table class="min-w-full bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-sm font-medium text-center text-gray-700 dark:text-gray-300">Cover</th>
                            <th class="px-6 py-3 text-sm font-medium text-left text-gray-700 dark:text-gray-300">Buku</th>
                            <th class="px-6 py-3 text-sm font-medium text-left text-gray-700 dark:text-gray-300">Peminjam</th>
                            <th class="px-6 py-3 text-sm font-medium text-left text-gray-700 dark:text-gray-300">Tgl. Pinjam</th>
                            <th class="px-6 py-3 text-sm font-medium text-left text-gray-700 dark:text-gray-300">Tgl. Kembali</th>
                            <th class="px-6 py-3 text-sm font-medium text-center text-gray-700 dark:text-gray-300">Status</th>
                            <th class="px-6 py-3 text-sm font-medium text-center text-gray-700 dark:text-gray-300">Catatan</th>
                            <th class="px-6 py-3 text-sm font-medium text-left text-gray-700 dark:text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($loans as $loan)
                            <tr class="transition duration-300 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4 text-center">
                                    <img src="{{ $loan->book->image_url ? Storage::disk('s3')->url($loan->book->image_url) : asset('assets/images/avatar.png') }}"
                                         alt="Cover Buku"
                                         class="object-contain w-12 h-16 mx-auto rounded shadow-sm"
                                         onerror="this.onerror=null;this.src='{{ asset('assets/images/avatar.png') }}';">
                                </td>
                                <td class="px-6 py-4 font-semibold dark:text-white">{{ $loan->book->title }}</td>
                                <td class="px-6 py-4 dark:text-white">{{ $loan->user->name ?? '-' }}</td>
                                <td class="px-6 py-4 dark:text-white">{{ $loan->loan_date->format('d M Y') }}</td>
                                <td class="px-6 py-4 dark:text-white">
                                    {{ $loan->actual_returned_at ? $loan->actual_returned_at->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($loan->status === 'returned')
                                        <span class="inline-block px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">
                                            Dikembalikan
                                        </span>
                                    @elseif ($loan->status === 'pending_return')
                                        <span class="inline-block px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                            Menunggu Konfirmasi
                                        </span>
                                    @else
                                        <span class="inline-block px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
                                            Dipinjam
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 dark:text-white text-center">{{ $loan->return_status_note ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @if ($loan->status === 'pending_return')
                                            <button type="button" onclick="openConfirmModal({{ $loan->id }})"
                                                class="px-3 py-1 text-sm font-medium text-white bg-green-600 rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                Confirm
                                            </button>
                                        @else
                                            <a href="{{ route('loans.show', $loan->id) }}"
                                                class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Detail</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-10 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="pagination-links" class="flex items-center justify-between mt-4">
                <div>
                    @if ($loans->total() > 0)
                        <p class="text-sm text-gray-700 dark:text-white">
                            Showing {{ $loans->firstItem() }} to {{ $loans->lastItem() }} of {{ $loans->total() }} entries
                        </p>
                    @endif
                </div>
                <div>
                    @if ($loans->hasPages())
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                            @if ($loans->onFirstPage())
                                <span class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                            @else
                                <a href="{{ $loans->previousPageUrl() }}" rel="prev" class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                            @endif

                            @php
                                $currentPage = $loans->currentPage();
                                $lastPage = $loans->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            @endphp

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $currentPage)
                                    <span class="px-3 py-1 mr-1 text-white bg-blue-500 border border-blue-500 rounded">{{ $i }}</span>
                                @else
                                    <a href="{{ $loans->url($i) }}" class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $i }}</a>
                                @endif
                            @endfor

                            @if ($loans->hasMorePages())
                                <a href="{{ $loans->nextPageUrl() }}" rel="next" class="px-3 py-1 ml-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Next</a>
                            @else
                                <span class="px-3 py-1 ml-1 text-gray-400 bg-white border rounded cursor-not-allowed">Next</span>
                            @endif
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form id="globalConfirmForm" method="POST" style="display: none;">
        @csrf
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

        // Debounce pencarian
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

            let urlString = targetUrl || `{{ route('loans.index') }}`;
            const urlObj = new URL(urlString, window.location.origin);

            // Fix Vercel HTTPS Protocol
            if (window.location.protocol === 'https:') {
                urlObj.protocol = 'https:';
            }

            urlObj.searchParams.set('search', search);
            urlObj.searchParams.set('per_page', perPage);

            const finalUrl = urlObj.toString();

            // Cache Render (0ms Delay)
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

        // INTENT PREDICTION (Hover fetch)
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
        // 2. SWEETALERT LOGIC (Konfirmasi Pengembalian)
        // =========================================================
        const isDark = () => document.documentElement.classList.contains('dark');
        const swalBg = () => isDark() ? '#1f2937' : '#ffffff';
        const swalText = () => isDark() ? '#ffffff' : '#374151';

        function openConfirmModal(loanId) {
            Swal.fire({
                title: 'Konfirmasi Pengembalian?',
                text: "Apakah Anda yakin buku ini sudah diterima dan ingin menyelesaikan peminjaman?",
                icon: 'question',
                background: swalBg(),
                color: swalText(),
                showCancelButton: true,
                confirmButtonColor: '#16a34a', // Green-600
                cancelButtonColor: '#6b7280',  // Gray-500
                confirmButtonText: 'Ya, Konfirmasi',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('globalConfirmForm');
                    // Ganti URL target form ke route confirmReturn
                    const baseAction = "{{ route('loans.confirmReturn', 'ID_PLACEHOLDER') }}";
                    form.action = baseAction.replace('ID_PLACEHOLDER', loanId);
                    form.submit();
                }
            });
        }
    </script>
@endsection
