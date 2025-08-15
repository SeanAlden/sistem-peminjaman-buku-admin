@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6" x-data="entryBookApp()">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Barang Masuk</h2>
            <button @click="openAddModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">+ Tambah
                Barang Masuk</button>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full table-auto border border-gray-200 bg-white rounded shadow">
                <thead class="bg-gray-100">
                    <tr class="text-left">
                        <th class="p-3 border-b">Gambar</th>
                        <th class="p-3 border-b">Nama Buku</th>
                        <th class="p-3 border-b">Kategori</th>
                        <th class="p-3 border-b">Stok Sebelum</th>
                        <th class="p-3 border-b">Jumlah Masuk</th>
                        <th class="p-3 border-b">Stok Setelah</th>
                        <th class="p-3 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entries as $entry)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">
                                <img src="{{ asset('storage/' . $entry->book->image_url) }}" alt="{{ $entry->book->title }}"
                                    class="w-14 h-20 object-cover">
                            </td>
                            <td class="p-3">{{ $entry->book->title }}</td>
                            <td class="p-3">{{ $entry->book->category->name ?? '-' }}</td>
                            <td class="p-3">{{ $entry->stock_before }}</td>
                            <td class="p-3">{{ $entry->stock_in }}</td>
                            <td class="p-3">{{ $entry->stock_after }}</td>
                            <td class="p-3 text-center">
                                <button @click="openEditModal({{ $entry->id }}, {{ $entry->book_id }}, {{ $entry->stock_in }})"
                                    class="text-blue-500 hover:underline mr-2">Ubah</button>
                                <form action="{{ route('entry_books.destroy', $entry->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-4 text-center text-gray-500">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal Tambah/Ubah -->
        <div class="fixed inset-0 flex items-center justify-center z-50" x-show="isModalOpen"
            style="display: none; background-color: rgba(0, 0, 0, 0.5);">
            <div class="bg-white p-6 rounded shadow w-full max-w-md" @click.away="closeModal">
                <h3 class="text-lg font-semibold mb-4" x-text="isEdit ? 'Ubah Barang Masuk' : 'Tambah Barang Masuk'"></h3>
                <form :action="formAction" method="POST">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT" />
                    </template>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Pilih Buku</label>
                        <select name="book_id" x-model="selectedBookId" :disabled="isEdit"
                            class="w-full border rounded px-3 py-2">
                            <option value="">-- Pilih Buku --</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}">
                                    {{ $book->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Jumlah Stok Masuk</label>
                        <input type="number" name="stock_in" x-model="stockIn"
                            :placeholder="`Masukkan jumlah (maksimal ${maxStock})`" class="w-full border rounded px-3 py-2"
                            min="1" :max="maxStock" />
                        <span class="text-sm text-gray-500">Maksimal: <span x-text="maxStock"></span></span>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" @click="closeModal" class="mr-2 px-4 py-2 border rounded">Batal</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function entryBookApp() {
            return {
                isModalOpen: false,
                isEdit: false,
                formAction: '',
                selectedBookId: '',
                stockIn: '',
                maxStock: 0,
                purchaseStockMap: @json($purchaseStockMap),

                openAddModal() {
                    this.isModalOpen = true;
                    this.isEdit = false;
                    this.formAction = '{{ route('entry_books.store') }}';
                    this.selectedBookId = '';
                    this.stockIn = '';
                    this.maxStock = 0;
                },

                openEditModal(id, bookId, stockIn) {
                    this.isModalOpen = true;
                    this.isEdit = true;
                    this.formAction = `/entry-books/${id}`;
                    this.selectedBookId = bookId;
                    this.stockIn = stockIn;
                    this.maxStock = this.purchaseStockMap[bookId] ?? 0;
                },

                closeModal() {
                    this.isModalOpen = false;
                    this.selectedBookId = '';
                    this.stockIn = '';
                    this.maxStock = 0;
                },

                init() {
                    // Update max stock dynamically if selected book changes
                    this.$watch('selectedBookId', (bookId) => {
                        this.maxStock = this.purchaseStockMap[bookId] ?? 0;
                    });
                }
            }
        }
    </script>
@endsection