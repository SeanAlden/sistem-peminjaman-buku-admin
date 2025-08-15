{{-- @extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Prediksi Buku Terlaris</h2>
        <form action="{{ route('predictions.refresh') }}" method="POST">
            @csrf
            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Refresh Prediksi
            </button>
        </form>
    </div>

    @if(session('success'))
    <div class="mb-4 p-2 bg-green-200 text-green-800 rounded">
        {{ session('success') }}
    </div>
    @endif

    <table class="table-auto w-full border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 text-left">Judul Buku</th>
                <th class="px-4 py-2 text-left">Jumlah Peminjaman</th>
                <th class="px-4 py-2 text-left">Prediksi Kelarisan (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($predictions as $prediction)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $prediction->book->title }}</td>
                <td class="px-4 py-2">{{ $prediction->loan_count }}</td>
                <td class="px-4 py-2">{{ $prediction->predicted_popularity }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        {{-- Header and Refresh Button --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">📈 Prediksi Buku Terlaris</h2>
            <form action="{{ route('predictions.refresh') }}" method="POST">
                @csrf
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow">
                    🔄 Refresh Prediksi
                </button>
            </form>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- Fitur Search dan Items per Page -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <form action="{{ route('predictions.index') }}" method="GET" class="flex items-center">
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
            <div class="flex items-center">
                <form action="{{ route('predictions.index') }}" method="GET" class="flex items-center">
                    <label for="search" class="mr-2 text-sm text-gray-600">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>
        <!-- End Fitur -->

        {{-- Table --}}
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                {{-- <thead class="bg-gray-100 text-gray-600 text-sm uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-3 text-left">Gambar</th>
                        <th class="px-6 py-3 text-left">Judul Buku</th>
                        <th class="px-6 py-3 text-left">Kategori</th>
                        <th class="px-6 py-3 text-left">Jumlah Peminjaman</th>
                        <th class="px-6 py-3 text-left">Prediksi Kelarisan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($predictions as $prediction)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <img src="{{ asset('storage/' . $prediction->book->image_url) ?? asset('images/default_book.png') }}"
                                alt="Cover Buku" class="w-16 h-24 object-contain rounded shadow-sm">
                        </td>
                        <td class="px-6 py-4 text-gray-800 font-medium">
                            {{ $prediction->book->title }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $prediction->book->category->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $prediction->loan_count }}
                        </td>
                        <td class="px-6 py-4 text-blue-600 font-semibold">
                            {{ $prediction->predicted_popularity }}%
                        </td>
                    </tr>
                    @endforeach
                </tbody> --}}
                <thead class="bg-gray-100 text-gray-600 text-sm uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-3 text-left">Gambar</th>
                        <th class="px-6 py-3 text-left">Judul Buku</th>
                        <th class="px-6 py-3 text-left">Kategori</th>
                        <th class="px-6 py-3 text-left">Jumlah Peminjaman</th>
                        <th class="px-6 py-3 text-left">Prediksi (Skor)</th>
                        <th class="px-6 py-3 text-left">Prediksi (Jumlah Buku Dipinjam Bulan Depan)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($predictions as $prediction)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <img src="{{ asset('storage/' . ($prediction->book->image_url ?? 'images/default_book.png')) }}"
                                    alt="Cover Buku" class="w-16 h-24 object-contain rounded shadow-sm">
                            </td>
                            <td class="px-6 py-4 text-gray-800 font-medium">
                                {{ $prediction->book->title }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $prediction->book->category->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $prediction->loan_count }}
                            </td>
                            <td class="px-6 py-4 text-blue-600 font-semibold">
                                {{ $prediction->predicted_popularity }}%
                            </td>
                            <td class="px-6 py-4 text-green-600 font-semibold">
                                {{ $prediction->des_prediction !== null ? number_format($prediction->des_prediction, 0) : '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
                <!-- Fitur Pagination -->
        <div class="flex items-center justify-between mt-4">
            <div>
                @if ($predictions->total() > 0)
                    <p class="text-sm text-gray-700">
                        Showing {{ $predictions->firstItem() }} to {{ $predictions->lastItem() }} of {{ $predictions->total() }}
                        entries
                    </p>
                @endif
            </div>
            <div>
                @if ($predictions->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                        {{-- Previous Page Link --}}
                        @if ($predictions->onFirstPage())
                            <span class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                        @else
                            <a href="{{ $predictions->previousPageUrl() }}" rel="prev"
                                class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                        @endif

                        @php
                            $currentPage = $predictions->currentPage();
                            $lastPage = $predictions->lastPage();
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
                                <a href="{{ $predictions->url($link) }}"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($predictions->hasMorePages())
                            <a href="{{ $predictions->nextPageUrl() }}" rel="next"
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