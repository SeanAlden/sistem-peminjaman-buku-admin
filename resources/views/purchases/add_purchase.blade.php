@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="mb-4 text-2xl font-bold dark:text-white">Tambah Pengadaan</h1>

    <form action="{{ route('purchases.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block dark:text-white">Supplier</label>
            <select name="supplier_id" class="w-full p-2 border dark:text-white" required>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block dark:text-white">Buku</label>
            <select name="book_id" class="w-full p-2 border dark:text-white" required>
                @foreach($books as $book)
                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block dark:text-white">Jumlah</label>
            <input type="number" name="quantity" min="1" class="w-full p-2 border dark:text-white" required>
        </div>
        <div>
            <label class="block dark:text-white">Tanggal Pengadaan</label>
            {{-- <input type="date" name="purchase_date" class="w-full p-2 border dark:text-white" required> --}}
            <input type="date" name="purchase_date" value="{{ old('purchase_date') }}" required
                   class="w-full border px-2 py-1 rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:[color-scheme:dark] dark:invert-[0.9] focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block dark:text-white">Total Harga</label>
            <input type="number" step="0.01" name="total_price" class="w-full p-2 border dark:text-white" required>
        </div>
        <div>
            <label class="block dark:text-white">Catatan</label>
            <input type="text" step="0.01" name="notes" class="w-full p-2 border dark:text-white" required>
        </div>
        <button type="submit" class="px-4 py-2 text-white bg-green-500 rounded">Simpan</button>
    </form>
</div>
@endsection
