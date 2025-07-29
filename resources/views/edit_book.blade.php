{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Buku</h2>
    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3"><label>Judul</label><input type="text" name="title" value="{{ $book->title }}"
                class="form-control" required></div>
        <div class="mb-3">
            <label>Gambar (biarkan kosong jika tidak diganti)</label>
            <input type="file" name="image" class="form-control">
            <img src="{{ asset('storage/' . $book->image_url) }}" width="100" class="mt-2">
        </div>
        <div class="mb-3"><label>Penulis</label><input type="text" name="author" value="{{ $book->author }}"
                class="form-control" required></div>
        <div class="mb-3"><label>Stok</label><input type="number" name="stock" value="{{ $book->stock }}"
                class="form-control" required></div>
        <div class="mb-3"><label>Deskripsi</label><textarea name="description" class="form-control"
                required>{{ $book->description }}</textarea></div>
        <div class="mb-3">
            <label>Kategori</label>
            <select name="category_id" class="form-control">
                @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ $book->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                </option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">✏️ Edit Buku</h2>

    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium text-gray-700">Judul</label>
            <input type="text" name="title" value="{{ $book->title }}" required
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label class="block font-medium text-gray-700">Gambar (biarkan kosong jika tidak diganti)</label>
            <input type="file" name="image"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <img src="{{ asset('storage/' . $book->image_url) }}" alt="book image" class="mt-3 w-32 rounded">
        </div>

        <div>
            <label class="block font-medium text-gray-700">Penulis</label>
            <input type="text" name="author" value="{{ $book->author }}" required
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label class="block font-medium text-gray-700">Stok</label>
            <input type="number" name="stock" value="{{ $book->stock }}" required
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label class="block font-medium text-gray-700">Deskripsi</label>
            <textarea name="description" required
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ $book->description }}</textarea>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Durasi Pinjam</label>
            <input type="number" name="loan_duration" value="{{ $book->loan_duration }}" required
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label class="block font-medium text-gray-700">Kategori</label>
            <select name="category_id"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ $book->category_id == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
                @endforeach
            </select>
        </div>

        <button type="submit"
            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
            ✅ Update
        </button>
    </form>
</div>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Buku</h2>

        <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium text-gray-700">Judul</label>
                <input type="text" name="title" value="{{ $book->title }}" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Gambar (biarkan kosong jika tidak diganti)</label>
                <input type="file" name="image" id="imageInput"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">

                <!-- Preview Gambar -->
                <img id="imagePreview"
                    src="{{ $book->image_url ? asset('storage/' . $book->image_url) : asset('assets/images/avatar.png') }}"
                    alt="book image" class="mt-3 w-32 rounded">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Penulis</label>
                <input type="text" name="author" value="{{ $book->author }}" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Stok</label>
                <input type="number" name="stock" value="{{ $book->stock }}" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ $book->description }}</textarea>
            </div>

            <div>
                <label class="block font-medium text-gray-700">Durasi Pinjam</label>
                <input type="number" name="loan_duration" value="{{ $book->loan_duration }}" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block font-medium text-gray-700">Kategori</label>
                <select name="category_id"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $book->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
                Update
            </button>
        </form>
    </div>

    <!-- Script Preview Gambar Baru -->
    <script>
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                }

                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10 bg-white shadow-lg rounded-xl">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">✏️ Edit Buku</h2>

    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Buku</label>
            <input type="text" name="title" value="{{ $book->title }}" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar (kosongkan jika tidak diubah)</label>
            <input type="file" name="image" id="imageInput"
                   class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
            <div class="mt-4">
                <img id="imagePreview"
                     src="{{ $book->image_url ? asset('storage/' . $book->image_url) : asset('assets/images/avatar.png') }}"
                     alt="Preview Gambar"
                     class="w-40 h-52 object-contain rounded-md shadow-md" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Penulis</label>
                <input type="text" name="author" value="{{ $book->author }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Stok Buku</label>
                <input type="number" name="stock" value="{{ $book->stock }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="4" required
                      class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">{{ $book->description }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Durasi Pinjam (hari)</label>
                <input type="number" name="loan_duration" value="{{ $book->loan_duration }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                <select name="category_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $book->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="pt-6 text-right">
            <button type="submit"
                    class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-md shadow-md transition duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 13l4 4L19 7" />
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<!-- Script Preview Gambar Baru -->
<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            }

            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
