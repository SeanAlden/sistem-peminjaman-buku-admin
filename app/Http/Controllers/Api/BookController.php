<?php

namespace App\Http\Controllers\API;

use Auth;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // public function index(Request $request)
    // {
    //     $user = Auth::guard('sanctum')->user();

    //     $books = Book::where('status', 'active')->with('category')->get();

    //     foreach ($books as $book) {
    //         $book->image_url = asset('storage/' . $book->image_url);

    //         if ($user) {
    //             $book->is_borrowed = Loan::where('user_id', $user->id)
    //                 ->where('book_id', $book->id)
    //                 ->where('status', 'borrowed')
    //                 ->exists();
    //         } else {
    //             $book->is_borrowed = false;
    //         }
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'data' => $books,
    //     ]);
    // }

    // public function index(Request $request)
    // {
    //     $user = Auth::guard('sanctum')->user();
    //     $reservedBookIds = [];

    //     // Jika user login, ambil ID buku yang sedang mereka reservasi
    //     if ($user) {
    //         $reservedBookIds = Reservation::where('user_id', $user->id)
    //             ->whereIn('status', ['pending', 'available'])
    //             ->pluck('book_id') // Ambil hanya kolom book_id
    //             ->toArray(); // Konversi menjadi array
    //     }

    //     $books = Book::where('status', 'active')->with('category')->get();

    //     // Tambahkan atribut custom ke setiap buku
    //     $books->map(function ($book) use ($user, $reservedBookIds) {
    //         // Menambahkan URL gambar yang lengkap
    //         $book->image_url = $book->image_url ? asset('storage/' . $book->image_url) : null;

    //         // Tambahkan flag is_reserved_by_user
    //         $book->is_reserved_by_user = in_array($book->id, $reservedBookIds);

    //         return $book;
    //     });

    //     return response()->json([
    //         'success' => true,
    //         'data' => $books,
    //     ]);
    // }

    public function index(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $reservedBookIds = [];

        // Jika user login, ambil ID buku yang sedang mereka reservasi
        if ($user) {
            $reservedBookIds = Reservation::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'available'])
                ->pluck('book_id') // Ambil hanya kolom book_id
                ->toArray(); // Konversi menjadi array
        }

        $books = Book::where('status', 'active')->with('category')->get();

        // Tambahkan atribut custom ke setiap buku
        $books->map(function ($book) use ($user, $reservedBookIds) {
            // Menambahkan URL gambar yang lengkap
            // $book->image_url = $book->image_url ? asset('storage/' . $book->image_url) : null;
            $book->image_url = $book->image_url ? Storage::disk('s3')->url('book_images/' . $book->image_url) : null;

            // Tambahkan flag is_reserved_by_user
            $book->is_reserved_by_user = in_array($book->id, $reservedBookIds);

            return $book;
        });

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
    //         return response()->json(['success' => false, 'message' => 'Buku tidak ditemukan'], 404);
    //     }

    //     $book->image_url = asset('storage/' . $book->image_url);

    //     if ($user) {
    //         $book->is_borrowed_by_user = Loan::where('user_id', $user->id)
    //             ->where('book_id', $book->id)
    //             ->where('status', 'borrowed')
    //             ->exists();

    //         $book->has_active_reservation_by_user = Reservation::where('user_id', $user->id)
    //             ->where('book_id', $book->id)
    //             ->whereIn('status', ['pending', 'available'])
    //             ->exists();
    //     } else {
    //         $book->is_borrowed_by_user = false;
    //         $book->has_active_reservation_by_user = false;
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'data' => $book,
    //     ]);
    // }

    public function show(Book $book)
    {
        $user = Auth::user();

        // Ambil data dasar buku
        $bookData = $book->load('category');
        $bookData->image_url = asset('storage/' . $bookData->image_url);

        if ($user) {
            // Cek pinjaman aktif
            $bookData->is_borrowed_by_user = Loan::where('user_id', $user->id)
                ->where('book_id', $book->id)
                ->where('status', 'borrowed')
                ->exists();

            // Cari data reservasi aktif
            $activeReservation = Reservation::where('user_id', $user->id)
                ->where('book_id', $book->id)
                ->whereIn('status', ['pending', 'available'])
                ->first();

            // Set flag dan data berdasarkan hasil pencarian reservasi
            $bookData->has_active_reservation_by_user = !is_null($activeReservation);
            $bookData->active_reservation_id = $activeReservation ? $activeReservation->id : null;
            $bookData->active_reservation_status = $activeReservation ? $activeReservation->status : null;

        } else {
            // Default value jika tidak ada user yang login
            $bookData->is_borrowed_by_user = false;
            $bookData->has_active_reservation_by_user = false;
            $bookData->active_reservation_id = null;
            $bookData->active_reservation_status = null;
        }

        return response()->json([
            'success' => true,
            'data' => $bookData,
        ]);
    }
}
