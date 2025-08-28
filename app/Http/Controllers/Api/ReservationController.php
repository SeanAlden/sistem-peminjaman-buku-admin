<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // Menampilkan daftar reservasi milik user
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->with('book:id,title,image_url') // Ambil hanya data buku yang perlu
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['success' => true, 'data' => $reservations]);
    }

    public function show($id)
    {
        $user = Auth::guard('sanctum')->user();
        $book = Book::with('category')->find($id);

        if (!$book) {
            return response()->json(['success' => false, 'message' => 'Buku tidak ditemukan'], 404);
        }

        $book->image_url = asset('storage/' . $book->image_url);

        if ($user) {
            // Cek pinjaman aktif
            $book->is_borrowed_by_user = Loan::where('user_id', $user->id)
                ->where('book_id', $book->id)
                ->where('status', 'borrowed')
                ->exists();

            // --- PERUBAHAN DI SINI ---
            // 1. Cari data reservasi aktif, bukan hanya cek keberadaannya
            $activeReservation = Reservation::where('user_id', $user->id)
                ->where('book_id', $book->id)
                ->whereIn('status', ['pending', 'available'])
                ->first(); // Gunakan first() untuk mendapatkan objeknya

            // 2. Set flag dan ID berdasarkan hasil pencarian
            $book->has_active_reservation_by_user = !is_null($activeReservation);
            $book->active_reservation_id = $activeReservation ? $activeReservation->id : null;

        } else {
            $book->is_borrowed_by_user = false;
            $book->has_active_reservation_by_user = false;
            $book->active_reservation_id = null;
        }

        return response()->json([
            'success' => true,
            'data' => $book,
        ]);
    }

    // Membuat reservasi baru
    public function store(Request $request)
    {
        $request->validate(['book_id' => 'required|exists:books,id']);

        $book = Book::findOrFail($request->book_id);
        $user = Auth::user();

        if ($book->stock > 0) {
            return response()->json(['success' => false, 'message' => 'Buku ini masih tersedia dan bisa langsung dipinjam.'], 400);
        }

        $hasActiveLoan = Loan::where('user_id', $user->id)->where('book_id', $book->id)->where('status', 'borrowed')->exists();
        if ($hasActiveLoan) {
            return response()->json(['success' => false, 'message' => 'Anda sudah meminjam buku ini.'], 400);
        }

        $hasActiveReservation = Reservation::where('user_id', $user->id)->where('book_id', $book->id)->whereIn('status', ['pending', 'available'])->exists();
        if ($hasActiveReservation) {
            return response()->json(['success' => false, 'message' => 'Anda sudah memiliki reservasi untuk buku ini.'], 400);
        }

        $reservation = DB::transaction(function () use ($book, $user) {
            $lastQueuePosition = Reservation::where('book_id', $book->id)->where('status', 'pending')->max('queue_position');
            return Reservation::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'queue_position' => $lastQueuePosition + 1,
            ]);
        });

        return response()->json(['success' => true, 'message' => 'Reservasi berhasil, Anda masuk dalam antrian.', 'data' => $reservation], 201);
    }

    // Membatalkan reservasi
    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        if (!in_array($reservation->status, ['pending', 'available'])) {
            return response()->json(['success' => false, 'message' => 'Reservasi ini tidak dapat dibatalkan.'], 400);
        }

        DB::transaction(function () use ($reservation) {
            $bookId = $reservation->book_id;
            $queuePos = $reservation->queue_position;

            $reservation->update(['status' => 'cancelled']);

            Reservation::where('book_id', $bookId)
                ->where('status', 'pending')
                ->where('queue_position', '>', $queuePos)
                ->decrement('queue_position');
        });

        return response()->json(['success' => true, 'message' => 'Reservasi berhasil dibatalkan.']);
    }
}