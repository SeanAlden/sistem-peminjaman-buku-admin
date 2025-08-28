@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">📦 Daftar Pengadaan</h1>

        {{-- Bagian Tombol Tambah, Notifikasi, dan Filter tidak berubah --}}
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('purchases.create') }}"
                class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Tambah Pengadaan
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-4">
            {{-- Form Per Page --}}
            <div class="flex items-center">
                <form action="{{ route('purchases.index') }}" method="GET" class="flex items-center">
                    <label for="per_page" class="mr-2 text-sm text-gray-600">Show:</label>
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
                    <label for="search" class="mr-2 text-sm text-gray-600">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse bg-white shadow-md rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 text-sm uppercase tracking-wider">
                        <th class="px-4 py-3 border">Buku</th>
                        <th class="px-4 py-3 border">Supplier</th>
                        <th class="px-4 py-3 border">Tanggal</th>
                        <th class="px-4 py-3 border">Jumlah (Sisa / Awal)</th>
                        {{-- PERUBAHAN 1: Menambahkan kolom baru untuk total --}}
                        <th class="px-4 py-3 border text-center bg-gray-300">Total Pengadaan (Buku Ini)</th>
                        <th class="px-4 py-3 border">Total Harga</th>
                        <th class="px-4 py-3 border">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    {{-- PERUBAHAN 2: Inisialisasi variabel untuk melacak grup buku --}}
                    @php $currentBookId = null; @endphp

                    @forelse($purchases as $purchase)
                        {{-- Menambahkan garis pemisah antar grup buku --}}
                        @if ($purchase->book_id !== $currentBookId && $currentBookId !== null)
                            <tr class="bg-gray-200">
                                <td colspan="7" class="py-1"></td>
                            </tr>
                        @endif

                        <tr class="hover:bg-gray-100 transition">
                            <td class="border px-4 py-2 font-semibold">{{ $purchase->book->title }}</td>
                            <td class="border px-4 py-2">{{ $purchase->supplier->name }}</td>
                            <td class="border px-4 py-2 text-center">
                                {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}</td>
                            <td class="border px-4 py-2 text-center">
                                <div class="text-sm font-semibold">
                                    {{ $purchase->quantity }} / {{ $purchase->initial_quantity }}
                                </div>
                                @php
                                    $percentage = ($purchase->initial_quantity > 0) ? ($purchase->quantity / $purchase->initial_quantity) * 100 : 0;
                                @endphp
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%;"></div>
                                </div>
                            </td>

                            {{-- PERUBAHAN 3: Logika untuk menampilkan total hanya sekali per grup --}}
                            @if ($purchase->book_id !== $currentBookId)
                                <td class="border px-4 py-2 text-center align-middle font-bold text-lg bg-gray-50"
                                    rowspan="{{ $purchases->where('book_id', $purchase->book_id)->count() }}">
                                    {{ $bookTotalQuantities[$purchase->book_id] ?? 'N/A' }}
                                </td>
                            @endif

                            <td class="border px-4 py-2 text-right">Rp{{ number_format($purchase->total_price, 0, ',', '.') }}
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('purchases.edit', $purchase->id) }}"
                                        class="inline-flex items-center bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 transition">✏️
                                        Edit</a>
                                    <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">🗑️
                                            Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        {{-- PERUBAHAN 4: Update ID buku saat ini --}}
                        @php $currentBookId = $purchase->book_id; @endphp
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">Belum ada data pengadaan.</td>
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