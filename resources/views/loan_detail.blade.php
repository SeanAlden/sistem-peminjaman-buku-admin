@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Detail Peminjaman</h1>

        <div class="bg-white p-4 rounded shadow">
            <div class="mb-4">
                <h2 class="text-xl font-semibold">{{ $loan->book->title }}</h2>
                {{-- <img src="{{ $loan->book->image_url }}" alt="Cover" class="w-32 h-48 object-cover mt-2"> --}}
                <img src="{{ asset('storage/' . $loan->book->image_url) }}" alt="Cover" class="w-32 h-48 object-contain mt-2">
            </div>
            <p><strong>Penulis:</strong> {{ $loan->book->author }}</p>
            <p><strong>Stok Buku:</strong> {{ $loan->book->stock }}</p>
            <p><strong>Tanggal Pinjam:</strong> {{ $loan->loan_date->format('d-m-Y') }}</p>
            <p><strong>Tanggal Janji Kembali:</strong> {{ $loan->return_date ? $loan->return_date->format('d-m-Y') : '-' }}</p>
            <p><strong>Tanggal Kembali:</strong> {{ $loan->actual_returned_at ? $loan->actual_returned_at->format('d-m-Y') : '-' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($loan->status) }}</p>
            <p><strong>Keterlambatan Pengembalian:</strong> {{ ucfirst($loan->late_days) }} Hari</p>
            <p><strong>Catatan: </strong> {{ $loan->return_status_note }}</p>
            <p><strong>Durasi Pinjam:</strong>
                {{ $duration !== null ? $duration . ' hari' : 'Belum dikembalikan' }}
                {{-- {{ $duration !== null ? $duration : 'Belum dikembalikan' }} --}}
            </p>
        </div>
    </div>
@endsection