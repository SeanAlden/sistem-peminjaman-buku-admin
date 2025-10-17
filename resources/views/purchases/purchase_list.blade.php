@extends('layouts.app')

@section('content')
    <div class="container px-4 mx-auto">
        <h1 class="mb-6 text-3xl font-bold text-gray-800 dark:text-white">📦 Daftar Pengadaan</h1>

        {{-- Bagian Tombol Tambah, Notifikasi, dan Filter tidak berubah --}}
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

        @if(session('success'))
            <div class="px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-4">
            {{-- Form Per Page --}}
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
            {{-- Form Search --}}
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
                        {{-- PERUBAHAN 1: Menambahkan kolom baru untuk total --}}
                        <th class="px-4 py-3 text-center bg-gray-300 border dark:bg-gray-700 dark:text-white">Total Pengadaan (Buku Ini)</th>
                        <th class="px-4 py-3 border dark:text-white">Total Harga</th>
                        <th class="px-4 py-3 border dark:text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    {{-- PERUBAHAN 2: Inisialisasi variabel untuk melacak grup buku --}}
                    @php $currentBookId = null; @endphp

                    @forelse($purchases as $purchase)
                        {{-- Menambahkan garis pemisah antar grup buku --}}
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
                                    $percentage = ($purchase->initial_quantity > 0) ? ($purchase->quantity / $purchase->initial_quantity) * 100 : 0;
                                @endphp
                                <div class="w-full h-2 mt-1 bg-gray-200 rounded-full">
                                    <div class="h-2 bg-blue-600 rounded-full" style="width: {{ $percentage }}%;"></div>
                                </div>
                            </td>

                            {{-- PERUBAHAN 3: Logika untuk menampilkan total hanya sekali per grup --}}
                            @if ($purchase->book_id !== $currentBookId)
                                <td class="px-4 py-2 text-lg font-bold text-center align-middle border bg-gray-50 dark:bg-gray-400 dark:text-white"
                                    rowspan="{{ $purchases->where('book_id', $purchase->book_id)->count() }}">
                                    {{ $bookTotalQuantities[$purchase->book_id] ?? 'N/A' }}
                                </td>
                            @endif

                            <td class="px-4 py-2 text-right border dark:text-white">Rp{{ number_format($purchase->total_price, 0, ',', '.') }}
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
                        {{-- PERUBAHAN 4: Update ID buku saat ini --}}
                        @php $currentBookId = $purchase->book_id; @endphp
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-gray-500">Belum ada data pengadaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Fitur Pagination (tidak berubah) --}}
        {{-- <div class="mt-4">
            {{ $purchases->links() }}
        </div> --}}

        <!-- Fitur Pagination -->
        <div class="flex items-center justify-between mt-4">
            <div>
                @if ($purchases->total() > 0)
                    <p class="text-sm text-gray-700 dark:text-white">
                        Showing {{ $purchases->firstItem() }} to {{ $purchases->lastItem() }} of {{ $purchases->total() }}
                        entries
                    </p>
                @endif
            </div>
            <div>
                @if ($purchases->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                        {{-- Previous Page Link --}}
                        @if ($purchases->onFirstPage())
                            <span class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
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
                                <span class="px-3 py-1 mr-1 text-gray-500 bg-white border rounded">{{ $link }}</span>
                            @elseif ($link == $currentPage)
                                <span class="px-3 py-1 mr-1 text-white bg-blue-500 border border-blue-500 rounded">{{ $link }}</span>
                            @else
                                <a href="{{ $purchases->url($link) }}"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($purchases->hasMorePages())
                            <a href="{{ $purchases->nextPageUrl() }}" rel="next"
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
@endsection