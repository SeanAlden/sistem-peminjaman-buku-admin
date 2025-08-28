@extends('layouts.app')

@section('content')
    <div class="container px-4 py-6 mx-auto">
        <h2 class="mb-6 text-2xl font-bold">Laporan Stok Barang Masuk & Keluar</h2>

        @foreach($stockLogs as $bookId => $logs)
            <div class="mb-8 border rounded shadow">
                <div class="flex items-center px-4 py-2 bg-gray-100">
                    {{-- @if($logs->first()->book->image_url) --}}
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
                                                {{-- <td class="px-4 py-2 text-center border">
                                                    {{ $log['type'] === 'Masuk' ? '+' : '-' }}{{ $log['amount'] }}
                                                </td> --}}
                                                {{-- <td
                                                    class="px-4 py-2 text-center border 
                                                           {{ $log['type'] === 'Masuk' ? 'text-green-600 font-bold' : 'text-red-600 font-bold' }}">
                                                    {{ $log['type'] === 'Masuk' ? '+' : '-' }}{{ $log['amount'] }}
                                                </td> --}}
                                                <td class="px-4 py-2 text-center border 
                                   {{ $log['type'] === 'Masuk' ? 'text-green-600 font-bold' : 'text-red-600 font-bold' }}">
                                                    @if($log['type'] === 'Masuk')
                                                        ⬆️ +{{ $log['amount'] }}
                                                    @else
                                                        ⬇️ -{{ $log['amount'] }}
                                                    @endif
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
@endsection