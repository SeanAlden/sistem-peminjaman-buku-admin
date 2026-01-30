@extends('layouts.app')

@section('content')
    <div class="container px-4 py-6 mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="mb-4 text-2xl font-bold dark:text-white">Barang Keluar</h1>
            <!-- Tombol untuk memunculkan modal tambah -->
            <button onclick="openAddModal()"
                class="px-4 py-2 text-white bg-blue-600 rounded cursor-pointer hover:bg-blue-700">+ Tambah Barang
                Keluar</button>
        </div>

        @if (session('success'))
            <div id="success-alert"
                class="px-4 py-3 mb-6 text-green-700 bg-green-100 border border-green-400 rounded transition-opacity duration-500"
                role="alert">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => {
                    const alert = document.getElementById('success-alert');
                    if (alert) {
                        alert.classList.add('opacity-0');
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 2000);
            </script>
        @endif
        @if (session('error'))
            <div id="error-alert"
                class="px-4 py-3 mb-6 text-red-700 bg-red-100 border border-red-400 rounded transition-opacity duration-500"
                role="alert">
                {{ session('error') }}
            </div>
            <script>
                setTimeout(() => {
                    const alert = document.getElementById('error-alert');
                    if (alert) {
                        alert.classList.add('opacity-0');
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 2000);
            </script>
        @endif

        <!-- Modal Tambah Data -->
        <div id="addModal" class="fixed inset-0 z-10 items-center justify-center hidden"
            style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="w-full max-w-xl p-6 bg-white rounded shadow-lg">
                <h2 class="mb-4 text-xl font-semibold">Tambah Barang Keluar</h2>
                <form action="{{ route('exit_books.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label>Buku</label>
                            <select name="book_id" class="w-full p-2 border rounded">
                                @foreach ($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Supplier</label>
                            <select name="supplier_id" class="w-full p-2 border rounded">
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Jumlah Keluar</label>
                            <input type="number" name="stock_out" class="w-full p-2 border rounded" min="1"
                                required>
                        </div>
                        <div>
                            <label>Alasan</label>
                            <input type="text" name="reason" class="w-full p-2 border rounded"
                                placeholder="Rusak, robek, dll">
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="closeAddModal()" class="mr-2 text-gray-600">Batal</button>
                        <button class="px-4 py-2 text-white bg-blue-600 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit Data -->
        <div id="editModal" class="fixed inset-0 z-10 items-center justify-center hidden"
            style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="w-full max-w-xl p-6 bg-white rounded shadow-lg">
                <h2 class="mb-4 text-xl font-semibold">Edit Barang Keluar</h2>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label>Buku</label>
                            <select name="book_id" id="edit_book_id" class="w-full p-2 border rounded">
                                @foreach ($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Supplier</label>
                            <select name="supplier_id" id="edit_supplier_id" class="w-full p-2 border rounded">
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Jumlah Keluar</label>
                            <input type="number" name="stock_out" id="edit_stock_out" class="w-full p-2 border rounded"
                                min="1" required>
                        </div>
                        <div>
                            <label>Alasan</label>
                            <input type="text" name="reason" id="edit_reason" class="w-full p-2 border rounded">
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="closeEditModal()" class="mr-2 text-gray-600">Batal</button>
                        <button class="px-4 py-2 text-white bg-green-600 rounded">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Fitur Search dan Items per Page -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <form action="{{ route('exit_books.index') }}" method="GET" class="flex items-center">
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
                <form action="{{ route('exit_books.index') }}" method="GET" class="flex items-center">
                    <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>
        <!-- End Fitur -->

        <!-- Tabel Data -->
        <table class="min-w-full bg-white border">
            <thead>
                <tr class="text-left bg-gray-200 dark:bg-gray-600">
                    <th class="px-4 py-2 border dark:text-white">Gambar</th> <!-- Tambahkan ini -->
                    <th class="px-4 py-2 border dark:text-white">Buku</th>
                    <th class="px-4 py-2 border dark:text-white">Supplier</th>
                    <th class="px-4 py-2 border dark:text-white">Stok Sebelum</th>
                    <th class="px-4 py-2 border dark:text-white">Jumlah Keluar</th>
                    <th class="px-4 py-2 border dark:text-white">Stok Setelah</th>
                    <th class="px-4 py-2 border dark:text-white">Alasan</th>
                    <th class="px-4 py-2 border dark:text-white">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($exits as $exit)
                    <tr class="border-b dark:border-white hover:bg-gray-50 dark:hover:bg-gray-600 dark:bg-gray-500">
                        {{-- <td class="px-4 py-2 border">
                            @if ($exit->book->image_url)
                            <img src="{{ asset('storage/' . $exit->book->image_url) }}" alt="Gambar Buku"
                                class="object-cover w-16 h-20 rounded" />
                            @else
                            <span class="text-gray-500">Tidak ada gambar</span>
                            @endif
                        </td> --}}
                        <td class="px-4 py-2 text-center border dark:border-white">
                            {{-- @if ($exit->book->image_url)
                            <img src="{{ asset('storage/' . $exit->book->image_url) }}" alt="Gambar Buku"
                                class="object-cover w-16 h-20 mx-auto rounded" />
                            @else
                            <img src="{{ asset('assets/images/avatar.png') }}" alt="Gambar Buku"
                                class="object-cover w-16 h-20 mx-auto rounded" />
                            @endif --}}

                            @if ($exit->book->image_url)
                                <img src="{{ $exit->book->image_url ? Storage::disk('s3')->url($exit->book->image_url) : asset('assets/images/avatar.png') }}"
                                    alt="Gambar Buku" class="object-cover w-16 h-20 mx-auto rounded" />
                            @else
                                <img src="{{ asset('assets/images/avatar.png') }}" alt="Gambar Buku"
                                    class="object-cover w-16 h-20 mx-auto rounded" />
                            @endif
                        </td>
                        <td class="px-4 py-2 border dark:border-white dark:text-white">{{ $exit->book->title }}</td>
                        <td class="px-4 py-2 border dark:border-white dark:text-white">{{ $exit->supplier->name }}</td>
                        <td class="px-4 py-2 border dark:border-white dark:text-white">{{ $exit->stock_before }}</td>
                        <td class="px-4 py-2 font-bold text-red-500">- {{ $exit->stock_out }}</td>
                        <td class="px-4 py-2 border dark:border-white dark:text-white">{{ $exit->stock_after }}</td>
                        <td class="px-4 py-2 border dark:border-white dark:text-white">{{ $exit->reason }}</td>
                        <td class="px-4 py-2 border dark:border-white dark:text-white">
                            <button onclick="openEditModal({{ $exit }})"
                                class="mr-2 text-blue-500 hover:underline dark:text-blue-300">Edit</button>
                            <form action="{{ route('exit_books.destroy', $exit->id) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus?')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 dark:text-red-300 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Fitur Pagination -->
        <div class="flex items-center justify-between mt-4">
            <div>
                @if ($exits->total() > 0)
                    <p class="text-sm text-gray-700 dark:text-white">
                        Showing {{ $exits->firstItem() }} to {{ $exits->lastItem() }} of {{ $exits->total() }}
                        exits
                    </p>
                @endif
            </div>
            <div>
                @if ($exits->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                        {{-- Previous Page Link --}}
                        @if ($exits->onFirstPage())
                            <span
                                class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                        @else
                            <a href="{{ $exits->previousPageUrl() }}" rel="prev"
                                class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                        @endif

                        @php
                            $currentPage = $exits->currentPage();
                            $lastPage = $exits->lastPage();
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
                                <span
                                    class="px-3 py-1 mr-1 text-gray-500 bg-white border rounded">{{ $link }}</span>
                            @elseif ($link == $currentPage)
                                <span
                                    class="px-3 py-1 mr-1 text-white bg-blue-500 border border-blue-500 rounded">{{ $link }}</span>
                            @else
                                <a href="{{ $exits->url($link) }}"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($exits->hasMorePages())
                            <a href="{{ $exits->nextPageUrl() }}" rel="next"
                                class="px-3 py-1 ml-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Next</a>
                        @else
                            <span
                                class="px-3 py-1 ml-1 text-gray-400 bg-white border rounded cursor-not-allowed">Next</span>
                        @endif
                    </nav>
                @endif
            </div>
        </div>
        <!-- End Fitur Pagination -->
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
