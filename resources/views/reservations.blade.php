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

    <div class="overflow-hidden bg-white rounded-lg shadow-md">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="text-xs font-semibold tracking-wider text-left text-gray-600 uppercase border-b-2 border-gray-200 bg-gray-50">
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
                                <p class="text-gray-900 whitespace-no-wrap">{{ $reservation->created_at->format('d M Y, H:i') }}</p>
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
                                @if (Auth::id() === $reservation->user_id && in_array($reservation->status, ['pending', 'available']))
                                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-semibold text-red-600 hover:text-red-900">Batalkan</button>
                                    </form>
                                @else
                                    <span>-</span>
                                @endif
                            </td> --}}
                        </tr>
                    @empty
                        <tr>
                            {{-- Sesuaikan colspan berdasarkan peran --}}
                            <td colspan="{{ Auth::user()->usertype === 'admin' ? '7' : '6' }}" class="px-5 py-10 text-center text-gray-500">
                                Tidak ada data reservasi yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection