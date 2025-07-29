<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    /**
     * BARU: Metode untuk menampilkan detail kategori beserta bukunya.
     */
    public function show(string $id)
    {
        try {
            // Menggunakan with('books') untuk Eager Loading
            $category = Category::with('books')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $category,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
            ], 404);
        }
    }
}
