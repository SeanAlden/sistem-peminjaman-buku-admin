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
    <div class="max-w-2xl mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">📘 Tambah Buku</h2>

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
                <img id="imagePreview" class="mt-3 w-32 rounded hidden" alt="Preview Gambar" />
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
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
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
<div class="max-w-2xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Buku</h2>

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
            <img id="imagePreview" class="mt-3 w-32 rounded hidden" alt="Preview Gambar"/>
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
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
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
<div class="max-w-3xl mx-auto px-6 py-10 bg-white shadow-lg rounded-xl">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">📖 Tambah Buku Baru</h2>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Buku</label>
            <input type="text" name="title" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar Sampul</label>
            <input type="file" name="image" id="imageInput"
                   class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
            <div class="mt-4">
                <img id="imagePreview" class="w-40 h-52 object-contain rounded-md hidden shadow-md" alt="Preview Gambar" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Penulis</label>
                <input type="text" name="author" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Stok Buku</label>
                <input type="number" name="stock" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="4" required
                      class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none"></textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Durasi Pinjam (hari)</label>
                <input type="number" name="loan_duration" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                <select name="category_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="pt-6 text-right">
            <button type="submit"
                    class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md shadow-md transition duration-300">
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

