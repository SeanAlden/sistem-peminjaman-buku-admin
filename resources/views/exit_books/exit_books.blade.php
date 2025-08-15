@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">Barang Keluar</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tombol untuk memunculkan modal tambah -->
        <button onclick="openAddModal()" class="mb-4 px-4 py-2 bg-blue-600 text-white rounded">+ Tambah Barang
            Keluar</button>

        <!-- Modal Tambah Data -->
        <div id="addModal" class="fixed z-10 inset-0 hidden items-center justify-center"
            style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="bg-white w-full max-w-xl rounded shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Tambah Barang Keluar</h2>
                <form action="{{ route('exit_books.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label>Buku</label>
                            <select name="book_id" class="w-full border p-2 rounded">
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Supplier</label>
                            <select name="supplier_id" class="w-full border p-2 rounded">
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Jumlah Keluar</label>
                            <input type="number" name="stock_out" class="w-full border p-2 rounded" min="1" required>
                        </div>
                        <div>
                            <label>Alasan</label>
                            <input type="text" name="reason" class="w-full border p-2 rounded"
                                placeholder="Rusak, robek, dll">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="button" onclick="closeAddModal()" class="mr-2 text-gray-600">Batal</button>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit Data -->
        <div id="editModal" class="fixed z-10 inset-0 hidden items-center justify-center"
            style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="bg-white w-full max-w-xl rounded shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Edit Barang Keluar</h2>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label>Buku</label>
                            <select name="book_id" id="edit_book_id" class="w-full border p-2 rounded">
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Supplier</label>
                            <select name="supplier_id" id="edit_supplier_id" class="w-full border p-2 rounded">
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Jumlah Keluar</label>
                            <input type="number" name="stock_out" id="edit_stock_out" class="w-full border p-2 rounded"
                                min="1" required>
                        </div>
                        <div>
                            <label>Alasan</label>
                            <input type="text" name="reason" id="edit_reason" class="w-full border p-2 rounded">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="button" onclick="closeEditModal()" class="mr-2 text-gray-600">Batal</button>
                        <button class="bg-green-600 text-white px-4 py-2 rounded">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Data -->
        <table class="min-w-full bg-white border">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="px-4 py-2 border">Buku</th>
                    <th class="px-4 py-2 border">Supplier</th>
                    <th class="px-4 py-2 border">Stok Sebelum</th>
                    <th class="px-4 py-2 border">Jumlah Keluar</th>
                    <th class="px-4 py-2 border">Stok Setelah</th>
                    <th class="px-4 py-2 border">Alasan</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exits as $exit)
                    <tr>
                        <td class="border px-4 py-2">{{ $exit->book->title }}</td>
                        <td class="border px-4 py-2">{{ $exit->supplier->name }}</td>
                        <td class="border px-4 py-2">{{ $exit->stock_before }}</td>
                        <td class="border px-4 py-2">{{ $exit->stock_out }}</td>
                        <td class="border px-4 py-2">{{ $exit->stock_after }}</td>
                        <td class="border px-4 py-2">{{ $exit->reason }}</td>
                        <td class="border px-4 py-2">
                            <button onclick="openEditModal({{ $exit }})"
                                class="text-blue-500 hover:underline mr-2">Edit</button>
                            <form action="{{ route('exit_books.destroy', $exit->id) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus?')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addModal').classList.remove('flex');
        }

        function openEditModal(data) {
            const route = `/exit-books/${data.id}`;
            document.getElementById('editForm').action = route;

            document.getElementById('edit_book_id').value = data.book_id;
            document.getElementById('edit_supplier_id').value = data.supplier_id;
            document.getElementById('edit_stock_out').value = data.stock_out;
            document.getElementById('edit_reason').value = data.reason ?? '';

            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
        }
    </script>
@endsection