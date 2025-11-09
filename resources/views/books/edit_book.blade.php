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
<div class="max-w-2xl px-4 py-8 mx-auto">
    <h2 class="mb-6 text-2xl font-bold text-gray-800">✏️ Edit Buku</h2>

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
            <img src="{{ asset('storage/' . $book->image_url) }}" alt="book image" class="w-32 mt-3 rounded">
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
            class="px-4 py-2 font-semibold text-white transition duration-300 bg-green-600 rounded hover:bg-green-700">
            ✅ Update
        </button>
    </form>
</div>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
<div class="max-w-2xl px-4 py-8 mx-auto">
    <h2 class="mb-6 text-2xl font-bold text-gray-800">Edit Buku</h2>

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
                alt="book image" class="w-32 mt-3 rounded">
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
            class="px-4 py-2 font-semibold text-white transition duration-300 bg-green-600 rounded hover:bg-green-700">
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
    <div class="max-w-3xl px-6 py-10 mx-auto bg-white shadow-lg rounded-xl dark:bg-gray-500">
        <h2 class="mb-8 text-3xl font-bold text-center text-gray-800 dark:text-white">✏️ Edit Buku</h2>

        <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-white">Judul Buku</label>
                <input type="text" name="title" value="{{ $book->title }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none dark:text-white">
            </div>

            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-white">Gambar (kosongkan jika tidak
                    diubah)</label>
                <input type="file" name="image" id="imageInput"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none dark:text-white">
                <div class="mt-4">
                    <img id="imagePreview"
                        src="{{ $book->image_url ? Storage::disk('s3')->url($book->image_url) : asset('assets/images/avatar.png') }}"
                        alt="Preview Gambar" class="object-contain w-40 rounded-md shadow-md h-52" />
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-white">Penulis</label>
                    <input type="text" name="author" value="{{ $book->author }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none dark:text-white">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-white">Stok Buku</label>
                    <input type="number" name="stock" value="{{ $book->stock }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none dark:text-white">
                </div>
            </div>

            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-white">Deskripsi</label>
                <textarea name="description" rows="4" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none dark:text-white">{{ $book->description }}</textarea>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-white">Durasi Pinjam
                        (hari)</label>
                    <input type="number" name="loan_duration" value="{{ $book->loan_duration }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none dark:text-white">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-white">Kategori</label>
                    <select name="category_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none dark:text-white dark:bg-gray-500">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $book->category_id == $cat->id ? 'selected' : '' }}
                                class="dark:text-white">
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pt-6 text-right">
                <button type="submit"
                    class="inline-flex items-center px-6 py-2 font-medium text-white transition duration-300 bg-green-600 rounded-md shadow-md hover:bg-green-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
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