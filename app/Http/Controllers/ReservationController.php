<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Menampilkan daftar reservasi berdasarkan peran pengguna.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $reservationsQuery = Reservation::with(['book', 'user'])->orderBy('created_at', 'desc');

        $search = $request->input('search', '');

        $perPage = (int) $request->input('per_page', 5);

        if (!empty($search)) {
            $reservationsQuery->where(function ($q) use ($search) {
                $q
                    ->where('status', 'like', "%{$search}%")
                    ->orWhereHas('book', function ($q2) use ($search) {
                        $q2->where('title', 'like', "%{$search}%");
                        $q2->orWhere('author', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                        $q2->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($user->usertype === 'admin') {
            $reservations = $reservationsQuery->whereHas('user', function ($query) {
                $query->where('usertype', 'user');
            })->get();
        } else {
            $reservations = $reservationsQuery->where('user_id', $user->id)->get();
        }

        $reservations = $reservationsQuery->paginate($perPage)->appends($request->except('page'));

        return view('reservations', compact('reservations', 'search', 'perPage'));
    }

    /**
     * Menyimpan reservasi baru.
     */
    public function store(Request $request)
    {
        $request->validate(['book_id' => 'required|exists:books,id']);

        $book = Book::findOrFail($request->book_id);
        $user = Auth::user();

        if ($book->stock > 0) {
            return back()->with('error', 'Buku ini masih tersedia dan bisa langsung dipinjam, tidak perlu reservasi.');
        }

        $hasActiveLoan = Loan::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->exists();

        if ($hasActiveLoan) {
            return back()->with('error', 'Anda sudah meminjam buku ini.');
        }

        $hasActiveReservation = Reservation::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'available'])
            ->exists();

        if ($hasActiveReservation) {
            return back()->with('error', 'Anda sudah memiliki reservasi untuk buku ini.');
        }

        DB::transaction(function () use ($book, $user) {
            $lastQueuePosition = Reservation::where('book_id', $book->id)
                ->where('status', 'pending')
                ->max('queue_position');

            Reservation::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'queue_position' => $lastQueuePosition + 1,
                'status' => 'pending',
            ]);
        });

        return redirect()->route('reservations.index')->with('success', 'Anda berhasil masuk ke dalam antrian untuk buku ' . $book->title);
    }

    /**
     * Membatalkan reservasi.
     */
    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!in_array($reservation->status, ['pending', 'available'])) {
            return back()->with('error', 'Reservasi ini tidak dapat dibatalkan.');
        }

        $book = $reservation->book;
        $queuePosition = $reservation->queue_position;

        DB::transaction(function () use ($reservation, $book, $queuePosition) {
            $reservation->update(['status' => 'cancelled']);

            Reservation::where('book_id', $book->id)
                ->where('status', 'pending')
                ->where('queue_position', '>', $queuePosition)
                ->decrement('queue_position');
        });

        return back()->with('success', 'Reservasi berhasil dibatalkan.');
    }
}
