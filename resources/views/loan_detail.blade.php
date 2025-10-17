{{-- @extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="mb-4 text-2xl font-bold">Detail Peminjaman</h1>

        <div class="p-4 bg-white rounded shadow">
            <div class="mb-4">
                <h2 class="text-xl font-semibold">{{ $loan->book->title }}</h2>
                <img src="{{ asset('storage/' . $loan->book->image_url) }}" alt="Cover" class="object-contain w-32 h-48 mt-2">
            </div>
            <p><strong>Penulis:</strong> {{ $loan->book->author }}</p>
            <p><strong>Stok Buku:</strong> {{ $loan->book->stock }}</p>
            <p><strong>Tanggal Pinjam:</strong> {{ $loan->loan_date->format('d-m-Y') }}</p>
            <p><strong>Tanggal Janji Kembali:</strong> {{ $loan->return_date ? $loan->return_date->format('d-m-Y') : '-' }}</p>
            <p><strong>Tanggal Kembali:</strong> {{ $loan->actual_returned_at ? $loan->actual_returned_at->format('d-m-Y') : '-' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($loan->status) }}</p>
            <p><strong>Keterlambatan Pengembalian:</strong> {{ ucfirst($loan->late_days) }} Hari</p>
            <p><strong>Total Denda:</strong> Rp {{ $loan->fine_amount }} </p>
            <p><strong>Catatan: </strong> {{ $loan->return_status_note }}</p>
            <p><strong>Durasi Pinjam:</strong>
                {{ $duration !== null ? $duration . ' hari' : 'Belum dikembalikan' }}
            </p>
        </div>
    </div>
@endsection  --}}

@extends('layouts.app')

@section('content')
<div class="container px-6 mx-auto mt-8 text-gray-900 dark:text-gray-100">
    <h1 class="mb-6 text-3xl font-bold tracking-tight">📚 Detail Peminjaman</h1>

    <div class="p-6 transition bg-white border border-gray-200 shadow-lg dark:bg-gray-800 rounded-2xl dark:border-gray-700">
        <div class="flex flex-col gap-6 md:flex-row md:items-start">
            {{-- Gambar Buku --}}
            <div class="flex-shrink-0">
                <img src="{{ asset('storage/' . $loan->book->image_url) }}" 
                     alt="Cover" 
                     class="object-contain w-40 h-56 rounded-md shadow-md bg-gray-50 dark:bg-gray-700" />
            </div>

            {{-- Detail Buku --}}
            <div class="flex-1 space-y-2">
                <h2 class="text-2xl font-semibold text-blue-700 dark:text-blue-400">{{ $loan->book->title }}</h2>
                <p><strong class="text-gray-700 dark:text-gray-300">Penulis:</strong> {{ $loan->book->author }}</p>
                <p><strong class="text-gray-700 dark:text-gray-300">Stok Buku:</strong> {{ $loan->book->stock }}</p>
                <div class="my-3 border-t border-gray-200 dark:border-gray-700"></div>
                <p><strong class="text-gray-700 dark:text-gray-300">Tanggal Pinjam:</strong> {{ $loan->loan_date->format('d-m-Y') }}</p>
                <p><strong class="text-gray-700 dark:text-gray-300">Tanggal Janji Kembali:</strong> 
                    {{ $loan->return_date ? $loan->return_date->format('d-m-Y') : '-' }}
                </p>
                <p><strong class="text-gray-700 dark:text-gray-300">Tanggal Kembali:</strong> 
                    {{ $loan->actual_returned_at ? $loan->actual_returned_at->format('d-m-Y') : '-' }}
                </p>
            </div>
        </div>

        {{-- Status dan Info Tambahan --}}
        <div class="grid gap-4 mt-6 text-sm md:grid-cols-2 sm:text-base">
            <div class="p-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700/50 dark:border-gray-600">
                <p><strong>Status:</strong> 
                    <span class="
                        px-2 py-1 rounded text-white 
                        {{ $loan->status === 'returned' ? 'bg-green-600' : ($loan->status === 'late' ? 'bg-red-600' : 'bg-yellow-500') }}
                    ">
                        {{ ucfirst($loan->status) }}
                    </span>
                </p>
                <p class="mt-2"><strong>Keterlambatan:</strong> {{ ucfirst($loan->late_days) }} Hari</p>
                <p><strong>Total Denda:</strong> 
                    <span class="font-semibold text-red-600 dark:text-red-400">Rp {{ number_format($loan->fine_amount, 0, ',', '.') }}</span>
                </p>
            </div>

            <div class="p-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700/50 dark:border-gray-600">
                <p><strong>Catatan:</strong> {{ $loan->return_status_note ?: '-' }}</p>
                <p class="mt-2"><strong>Durasi Pinjam:</strong> 
                    {{ $duration !== null ? $duration . ' hari' : 'Belum dikembalikan' }}
                </p>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-6">
            <a href="{{ route('loans.index') }}" 
               class="inline-block px-4 py-2 font-medium text-white transition bg-gray-700 rounded-lg hover:bg-gray-800 dark:bg-gray-600 dark:hover:bg-gray-500">
               ← Kembali
            </a>
        </div>
    </div>
</div>
@endsection
