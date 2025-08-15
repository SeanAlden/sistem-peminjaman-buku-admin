@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Tambah Supplier</h1>

    <form action="{{ route('suppliers.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block">Nama Supplier</label>
            <input type="text" name="name" class="border p-2 w-full" required>
        </div>
        <div>
            <label class="block">Email</label>
            <input type="email" name="email" class="border p-2 w-full">
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
