@extends('layouts.app')

@section('content')
    <div class="container px-4 py-6 mx-auto" x-data="entryBookApp()">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold">Barang Masuk</h2>
            <button @click="openAddModal()" class="px-4 py-2 text-white bg-blue-600 rounded cursor-pointer hover:bg-blue-700">+ Tambah
                Barang Masuk</button>
        </div>

        @if(session('success'))
            <div class="p-4 mb-4 text-green-800 bg-green-100 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Fitur Search dan Items per Page -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <form action="{{ route('entry_books.index') }}" method="GET" class="flex items-center">
                    <label for="per_page" class="mr-2 text-sm text-gray-600 dark:text-white">Show:</label>
                    <select name="per_page" id="per_page"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        onchange="this.form.submit()">
                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <input type="hidden" name="search" value="{{ $search }}">
                </form>
            </div>
            <div class="flex items-center">
                <form action="{{ route('entry_books.index') }}" method="GET" class="flex items-center">
                    <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>
        <!-- End Fitur -->

        {{-- <div class="overflow-x-auto"> --}}
            <table class="min-w-full bg-white border">
                <thead class="bg-gray-100">
                    <tr class="text-left bg-gray-200">
                        <th class="px-4 py-2 border">Gambar</th>
                        <th class="px-4 py-2 border">Nama Buku</th>
                        <th class="px-4 py-2 border">Kategori</th>
                        <th class="px-4 py-2 border">Stok Sebelum</th>
                        <th class="px-4 py-2 border">Jumlah Masuk</th>
                        <th class="px-4 py-2 border">Stok Setelah</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entries as $entry)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">
                                <img src="{{ asset('storage/' . $entry->book->image_url) }}" alt="{{ $entry->book->title }}"
                                    class="object-cover h-20 w-14">
                            </td>
                            <td class="px-4 py-2 border">{{ $entry->book->title }}</td>
                            <td class="px-4 py-2 border">{{ $entry->book->category->name ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $entry->stock_before }}</td>
                            <td class="px-4 py-2 font-bold text-green-500">+ {{ $entry->stock_in }}</td>
                            <td class="px-4 py-2 border">{{ $entry->stock_after }}</td>
                            <td class="px-4 py-2 border">
                                <button @click="openEditModal({{ $entry->id }}, {{ $entry->book_id }}, {{ $entry->stock_in }})"
                                    class="mr-2 text-blue-500 hover:underline">Ubah</button>
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
        {{-- </div> --}}
        <!-- Fitur Pagination -->
        <div class="flex items-center justify-between mt-4">
            <div>
                @if ($entries->total() > 0)
                    <p class="text-sm text-gray-700 dark:text-white">
                        Showing {{ $entries->firstItem() }} to {{ $entries->lastItem() }} of {{ $entries->total() }}
                        entries
                    </p>
                @endif
            </div>
            <div>
                @if ($entries->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                        {{-- Previous Page Link --}}
                        @if ($entries->onFirstPage())
                            <span class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                        @else
                            <a href="{{ $entries->previousPageUrl() }}" rel="prev"
                                class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                        @endif

                        @php
                            $currentPage = $entries->currentPage();
                            $lastPage = $entries->lastPage();
                            $links = [];

                            // Logic untuk menampilkan link pagination
                            if ($lastPage <= 7) {
                                for ($i = 1; $i <= $lastPage; $i++) {
                                    $links[] = $i;
                                }
                            } else {
                                $links[] = 1;
                                if ($currentPage > 4) {
                                    $links[] = '...';
                                }

                                $start = max(2, $currentPage - 1);
                                $end = min($lastPage - 1, $currentPage + 1);

                                if ($currentPage <= 4) {
                                    $start = 2;
                                    $end = 5;
                                }

                                if ($currentPage >= $lastPage - 3) {
                                    $start = $lastPage - 4;
                                    $end = $lastPage - 1;
                                }

                                for ($i = $start; $i <= $end; $i++) {
                                    $links[] = $i;
                                }

                                if ($currentPage < $lastPage - 3) {
                                    $links[] = '...';
                                }
                                $links[] = $lastPage;
                            }
                        @endphp

                        @foreach ($links as $link)
                            @if ($link === '...')
                                <span class="px-3 py-1 mr-1 text-gray-500 bg-white border rounded">{{ $link }}</span>
                            @elseif ($link == $currentPage)
                                <span class="px-3 py-1 mr-1 text-white bg-blue-500 border border-blue-500 rounded">{{ $link }}</span>
                            @else
                                <a href="{{ $entries->url($link) }}"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($entries->hasMorePages())
                            <a href="{{ $entries->nextPageUrl() }}" rel="next"
                                class="px-3 py-1 ml-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Next</a>
                        @else
                            <span class="px-3 py-1 ml-1 text-gray-400 bg-white border rounded cursor-not-allowed">Next</span>
                        @endif
                    </nav>
                @endif
            </div>
        </div>
        <!-- End Fitur Pagination -->

        <!-- Modal Tambah/Ubah -->
        <div class="fixed inset-0 z-50 flex items-center justify-center" x-show="isModalOpen"
            style="display: none; background-color: rgba(0, 0, 0, 0.5);">
            <div class="w-full max-w-md p-6 bg-white rounded shadow" @click.away="closeModal">
                <h3 class="mb-4 text-lg font-semibold" x-text="isEdit ? 'Ubah Barang Masuk' : 'Tambah Barang Masuk'"></h3>
                <form :action="formAction" method="POST">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT" />
                    </template>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Pilih Buku</label>
                        <select name="book_id" x-model="selectedBookId" :disabled="isEdit"
                            class="w-full px-3 py-2 border rounded">
                            <option value="">-- Pilih Buku --</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}">
                                    {{ $book->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Jumlah Stok Masuk</label>
                        <input type="number" name="stock_in" x-model="stockIn"
                            :placeholder="`Masukkan jumlah (maksimal ${maxStock})`" class="w-full px-3 py-2 border rounded"
                            min="1" :max="maxStock" />
                        <span class="text-sm text-gray-500">Maksimal: <span x-text="maxStock"></span></span>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" @click="closeModal" class="px-4 py-2 mr-2 border rounded">Batal</button>
                        <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
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