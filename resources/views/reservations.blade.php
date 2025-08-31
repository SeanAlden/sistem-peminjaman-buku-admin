@extends('layouts.app')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        {{-- Judul dinamis berdasarkan peran --}}
        <h1 class="mb-6 text-3xl font-bold text-gray-800">
            @if(Auth::user()->usertype === 'admin')
                Daftar Reservasi Pengguna
            @else
                Reservasi Buku Saya
            @endif
        </h1>

        {{-- Notifikasi (tidak berubah) --}}
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
                            class="text-xs font-semibold tracking-wider text-left text-gray-600 uppercase border-b-2 border-gray-200 bg-gray-50">
                            {{-- PERUBAHAN: Tampilkan kolom 'Pengguna' hanya untuk admin --}}
                            @if(Auth::user()->usertype === 'admin')
                                <th class="px-5 py-3">Pengguna</th>
                            @endif
                            <th class="px-5 py-3">Judul Buku</th>
                            <th class="px-5 py-3">Email Buku</th>
                            <th class="px-5 py-3">Tanggal Reservasi</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Posisi Antrian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reservations as $reservation)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                {{-- PERUBAHAN: Tampilkan nama pengguna hanya untuk admin --}}
                                @if(Auth::user()->usertype === 'admin')
                                    <td class="px-5 py-5 text-sm">
                                        {{-- Pastikan relasi 'user' sudah di-eager load di controller --}}
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $reservation->user->name }}</p>
                                    </td>
                                    <td class="px-5 py-5 text-sm">
                                        {{-- Pastikan relasi 'user' sudah di-eager load di controller --}}
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $reservation->user->email }}</p>
                                    </td>
                                @endif
                                <td class="px-5 py-5 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $reservation->book->title }}</p>
                                    <p class="text-xs text-gray-600 whitespace-no-wrap">{{ $reservation->book->author }}</p>
                                </td>
                                <td class="px-5 py-5 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
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
                                {{-- <td class="px-5 py-5 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        @if ($reservation->status == 'available')
                                        Ambil sebelum {{ $reservation->expires_at->format('d M Y, H:i') }}
                                        @else
                                        -
                                        @endif
                                    </p>
                                </td> --}}
                                {{-- <td class="px-5 py-5 text-sm">
                                    PERUBAHAN: Hanya tampilkan tombol 'Batalkan' untuk pemilik reservasi
                                    @if (Auth::id() === $reservation->user_id && in_array($reservation->status, ['pending',
                                    'available']))
                                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="font-semibold text-red-600 hover:text-red-900">Batalkan</button>
                                    </form>
                                    @else
                                    <span>-</span>
                                    @endif
                                </td> --}}
                            </tr>
                        @empty
                            <tr>
                                {{-- Sesuaikan colspan berdasarkan peran --}}
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
                        {{-- Previous Page Link --}}
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

                        {{-- Next Page Link --}}
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
@endsection