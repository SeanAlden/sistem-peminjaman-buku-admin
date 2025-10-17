{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Buku</h2>
    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3"><label>Judul</label><input type="text" name="title" class="form-control" required></div>
        <div class="mb-3"><label>Gambar</label><input type="file" name="image" class="form-control" required></div>
        <div class="mb-3"><label>Penulis</label><input type="text" name="author" class="form-control" required></div>
        <div class="mb-3"><label>Stok</label><input type="number" name="stock" class="form-control" required></div>
        <div class="mb-3"><label>Deskripsi</label><textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Kategori</label>
            <select name="category_id" class="form-control">
                @foreach ($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection --}}


{{-- @extends('layouts.app')

@section('content')
    <div class="max-w-2xl px-4 py-8 mx-auto">
        <h2 class="mb-6 text-2xl font-bold text-gray-800">📘 Tambah Buku</h2>

        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium text-gray-700">Judul</label>
                <input type="text" name="title" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Gambar</label>
                <input type="file" name="image"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">

                <!-- PREVIEW GAMBAR -->
                <img id="imagePreview" class="hidden w-32 mt-3 rounded" alt="Preview Gambar" />
            </div>

            <div>
                <label class="block font-medium text-gray-700">Penulis</label>
                <input type="text" name="author" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Stok</label>
                <input type="number" name="stock" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Durasi Pinjam</label>
                <input type="number" name="loan_duration" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Kategori</label>
                <select name="category_id"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                class="px-4 py-2 font-semibold text-white transition duration-300 bg-blue-600 rounded hover:bg-blue-700">
                💾 Simpan
            </button>
        </form>
    </div>
    <script>
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                }

                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '';
                imagePreview.classList.add('hidden');
            }
        });
    </script>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
<div class="max-w-2xl px-4 py-8 mx-auto">
    <h2 class="mb-6 text-2xl font-bold text-gray-800">Tambah Buku</h2>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium text-gray-700">Judul</label>
            <input type="text" name="title" required
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label class="block font-medium text-gray-700">Gambar</label>
            <input type="file" name="image" id="imageInput"
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <!-- Preview Gambar -->
            <img id="imagePreview" class="hidden w-32 mt-3 rounded" alt="Preview Gambar"/>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Penulis</label>
            <input type="text" name="author" required
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label class="block font-medium text-gray-700">Stok</label>
            <input type="number" name="stock" required
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label class="block font-medium text-gray-700">Deskripsi</label>
            <textarea name="description" required
                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Durasi Pinjam</label>
            <input type="number" name="loan_duration" required
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label class="block font-medium text-gray-700">Kategori</label>
            <select name="category_id"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit"
                class="px-4 py-2 font-semibold text-white transition duration-300 bg-blue-600 rounded hover:bg-blue-700">
            Simpan
        </button>
    </form>
</div>

<!-- Script Preview Gambar -->
<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
            }

            reader.readAsDataURL(file);
        } else {
            imagePreview.src = '';
            imagePreview.classList.add('hidden');
        }
    });
</script>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="max-w-3xl px-6 py-10 mx-auto bg-white shadow-lg rounded-xl dark:bg-gray-500">
    <h2 class="mb-8 text-3xl font-bold text-center text-gray-800 dark:text-white">📖 Tambah Buku Baru</h2>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-white">Judul Buku</label>
            <input type="text" name="title" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none dark:text-white">
        </div>

        <div>
            <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-white">Gambar Sampul</label>
            <input type="file" name="image" id="imageInput"
                   class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none dark:text-white">
            <div class="mt-4">
                <img id="imagePreview" class="hidden object-contain w-40 rounded-md shadow-md h-52" alt="Preview Gambar" />
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-white">Penulis</label>
                <input type="text" name="author" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none dark:text-white">
            </div>

            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-white">Stok Buku</label>
                <input type="number" name="stock" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none dark:text-white">
            </div>
        </div>

        <div>
            <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-white">Deskripsi</label>
            <textarea name="description" rows="4" required
                      class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none dark:text-white"></textarea>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-white">Durasi Pinjam (hari)</label>
                <input type="number" name="loan_duration" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none dark:text-white">
            </div>

            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-white">Kategori</label>
                <select name="category_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-500 focus:ring focus:ring-blue-200 focus:outline-none dark:text-white">
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="pt-6 text-right">
            <button type="submit"
                    class="inline-flex items-center px-6 py-2 font-medium text-white transition duration-300 bg-blue-600 rounded-md shadow-md hover:bg-blue-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 13l4 4L19 7" />
                </svg>
                Simpan Buku
            </button>
        </div>
    </form>
</div>

<!-- Script Preview Gambar -->
<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
            }

            reader.readAsDataURL(file);
        } else {
            imagePreview.src = '';
            imagePreview.classList.add('hidden');
        }
    });
</script>
@endsection

