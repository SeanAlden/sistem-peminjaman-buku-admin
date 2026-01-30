@extends('layouts.app')

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

        {{-- <div class="mt-4">
            {{ $loans->links() }}
        </div> --}}

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
@endsection
