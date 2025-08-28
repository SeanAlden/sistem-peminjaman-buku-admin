{{-- @extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="mb-4 text-2xl font-bold">Daftar Peminjaman</h1>

    <table class="min-w-full bg-white rounded shadow">
        <thead>
            <tr>
                <th class="px-4 py-2 border-b">Judul Buku</th>
                <th class="px-4 py-2 border-b">Tanggal Pinjam</th>
                <th class="px-4 py-2 border-b">Tanggal Kembali</th>
                <th class="px-4 py-2 border-b">Status</th>
                <th class="px-4 py-2 border-b">Durasi Keterlambatan</th>
                <th class="px-4 py-2 border-b">Total Denda</th>
                <th class="px-4 py-2 border-b">Catatan</th>
                <th class="px-4 py-2 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $loan)
            <tr>
                <td class="px-4 py-2 border-b">{{ $loan->book->title }}</td>
                <td class="px-4 py-2 border-b">{{ $loan->loan_date->format('d-m-Y') }}</td>
                <td class="px-4 py-2 border-b">{{ $loan->return_date ? $loan->return_date->format('d-m-Y') : '-' }}</td>
                <td class="px-4 py-2 capitalize border-b">{{ $loan->status }}</td>
                <td class="px-4 py-2 capitalize border-b">{{ $loan->late_days }}</td>
                <td class="px-4 py-2 capitalize border-b">{{ $loan->fine_amount }}</td>
                <td class="px-4 py-2 capitalize border-b">{{ $loan->return_status_note }}</td>
                <td class="px-4 py-2 border-b">
                    <a href="{{ route('loans.show', $loan->id) }}" class="text-blue-600 hover:underline">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <h1 class="mb-6 text-3xl font-bold text-gray-800 dark:text-white">📖 Daftar Peminjaman</h1>

        <!-- Fitur Search dan Items per Page -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <form action="{{ route('loans.index') }}" method="GET" class="flex items-center">
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
                <form action="{{ route('loans.index') }}" method="GET" class="flex items-center">
                    <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>
        <!-- End Fitur -->

        <div class="overflow-x-auto rounded shadow-lg">
            <table class="min-w-full bg-white divide-y divide-gray-200">
                <thead class="bg-gray-100 dark:bg-gray-300">
                    <tr>
                        <th class="px-6 py-3 text-sm font-medium text-left text-gray-700">Gambar</th>
                        <th class="px-6 py-3 text-sm font-medium text-left text-gray-700">Judul Buku</th>
                        <th class="px-6 py-3 text-sm font-medium text-left text-gray-700">Email User</th>
                        <th class="px-6 py-3 text-sm font-medium text-left text-gray-700">Durasi Peminjaman
                            Maksimal</th>
                        <th class="px-6 py-3 text-sm font-medium text-left text-gray-700">Tanggal Peminjaman
                        </th>
                        <th class="px-6 py-3 text-sm font-medium text-left text-gray-700 ">Janji Tanggal
                            Kembali</th>
                        <th class="px-6 py-3 text-sm font-medium text-left text-gray-700">Tanggal Maks
                            Kembali</th>
                        <th class="px-6 py-3 text-sm font-medium text-left text-gray-700">Status</th>
                        <th class="px-6 py-3 text-sm font-medium text-left text-gray-700">Tanggal
                            Pengembalian</th>
                        <th class="px-6 py-3 text-sm font-medium text-left text-gray-700">Durasi
                            Keterlambatan</th>
                        <th class="px-6 py-3 text-sm font-medium text-left text-gray-700">Total Denda</th>
                        <th class="px-6 py-3 text-sm font-medium text-left text-gray-700">Catatan</th>
                        <th class="px-6 py-3 text-sm font-medium text-left text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
                    @foreach ($loans as $loan)
                        <tr class="transition duration-300 hover:bg-gray-50 dark:bg-gray-500 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                <img src="{{ asset('storage/' . $loan->book->image_url) }}" alt="Book Image"
                                    class="object-contain w-16 h-20 rounded shadow">
                            </td>
                            <td class="px-6 py-4 font-semibold dark:text-white">{{ $loan->book->title }}</td>
                            <td class="px-6 py-4 dark:text-white">{{ $loan->user->email ?? '-' }}</td>
                            <td class="px-6 py-4 text-center dark:text-white">{{ $loan->loan_duration ?? '-' }} Hari</td>
                            <td class="px-6 py-4 dark:text-white">{{ $loan->loan_date->format('d-m-Y') }}</td>
                            <td class="px-6 py-4 dark:text-white">
                                {{ $loan->return_date ? $loan->return_date->format('d-m-Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 dark:text-white">
                                {{ $loan->max_returned_at ? $loan->max_returned_at->format('d-m-Y') : '-' }}
                            </td>

                            <td class="px-6 py-4 capitalize dark:text-white">
                                <span
                                    class="inline-block px-2 py-1 rounded 
                                                                            {{ $loan->status === 'returned' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $loan->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 dark:text-white">
                                {{ $loan->actual_returned_at ? $loan->actual_returned_at->format('d-m-Y') : '-' }}
                            </td>

                            {{-- <td class="px-6 py-4">
                                {{ $loan->actual_returned_at ? $loan->actual_returned_at : '-' }}
                            </td> --}}
                            <td class="px-6 py-4 text-center dark:text-white">{{ $loan->late_days ?? '-' }} Hari</td>
                            <td class="px-6 py-4 dark:text-white">
                                {{ $loan->fine_amount ? 'Rp ' . number_format($loan->fine_amount, 0, ',', '.') : '-' }}
                            </td>
                            <td class="px-6 py-4 capitalize dark:text-white">
                                {{ str_replace('_', ' ', $loan->return_status_note ?? '-') }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('loans.show', $loan->id) }}"
                                    class="font-medium text-blue-600 dark:text-blue-300 hover:underline">Detail</a>
                            </td>
                        </tr>
                    @endforeach
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
                        {{-- Previous Page Link --}}
                        @if ($loans->onFirstPage())
                            <span class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
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
                                <span class="px-3 py-1 mr-1 text-gray-500 bg-white border rounded">{{ $link }}</span>
                            @elseif ($link == $currentPage)
                                <span class="px-3 py-1 mr-1 text-white bg-blue-500 border border-blue-500 rounded">{{ $link }}</span>
                            @else
                                <a href="{{ $loans->url($link) }}"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($loans->hasMorePages())
                            <a href="{{ $loans->nextPageUrl() }}" rel="next"
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