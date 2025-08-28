<?php

namespace App\Http\Controllers\API;

use Auth;
use App\Models\Loan;
use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // public function index()
    // {
    //     $books = Book::where('status', 'active')->with('category')->get();

    //     // Tambahkan full URL ke image
    //     foreach ($books as $book) {
    //         $book->image_url = asset('storage/' . $book->image_url);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'data' => $books,
    //     ]);
    // }

    public function index(Request $request)
    {
        $user = Auth::guard('sanctum')->user(); // gunakan auth via sanctum

        $books = Book::where('status', 'active')->with('category')->get();

        foreach ($books as $book) {
            $book->image_url = asset('storage/' . $book->image_url);

            if ($user) {
                // Cek apakah user sedang meminjam buku ini
                $book->is_borrowed = Loan::where('user_id', $user->id)
                    ->where('book_id', $book->id)
                    ->where('status', 'borrowed') // jika kamu menyimpan status
                    ->exists();
            } else {
                $book->is_borrowed = false;
            }
        }

        return response()->json([
            'success' => true,
            'data' => $books,
        ]);
    }

    // public function show($id)
    // {
    //     $user = Auth::guard('sanctum')->user();

    //     $book = Book::with('category')->find($id);

    //     if (!$book) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Buku tidak ditemukan',
    //         ], 404);
    //     }

    //     // Tambahkan URL gambar lengkap
    //     $book->image_url = asset('storage/' . $book->image_url);

    //     // Cek apakah user sedang meminjam buku ini
    //     if ($user) {
    //         $book->is_borrowed = Loan::where('user_id', $user->id)
    //             ->where('book_id', $book->id)
    //             ->where('status', 'borrowed')
    //             ->exists();
    //     } else {
    //         $book->is_borrowed = false;
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'data' => $book,
    //     ]);
    // }

    public function show($id)
    {
        $user = Auth::guard('sanctum')->user();
        $book = Book::with('category')->find($id);

        if (!$book) {
            return response()->json(['success' => false, 'message' => 'Buku tidak ditemukan'], 404);
        }

        $book->image_url = asset('storage/' . $book->image_url);

        if ($user) {
            // Cek apakah user sedang meminjam buku ini
            $book->is_borrowed_by_user = Loan::where('user_id', $user->id)
                ->where('book_id', $book->id)
                ->where('status', 'borrowed')
                ->exists();

            // Cek apakah user memiliki reservasi aktif untuk buku ini
            $book->has_active_reservation_by_user = Reservation::where('user_id', $user->id)
                ->where('book_id', $book->id)
                ->whereIn('status', ['pending', 'available'])
                ->exists();
        } else {
            // Default value jika tidak ada user yang login
            $book->is_borrowed_by_user = false;
            $book->has_active_reservation_by_user = false;
        }

        return response()->json([
            'success' => true,
            'data' => $book,
        ]);
    }
}
