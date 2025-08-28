<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Reservation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BookDetailController extends Controller
{
    /**
     * Mengambil detail buku lengkap dengan status user (dipinjam/reservasi).
     * Ini adalah satu-satunya endpoint yang harus dipanggil oleh BookDetailScreen.jsx.
     */
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
