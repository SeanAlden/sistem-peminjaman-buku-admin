<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->get();

        // Tambahkan full URL ke image
        foreach ($books as $book) {
            $book->image_url = asset('storage/' . $book->image_url);
        }

        return response()->json([
            'success' => true,
            'data' => $books,
        ]);
    }
}
