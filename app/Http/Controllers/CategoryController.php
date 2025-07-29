<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan daftar kategori
    public function index()
    {
        $categories = Category::all();
        $categories = Category::with('books')->get();
        return view('categories.category', compact('categories'));
    }

    // Form tambah kategori
    public function create()
    {
        return view('categories.add_category');
    }

    // Menampilkan detail kategori dan buku-bukunya
    public function show($id)
    {
        $category = Category::with('books')->findOrFail($id);
        return view('categories.category_detail', compact('category'));
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories',
            'description' => 'required',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Form edit kategori
    public function edit(Category $category)
    {
        return view('categories.edit_category', compact('category'));
    }

    // Simpan hasil edit
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'description' => 'required',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    // Hapus kategori
    public function destroy(Category $category)
    {
        if ($category->books()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki buku.');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
