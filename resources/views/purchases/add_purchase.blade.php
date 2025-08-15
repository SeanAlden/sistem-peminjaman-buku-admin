@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Tambah Pengadaan</h1>

    <form action="{{ route('purchases.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block">Supplier</label>
            <select name="supplier_id" class="border p-2 w-full" required>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block">Buku</label>
            <select name="book_id" class="border p-2 w-full" required>
                @foreach($books as $book)
                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block">Jumlah</label>
            <input type="number" name="quantity" min="1" class="border p-2 w-full" required>
        </div>
        <div>
            <label class="block">Tanggal Pengadaan</label>
            <input type="date" name="purchase_date" class="border p-2 w-full" required>
        </div>
        <div>
            <label class="block">Total Harga</label>
            <input type="number" step="0.01" name="total_price" class="border p-2 w-full" required>
        </div>
        <div>
            <label class="block">Catatan</label>
            <input type="text" step="0.01" name="notes" class="border p-2 w-full" required>
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
