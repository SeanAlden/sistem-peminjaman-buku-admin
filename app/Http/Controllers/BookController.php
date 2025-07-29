<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->get();
        return view('book', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('add_book', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            // 'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'author' => 'required',
            'stock' => 'required|integer|min:0',
            'description' => 'required',
            'loan_duration' => 'required|integer|min:5',
            'category_id' => 'required|exists:categories,id',
        ]);

        // $imagePath = $request->file('image')->store('book_images', 'public');
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('book_images', 'public');
        }

        Book::create([
            'title' => $request->title,
            'image_url' => $imagePath,
            'author' => $request->author,
            'stock' => $request->stock,
            'description' => $request->description,
            'loan_duration' => $request->loan_duration,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show($id)
    {
        $book = Book::with('category')->findOrFail($id);
        return view('book_detail', compact('book'));
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all();
        return view('edit_book', compact('book', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title' => 'required',
            // 'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'author' => 'required',
            'stock' => 'required|integer|min:0',
            'description' => 'required',
            'loan_duration' => 'required|integer|min:5',
            'category_id' => 'required|exists:categories,id',
        ]);

        $imagePath = $book->image_url;

        // if ($request->hasFile('image')) {
        //     Storage::disk('public')->delete($book->image_url);
        //     $imagePath = $request->file('image')->store('book_images', 'public');
        // }

        if ($request->hasFile('image')) {
            if ($book->image_url && Storage::disk('public')->exists($book->image_url)) {
                Storage::disk('public')->delete($book->image_url);
            }

            $imagePath = $request->file('image')->store('book_images', 'public');
        }

        $book->update([
            'title' => $request->title,
            'image_url' => $imagePath,
            'author' => $request->author,
            'stock' => $request->stock,
            'description' => $request->description,
            'loan_duration' => $request->loan_duration,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diupdate.');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        if ($book->image_url && Storage::disk('public')->exists($book->image_url)) {
            Storage::disk('public')->delete($book->image_url);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }
}

