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

    {{-- Table --}}
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-gray-600 text-sm uppercase font-semibold">
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
                                 alt="Cover Buku" 
                                 class="w-16 h-24 object-contain rounded shadow-sm">
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
            </tbody>
        </table>
    </div>
</div>
@endsection
