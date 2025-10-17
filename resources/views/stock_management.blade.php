{{-- @extends('layouts.app')

@section('content')
    <div class="container px-4 py-6 mx-auto">
        <h2 class="mb-6 text-2xl font-bold">Laporan Stok Barang Masuk & Keluar</h2>

        @foreach($stockLogs as $bookId => $logs)
            <div class="mb-8 border rounded shadow">
                <div class="flex items-center px-4 py-2 bg-gray-100">
                    @if($logs->first()['book']->image_url)
                        <img src="{{ asset('storage/' . $logs->first()['book']->image_url) }}" alt="Gambar Buku"
                            class="object-cover w-16 h-20 mr-4 rounded" />
                    @else
                        <div class="flex items-center justify-center w-16 h-20 mr-4 text-sm text-gray-500 bg-gray-200 rounded">
                            Tidak ada gambar
                        </div>
                    @endif
                    <div>
                        <p class="text-lg font-semibold">{{ $logs->first()['book']->title }}</p>
                        <p class="text-sm text-gray-600">Kategori: {{ $logs->first()['category'] }}</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full mt-2 border-collapse table-auto">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left border">Tanggal</th>
                                <th class="px-4 py-2 text-left border">Tipe</th>
                                <th class="px-4 py-2 text-center border">Stok Sebelum</th>
                                <th class="px-4 py-2 text-center border">Jumlah</th>
                                <th class="px-4 py-2 text-center border">Stok Setelah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2 border">
                                                    {{ $log['created_at'] ? $log['created_at']->format('d M Y H:i') : '-' }}
                                                </td>
                                                <td class="px-4 py-2 border">{{ $log['type'] }}</td>
                                                <td class="px-4 py-2 text-center border">{{ $log['stock_before'] }}</td>
                                               
                                                <td
                                                    class="px-4 py-2 text-center border 
                                                           {{ $log['type'] === 'Masuk' ? 'text-green-600 font-bold' : 'text-red-600 font-bold' }}">
                                                    {{ $log['type'] === 'Masuk' ? '+' : '-' }}{{ $log['amount'] }}
                                                </td>
                                             

                                                <td class="px-4 py-2 text-center border">{{ $log['stock_after'] }}</td>
                                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach

        @if($stockLogs->isEmpty())
            <p class="mt-8 text-center text-gray-600">Tidak ada data stok ditemukan.</p>
        @endif
    </div>
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <h2 class="mb-8 text-3xl font-bold text-center text-gray-800 dark:text-white">
            📦 Laporan Stok Barang Masuk & Keluar
        </h2>

        @foreach($stockLogs as $bookId => $logs)
            <div class="mb-10 overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
                {{-- Header Buku --}}
                <div class="flex items-center px-6 py-4 bg-gray-50 dark:bg-gray-700">
                    @if($logs->first()['book']->image_url)
                        <img src="{{ asset('storage/' . $logs->first()['book']->image_url) }}" 
                             alt="Gambar Buku"
                             class="object-cover w-20 h-24 mr-5 rounded-md shadow-sm" />
                    @else
                        <div class="flex items-center justify-center w-20 h-24 mr-5 text-sm text-gray-500 bg-gray-200 rounded-md dark:bg-gray-600 dark:text-gray-300">
                            Tidak ada gambar
                        </div>
                    @endif
                    <div>
                        <p class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                            {{ $logs->first()['book']->title }}
                        </p>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                            📚 Kategori: <span class="font-medium">{{ $logs->first()['category'] }}</span>
                        </p>
                    </div>
                </div>

                {{-- Tabel Log --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="text-gray-700 bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="px-4 py-3 border">Tanggal</th>
                                <th class="px-4 py-3 border">Tipe</th>
                                <th class="px-4 py-3 text-center border">Stok Sebelum</th>
                                <th class="px-4 py-3 text-center border">Jumlah</th>
                                <th class="px-4 py-3 text-center border">Stok Setelah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            @foreach($logs as $log)
                                <tr class="transition-colors border-black dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-4 py-3 border dark:border-gray-600 dark:text-white">
                                        {{ $log['created_at'] ? $log['created_at']->format('d M Y H:i') : '-' }}
                                    </td>
                                    <td class="px-4 py-3 border dark:border-gray-600">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                                            {{ $log['type'] === 'Masuk' ? 'bg-green-100 text-green-700 dark:bg-green-700 dark:text-green-100' : 'bg-red-100 text-red-700 dark:bg-red-700 dark:text-red-100' }}">
                                            {{ $log['type'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center border dark:border-gray-600 dark:text-white">
                                        {{ $log['stock_before'] }}
                                    </td>
                                    <td class="px-4 py-3 text-center border-black dark:border-gray-600 font-bold 
                                        {{ $log['type'] === 'Masuk' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $log['type'] === 'Masuk' ? '+' : '-' }}{{ $log['amount'] }}
                                    </td>
                                    <td class="px-4 py-3 text-center border dark:border-gray-600 dark:text-white">
                                        {{ $log['stock_after'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach

        @if($stockLogs->isEmpty())
            <div class="p-6 mt-10 text-center border border-yellow-200 rounded-lg bg-yellow-50 dark:bg-yellow-900 dark:border-yellow-700">
                <p class="text-yellow-700 dark:text-yellow-200">⚠️ Tidak ada data stok ditemukan.</p>
            </div>
        @endif
    </div>
@endsection
