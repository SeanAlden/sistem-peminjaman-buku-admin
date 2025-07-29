{{-- @extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Daftar Peminjaman</h1>

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
                <td class="px-4 py-2 border-b capitalize">{{ $loan->status }}</td>
                <td class="px-4 py-2 border-b capitalize">{{ $loan->late_days }}</td>
                <td class="px-4 py-2 border-b capitalize">{{ $loan->fine_amount }}</td>
                <td class="px-4 py-2 border-b capitalize">{{ $loan->return_status_note }}</td>
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
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">📖 Daftar Peminjaman</h1>

        <div class="overflow-x-auto rounded shadow-lg">
            <table class="min-w-full divide-y divide-gray-200 bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Gambar</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Judul Buku</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Tanggal Peminjaman</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Janji Tanggal Kembali</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Tanggal Pengembalian</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Durasi Keterlambatan</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Total Denda</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Catatan</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                    @foreach ($loans as $loan)
                        <tr class="hover:bg-gray-50 transition duration-300">
                            <td class="px-6 py-4">
                                <img src="{{ asset('storage/' . $loan->book->image_url) }}" alt="Book Image"
                                    class="w-16 h-20 object-contain rounded shadow">
                            </td>
                            <td class="px-6 py-4 font-semibold">{{ $loan->book->title }}</td>
                            <td class="px-6 py-4">{{ $loan->loan_date->format('d-m-Y') }}</td>
                            <td class="px-6 py-4">
                                {{ $loan->return_date ? $loan->return_date->format('d-m-Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 capitalize">
                                <span
                                    class="inline-block px-2 py-1 rounded 
                                    {{ $loan->status === 'returned' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $loan->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                {{ $loan->actual_returned_at ? $loan->actual_returned_at->format('d-m-Y') : '-' }}
                            </td>
                            {{-- <td class="px-6 py-4">
                                {{ $loan->actual_returned_at ? $loan->actual_returned_at : '-' }}
                            </td> --}}
                            <td class="px-6 py-4 text-center">{{ $loan->late_days ?? '-' }}</td>
                            <td class="px-6 py-4">
                                {{ $loan->fine_amount ? 'Rp ' . number_format($loan->fine_amount, 0, ',', '.') : '-' }}
                            </td>
                            <td class="px-6 py-4 capitalize">
                                {{ str_replace('_', ' ', $loan->return_status_note ?? '-') }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('loans.show', $loan->id) }}"
                                    class="text-blue-600 hover:underline font-medium">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection