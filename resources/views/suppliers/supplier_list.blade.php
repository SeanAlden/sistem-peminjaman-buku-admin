{{-- @extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="mb-4 text-2xl font-bold">Daftar Supplier</h1>

    <button onclick="openAddSupplierModal()" class="px-4 py-2 text-white bg-blue-500 rounded">
        Tambah Supplier
    </button>

    @if(session('success'))
    <div class="mt-2 text-green-600">{{ session('success') }}</div>
    @endif

    <table class="w-full mt-4 border-collapse table-auto">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Nama</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suppliers as $supplier)
            <tr>
                <td class="px-4 py-2 border">{{ $supplier->id }}</td>
                <td class="px-4 py-2 border">{{ $supplier->name }}</td>
                <td class="px-4 py-2 border">{{ $supplier->email }}</td>
                <td class="px-4 py-2 border">
                    <button onclick="openEditSupplierModal({{ $supplier->id }})"
                        class="px-2 py-1 text-white bg-yellow-400 rounded cursor-pointer">Edit</button>

                    @if($supplier->purchases->count() === 0)
                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-2 py-1 text-white bg-red-500 rounded cursor-pointer"
                            onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                    @else
                    <button class="px-2 py-1 text-white bg-gray-400 rounded opacity-50 cursor-not-allowed"
                        disabled>Hapus</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="supplierModal" x-data="{ showModal: false, editMode: false, supplier: {} }" x-cloak>
    <div x-show="showModal" class="fixed inset-0 flex items-center justify-center"
        style="display: none; background-color: rgba(0, 0, 0, 0.5);">
        <div class="w-full max-w-lg p-6 bg-white rounded shadow-lg">
            <h2 class="mb-4 text-xl font-semibold" x-text="editMode ? 'Edit Supplier' : 'Tambah Supplier'"></h2>
            <form :action="editMode ? `/suppliers/${supplier.id}` : '{{ route('suppliers.store') }}'" method="POST">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <label>Nama</label>
                <input type="text" name="name" class="w-full mb-2 border" x-model="supplier.name" required>

                <label>Email</label>
                <input type="email" name="email" class="w-full mb-2 border" x-model="supplier.email">

                <div class="flex justify-end gap-2">
                    <button type="button" @click="showModal = false"
                        class="px-4 py-2 text-white bg-gray-400 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 text-white bg-green-500 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditSupplierModal(id) {
        fetch(`/suppliers/${id}/edit`)
            .then(res => res.json())
            .then(data => {
                const modalComponent = document.getElementById('supplierModal');
                const modalData = Alpine.$data(modalComponent);
                modalData.supplier = data;
                modalData.editMode = true;
                modalData.showModal = true;
            });
    }

    function openAddSupplierModal() {
        const modalComponent = document.getElementById('supplierModal');
        const modalData = Alpine.$data(modalComponent);

        modalData.supplier = { name: '', email: '' };
        modalData.editMode = false;
        modalData.showModal = true;
    }
</script>
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-800">
        <div class="container px-4 py-8 mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col items-start justify-between mb-6 sm:flex-row sm:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Daftar Supplier</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Kelola data supplier untuk kebutuhan pembelian Anda.</p>
                </div>
                <button onclick="openAddSupplierModal()"
                    class="flex items-center gap-2 px-4 py-2 mt-4 text-white transition-colors duration-200 bg-blue-600 rounded-lg shadow-md cursor-pointer sm:mt-0 hover:bg-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Tambah Supplier
                </button>
            </div>

            <!-- Fitur Search dan Items per Page -->
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <form action="{{ route('suppliers.index') }}" method="GET" class="flex items-center">
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
                    <form action="{{ route('suppliers.index') }}" method="GET" class="flex items-center">
                        <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                        <input type="text" name="search" id="search"
                            class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ $search }}" placeholder="Search...">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">
                    </form>
                </div>
            </div>
            <!-- End Fitur -->

            @if(session('success'))
                <div id="success-alert"
                    class="relative p-4 mb-6 text-green-700 bg-green-100 border-l-4 border-green-500 rounded-md shadow-sm"
                    role="alert">
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                    <button onclick="document.getElementById('success-alert').style.display='none'"
                        class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="w-6 h-6 text-green-500 fill-current" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </button>
                </div>
            @endif

            <div class="overflow-hidden bg-white dark:bg-gray-500" rounded-lg shadow-lg">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b-2 border-gray-200 dark:bg-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-3">ID</th>
                                <th scope="col" class="px-6 py-3">Nama Supplier</th>
                                <th scope="col" class="px-6 py-3">No.Telpon</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Alamat</th>
                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suppliers as $supplier)
                                <tr class="transition-colors duration-150 bg-white dark:bg-gray-500" border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $supplier->id }}</td>
                                    <td class="px-6 py-4 dark:text-white">{{ $supplier->name }}</td>
                                    <td class="px-6 py-4 dark:text-white">{{ $supplier->phone }}</td>
                                    <td class="px-6 py-4 dark:text-white">{{ $supplier->email }}</td>
                                    <td class="px-6 py-4 dark:text-white">{{ $supplier->address }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button onclick="openEditSupplierModal({{ $supplier->id }})"
                                                class="flex items-center gap-1 font-medium text-blue-600 dark:text-blue-300 hover:text-blue-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L14.732 3.732z" />
                                                </svg>
                                                Edit
                                            </button>

                                            @if($supplier->purchases->count() === 0)
                                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini? Tindakan ini tidak dapat dibatalkan.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="flex items-center gap-1 font-medium text-red-600 hover:text-red-800">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            @else
                                                <span class="flex items-center gap-1 text-gray-400 cursor-not-allowed"
                                                    title="Tidak dapat dihapus karena supplier memiliki data pembelian.">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-10 text-center text-gray-500">
                                        <p class="text-lg font-semibold">Belum ada data supplier.</p>
                                        <p class="mt-1">Silakan tambahkan supplier baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Fitur Pagination -->
            <div class="flex items-center justify-between mt-4">
                <div>
                    @if ($suppliers->total() > 0)
                        <p class="text-sm text-gray-700 dark:text-white">
                            Showing {{ $suppliers->firstItem() }} to {{ $suppliers->lastItem() }} of {{ $suppliers->total() }}
                            entries
                        </p>
                    @endif
                </div>
                <div>
                    @if ($suppliers->hasPages())
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                            {{-- Previous Page Link --}}
                            @if ($suppliers->onFirstPage())
                                <span class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                            @else
                                <a href="{{ $suppliers->previousPageUrl() }}" rel="prev"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                            @endif

                            @php
                                $currentPage = $suppliers->currentPage();
                                $lastPage = $suppliers->lastPage();
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
                                    <span
                                        class="px-3 py-1 mr-1 text-white bg-blue-500 border border-blue-500 rounded">{{ $link }}</span>
                                @else
                                    <a href="{{ $suppliers->url($link) }}"
                                        class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($suppliers->hasMorePages())
                                <a href="{{ $suppliers->nextPageUrl() }}" rel="next"
                                    class="px-3 py-1 ml-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Next</a>
                            @else
                                <span class="px-3 py-1 ml-1 text-gray-400 bg-white border rounded cursor-not-allowed">Next</span>
                            @endif
                        </nav>
                    @endif
                </div>
            </div>
            <!-- End Fitur Pagination -->
        </div>
    </div>

    <div id="supplierModal" x-data="{ showModal: false, editMode: false, supplier: {} }" x-cloak x-show="showModal"
        @keydown.escape.window="showModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center" style="display: none; background-color: rgba(0, 0, 0, 0.5);">

        <div @click.away="showModal = false" class="w-full max-w-lg mx-4 bg-white rounded-lg shadow-2xl">
            <div class="flex items-center justify-between p-4 border-b">
                <h2 class="text-xl font-semibold text-gray-800"
                    x-text="editMode ? 'Edit Supplier' : 'Tambah Supplier Baru'"></h2>
                <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>

            <form :action="editMode ? `/suppliers/${supplier.id}` : '{{ route('suppliers.store') }}'" method="POST"
                class="p-6">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="mb-4">
                    <label for="name" class="block mb-1 text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" id="name" name="name" x-model="supplier.name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="PT. Sinar Jaya" required>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block mb-1 text-sm font-medium text-gray-700">Phone</label>
                    <input type="number" id="phone" name="phone" x-model="supplier.phone"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="081211111111" required>
                </div>

                <div class="mb-6">
                    <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" x-model="supplier.email"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="contoh@sinarjaya.com">
                </div>

                <div class="mb-6">
                    <label for="address" class="block mb-1 text-sm font-medium text-gray-700">Alamat</label>
                    <input type="text" id="address" name="address" x-model="supplier.address"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Jl. Contoh">
                </div>

                <div class="flex justify-end gap-4">
                    <button type="button" @click="showModal = false"
                        class="px-4 py-2 text-gray-800 transition-colors bg-gray-200 rounded-md hover:bg-gray-300">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-white transition-colors bg-blue-600 rounded-md hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditSupplierModal(id) {
            fetch(`/suppliers/${id}/edit`)
                .then(res => res.json())
                .then(data => {
                    const modalComponent = document.getElementById('supplierModal');
                    const modalData = Alpine.$data(modalComponent);
                    modalData.supplier = data;
                    modalData.editMode = true;
                    modalData.showModal = true;
                });
        }

        function openAddSupplierModal() {
            const modalComponent = document.getElementById('supplierModal');
            const modalData = Alpine.$data(modalComponent);

            // Reset to empty for a new supplier
            modalData.supplier = { name: '', phone: '', email: '', address: '' };
            modalData.editMode = false;
            modalData.showModal = true;
        }
    </script>
@endsection