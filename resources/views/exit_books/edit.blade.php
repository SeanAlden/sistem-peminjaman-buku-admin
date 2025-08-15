@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Edit Data Barang Keluar</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('exit_books.update', $exit->id) }}" method="POST" class="border p-4 rounded">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label>Buku</label>
                <select name="book_id" class="w-full border p-2 rounded">
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ $exit->book_id == $book->id ? 'selected' : '' }}>
                            {{ $book->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Supplier</label>
                <select name="supplier_id" class="w-full border p-2 rounded">
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ $exit->supplier_id == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Jumlah Keluar</label>
                <input type="number" name="stock_out" class="w-full border p-2 rounded" min="1" value="{{ $exit->stock_out }}">
            </div>
            <div>
                <label>Alasan</label>
                <input type="text" name="reason" class="w-full border p-2 rounded" value="{{ $exit->reason }}">
            </div>
        </div>

        <div class="mt-4">
            <button class="bg-green-600 text-white px-4 py-2 rounded">Perbarui</button>
            <a href="{{ route('exit_books.index') }}" class="ml-2 text-gray-600 hover:underline">Kembali</a>
        </div>
    </form>
</div>
@endsection
