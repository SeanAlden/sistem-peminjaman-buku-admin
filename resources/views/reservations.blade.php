{{-- @extends('layouts.app')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <h1 class="mb-6 text-3xl font-bold text-gray-800 dark:text-white">
            @if(Auth::user()->usertype === 'admin')
                Daftar Reservasi Pengguna
            @else
                Reservasi Buku Saya
            @endif
        </h1>

        @if (session('success'))
            <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="px-4 py-3 mb-6 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Fitur Search dan Items per Page -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <form action="{{ route('reservations.index') }}" method="GET" class="flex items-center">
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
                <form action="{{ route('reservations.index') }}" method="GET" class="flex items-center">
                    <label for="search" class="mr-2 text-sm text-gray-600 dark:text-gray-300">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>
        <!-- End Fitur -->

        <div class="overflow-hidden bg-white rounded-lg shadow-md">
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wider text-left text-gray-600 uppercase border-b-2 border-gray-200 bg-gray-50 dark:bg-gray-500">
                            @if(Auth::user()->usertype === 'admin')
                                <th class="px-5 py-3 dark:text-white">Pengguna</th>
                            @endif
                            <th class="px-5 py-3 dark:text-white">Email Pengguna</th>
                            <th class="px-5 py-3 dark:text-white">Judul Buku</th>
                            <th class="px-5 py-3 dark:text-white">Tanggal Reservasi</th>
                            <th class="px-5 py-3 dark:text-white">Status</th>
                            <th class="px-5 py-3 dark:text-white">Posisi Antrian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reservations as $reservation)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-500 dark:bg-gray-400">
                                @if(Auth::user()->usertype === 'admin')
                                    <td class="px-5 py-5 text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap dark:text-white">{{ $reservation->user->name }}</p>
                                    </td>
                                    <td class="px-5 py-5 text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap dark:text-white">{{ $reservation->user->email }}</p>
                                    </td>
                                @endif
                                <td class="px-5 py-5 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap dark:text-white">{{ $reservation->book->title }}</p>
                                    <p class="text-xs text-gray-600 whitespace-no-wrap dark:text-gray-300">{{ $reservation->book->author }}</p>
                                </td>
                                <td class="px-5 py-5 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap dark:text-white">
                                        {{ $reservation->created_at->format('d M Y, H:i') }}
                                    </p>
                                </td>
                                <td class="px-5 py-5 text-sm">
                                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight
                                                @if($reservation->status == 'pending') text-yellow-900 bg-yellow-200
                                                @elseif($reservation->status == 'available') text-green-900 bg-green-200
                                                @elseif($reservation->status == 'completed') text-blue-900 bg-blue-200
                                                @else text-red-900 bg-red-200 @endif
                                                                rounded-full">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-5 text-sm text-center">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{ $reservation->status == 'pending' ? $reservation->queue_position : '-' }}
                                    </p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->usertype === 'admin' ? '7' : '6' }}"
                                    class="px-5 py-10 text-center text-gray-500">
                                    Tidak ada data reservasi yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Fitur Pagination -->
        <div class="flex items-center justify-between mt-4">
            <div>
                @if ($reservations->total() > 0)
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        Showing {{ $reservations->firstItem() }} to {{ $reservations->lastItem() }} of
                        {{ $reservations->total() }}
                        entries
                    </p>
                @endif
            </div>
            <div>
                @if ($reservations->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                        @if ($reservations->onFirstPage())
                            <span class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                        @else
                            <a href="{{ $reservations->previousPageUrl() }}" rel="prev"
                                class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                        @endif

                        @php
                            $currentPage = $reservations->currentPage();
                            $lastPage = $reservations->lastPage();
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
                                <a href="{{ $reservations->url($link) }}"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                            @endif
                        @endforeach

                        @if ($reservations->hasMorePages())
                            <a href="{{ $reservations->nextPageUrl() }}" rel="next"
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
    <div class="container px-4 py-8 mx-auto min-h-screen">
        {{-- Judul dinamis berdasarkan peran --}}
        <h1 class="mb-6 text-3xl font-bold text-gray-800 dark:text-white">
            @if(Auth::user()->usertype === 'admin')
                Daftar Reservasi Pengguna
            @else
                Reservasi Buku Saya
            @endif
        </h1>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div id="success-alert" class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded transition-opacity duration-500" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
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
            <div id="error-alert" class="px-4 py-3 mb-6 text-red-700 bg-red-100 border border-red-400 rounded transition-opacity duration-500" role="alert">
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
                <label for="per_page" class="mr-2 text-sm text-gray-600 dark:text-gray-300">Show:</label>
                <select id="per_page" onchange="fetchData()"
                    class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:w-auto">
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
                    class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:w-64"
                    value="{{ $search }}" placeholder="Search...">
            </div>
        </div>

        <div id="dynamic-content">
            <div class="overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal border-collapse dark:border-gray-700">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wider text-left text-gray-600 uppercase border-b-2 border-gray-200 bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                                @if(Auth::user()->usertype === 'admin')
                                    <th class="px-5 py-3">Pengguna</th>
                                    <th class="px-5 py-3">Email Pengguna</th>
                                @endif
                                <th class="px-5 py-3">Judul Buku</th>
                                <th class="px-5 py-3">Tanggal Reservasi</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3 text-center">Posisi Antrian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($reservations as $reservation)
                                <tr class="transition-colors hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    @if(Auth::user()->usertype === 'admin')
                                        <td class="px-5 py-4 text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap dark:text-gray-200">{{ $reservation->user->name ?? 'Unknown' }}</p>
                                        </td>
                                        <td class="px-5 py-4 text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap dark:text-gray-200">{{ $reservation->user->email ?? '-' }}</p>
                                        </td>
                                    @endif
                                    <td class="px-5 py-4 text-sm">
                                        <p class="font-medium text-gray-900 whitespace-no-wrap dark:text-gray-100">{{ $reservation->book->title }}</p>
                                        <p class="text-xs text-gray-500 whitespace-no-wrap dark:text-gray-400">{{ $reservation->book->author }}</p>
                                    </td>
                                    <td class="px-5 py-4 text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap dark:text-gray-200">
                                            {{ $reservation->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-4 text-sm">
                                        <span class="relative inline-block px-3 py-1 font-semibold leading-tight text-center rounded-full
                                                    @if($reservation->status == 'pending') text-yellow-800 bg-yellow-100 dark:text-yellow-300 dark:bg-yellow-900
                                                    @elseif($reservation->status == 'available') text-green-800 bg-green-100 dark:text-green-300 dark:bg-green-900
                                                    @elseif($reservation->status == 'completed') text-blue-800 bg-blue-100 dark:text-blue-300 dark:bg-blue-900
                                                    @else text-red-800 bg-red-100 dark:text-red-300 dark:bg-red-900 @endif">
                                            {{ ucfirst($reservation->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-sm text-center">
                                        @if($reservation->status == 'pending')
                                            <span class="inline-flex items-center justify-center w-8 h-8 font-bold text-indigo-700 bg-indigo-100 rounded-full dark:bg-indigo-900 dark:text-indigo-300">
                                                {{ $reservation->queue_position }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ Auth::user()->usertype === 'admin' ? '6' : '4' }}" class="px-5 py-10 text-center text-gray-500 dark:text-gray-400">
                                        Tidak ada data reservasi yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="pagination-links" class="flex flex-col items-center justify-between mt-6 sm:flex-row">
                <div class="mb-4 sm:mb-0">
                    @if ($reservations->total() > 0)
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Showing {{ $reservations->firstItem() }} to {{ $reservations->lastItem() }} of {{ $reservations->total() }} entries
                        </p>
                    @endif
                </div>
                <div>
                    @if ($reservations->hasPages())
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                            @if ($reservations->onFirstPage())
                                <span class="px-3 py-1 mr-1 text-gray-400 bg-white border border-gray-300 rounded cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500">Prev</span>
                            @else
                                <a href="{{ $reservations->previousPageUrl() }}" rel="prev" class="px-3 py-1 mr-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">Prev</a>
                            @endif

                            @php
                                $currentPage = $reservations->currentPage();
                                $lastPage = $reservations->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            @endphp

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $currentPage)
                                    <span class="px-3 py-1 mr-1 text-white bg-blue-600 border border-blue-600 rounded dark:bg-blue-600 dark:border-blue-600">{{ $i }}</span>
                                @else
                                    <a href="{{ $reservations->url($i) }}" class="px-3 py-1 mr-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">{{ $i }}</a>
                                @endif
                            @endfor

                            @if ($reservations->hasMorePages())
                                <a href="{{ $reservations->nextPageUrl() }}" rel="next" class="px-3 py-1 ml-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">Next</a>
                            @else
                                <span class="px-3 py-1 ml-1 text-gray-400 bg-white border border-gray-300 rounded cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500">Next</span>
                            @endif
                        </nav>
                    @endif
                </div>
            </div>
        </div>
        </div>
@endsection

@section('scripts')
    <script>
        // =========================================================
        // ENGINE SPA (PREFETCH, CACHE, & REAL-TIME SEARCH)
        // =========================================================
        const pageCache = {};
        let currentAbortController = null;
        let debounceTimer;

        // Fungsi Debounce untuk Pengetikan Pencarian (100ms super ringan)
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

            let urlString = targetUrl || `{{ route('reservations.index') }}`;
            const urlObj = new URL(urlString, window.location.origin);

            // Fix Vercel HTTPS Protocol Error
            if (window.location.protocol === 'https:') {
                urlObj.protocol = 'https:';
            }

            urlObj.searchParams.set('search', search);
            urlObj.searchParams.set('per_page', perPage);

            const finalUrl = urlObj.toString();

            // Cek Cache untuk memuat seketika tanpa nembak server (0ms Delay)
            if (pageCache[finalUrl]) {
                renderDOM(pageCache[finalUrl]);
                window.history.pushState({ path: finalUrl }, '', finalUrl);
                return;
            }

            // Batalkan request usang jika user mengetik super cepat
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
    </script>
@endsection
