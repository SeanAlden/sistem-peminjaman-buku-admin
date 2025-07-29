@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-3xl font-bold text-gray-800">📚 Daftar Kategori</h1>
            <a href="{{ route('categories.create') }}"
                class="inline-block bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2 rounded-lg shadow transition duration-300">
                + Tambah Kategori
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                {{ session('error') }}
            </div>
        @endif


        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full bg-white divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Buku dalam Kategori</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-gray-50">
                            {{-- <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $category->description }}
                            </td> --}}

                            {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ $category->name }}
                            </td> --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:underline font-medium">
                                <a href="{{ route('categories.show', $category->id) }}">
                                    {{ $category->name }}
                                </a>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ \Illuminate\Support\Str::limit($category->description, 20, '...') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                @if ($category->books->count())
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach ($category->books as $book)
                                            <li>{{ $book->title }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="italic text-gray-400">Tidak ada buku</span>
                                @endif
                            </td>
                            {{-- <td class="px-6 py-4 flex flex-col sm:flex-row gap-2 text-sm">
                                <a href="{{ route('categories.edit', $category->id) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium transition">Edit</a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus kategori ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition">
                                        Hapus
                                    </button>
                                </form>
                            </td> --}}
                            <td class="px-6 py-4 flex flex-col sm:flex-row gap-2 text-sm">
                                <a href="{{ route('categories.edit', $category->id) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium transition">Edit</a>

                                @if ($category->books->count() === 0)
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition">
                                            Hapus
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="text-gray-400 cursor-not-allowed font-medium"
                                        title="Kategori memiliki buku, tidak bisa dihapus" disabled>
                                        Hapus
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 italic">
                                Tidak ada kategori tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection