<?php

// namespace App\Http\Controllers;

// use App\Models\Book;
// use App\Models\Loan;
// use App\Models\Reservation;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Auth;

// class ReservationController extends Controller
// {
//     /**
//      * Menampilkan daftar reservasi milik pengguna yang sedang login.
//      */
//     public function index()
//     {
//         $reservations = Reservation::where('user_id', Auth::id())
//             ->with('book')
//             ->orderBy('created_at', 'desc')
//             ->get();

//         return view('reservations', compact('reservations'));
//     }

//     /**
//      * Menyimpan reservasi baru.
//      */
//     public function store(Request $request)
//     {
//         $request->validate(['book_id' => 'required|exists:books,id']);

//         $book = Book::findOrFail($request->book_id);
//         $user = Auth::user();

//         // 1. Cek apakah stok buku masih ada
//         if ($book->stock > 0) {
//             return back()->with('error', 'Buku ini masih tersedia dan bisa langsung dipinjam, tidak perlu reservasi.');
//         }

//         // 2. Cek apakah user sudah punya pinjaman aktif untuk buku ini
//         $hasActiveLoan = Loan::where('user_id', $user->id)
//             ->where('book_id', $book->id)
//             ->where('status', 'borrowed')
//             ->exists();

//         if ($hasActiveLoan) {
//             return back()->with('error', 'Anda sudah meminjam buku ini.');
//         }

//         // 3. Cek apakah user sudah punya reservasi aktif untuk buku ini
//         $hasActiveReservation = Reservation::where('user_id', $user->id)
//             ->where('book_id', $book->id)
//             ->whereIn('status', ['pending', 'available'])
//             ->exists();

//         if ($hasActiveReservation) {
//             return back()->with('error', 'Anda sudah memiliki reservasi untuk buku ini.');
//         }

//         // Menggunakan transaction untuk menjaga konsistensi data
//         DB::transaction(function () use ($book, $user) {
//             // Cari posisi antrian terakhir untuk buku ini
//             $lastQueuePosition = Reservation::where('book_id', $book->id)
//                 ->where('status', 'pending')
//                 ->max('queue_position');

//             Reservation::create([
//                 'user_id' => $user->id,
//                 'book_id' => $book->id,
//                 'queue_position' => $lastQueuePosition + 1,
//                 'status' => 'pending',
//             ]);
//         });

//         return redirect()->route('reservations.index')->with('success', 'Anda berhasil masuk ke dalam antrian untuk buku ' . $book->title);
//     }

//     /**
//      * Membatalkan reservasi.
//      */
//     public function destroy(Reservation $reservation)
//     {
//         // Pastikan hanya pemilik reservasi yang bisa membatalkan
//         if ($reservation->user_id !== Auth::id()) {
//             abort(403, 'Unauthorized action.');
//         }

//         // Hanya reservasi yang 'pending' atau 'available' yang bisa dibatalkan
//         if (!in_array($reservation->status, ['pending', 'available'])) {
//             return back()->with('error', 'Reservasi ini tidak dapat dibatalkan.');
//         }

//         $book = $reservation->book;
//         $queuePosition = $reservation->queue_position;

//         DB::transaction(function() use ($reservation, $book, $queuePosition) {
//             $reservation->update(['status' => 'cancelled']);

//             // Update posisi antrian untuk user lain di belakangnya
//             Reservation::where('book_id', $book->id)
//                 ->where('status', 'pending')
//                 ->where('queue_position', '>', $queuePosition)
//                 ->decrement('queue_position');
//         });

//         return back()->with('success', 'Reservasi berhasil dibatalkan.');
//     }
// }

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
        // $user = Auth::user();

        // // Siapkan query dasar dengan eager loading untuk relasi book dan user
        // $reservationsQuery = Reservation::with(['book', 'user'])
        //     ->orderBy('created_at', 'desc');

        // // Cek peran pengguna yang sedang login
        // if ($user->usertype === 'admin') {
        //     // Jika admin, tampilkan semua reservasi dari pengguna yang bertipe 'user'
        //     $reservations = $reservationsQuery->whereHas('user', function ($query) {
        //         $query->where('usertype', 'user');
        //     })->get();
        // } else {
        //     // Jika bukan admin (adalah user), tampilkan hanya reservasinyanya sendiri
        //     $reservations = $reservationsQuery->where('user_id', $user->id)->get();
        // }

        // return view('reservations', compact('reservations'));

        $user = Auth::user();

        // Siapkan query dasar dengan eager loading untuk relasi book dan user
        $reservationsQuery = Reservation::with(['book', 'user'])->orderBy('created_at', 'desc');

        // Mengambil nilai 'search' dari request, defaultnya string kosong
        $search = $request->input('search', '');

        // Mengambil nilai 'per_page' dari request, defaultnya 10
        // dan memastikan nilainya adalah integer
        $perPage = (int) $request->input('per_page', 5);

        // Memulai query pada model Category
        // $query = Category::query();
        // $query = Category::with('books');

        // Jika ada keyword pencarian, tambahkan kondisi where
        if (!empty($search)) {
            $reservationsQuery->where(function ($q) use ($search) {
                $q->where('status', 'like', "%{$search}%")
                    ->orWhereHas('book', function ($q2) use ($search) {
                        $q2->where('title', 'like', "%{$search}%");
                        $q2->orWhere('author', 'like', "%{$search}%");
                    })->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                        $q2->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Cek peran pengguna yang sedang login
        if ($user->usertype === 'admin') {
            // Jika admin, tampilkan semua reservasi dari pengguna yang bertipe 'user'
            $reservations = $reservationsQuery->whereHas('user', function ($query) {
                $query->where('usertype', 'user');
            })->get();
        } else {
            // Jika bukan admin (adalah user), tampilkan hanya reservasinyanya sendiri
            $reservations = $reservationsQuery->where('user_id', $user->id)->get();
        }

        // Lakukan pagination pada hasil query
        // 'appends' digunakan agar parameter 'search' dan 'per_page' tetap ada di URL pagination
        $reservations = $reservationsQuery->paginate($perPage)->appends($request->except('page'));

        // Kembalikan view 'categories.category' dengan data categories, search, dan perPage
        return view('reservations', compact('reservations', 'search', 'perPage'));
    }

    // Method store() dan destroy() tidak perlu diubah
    // ...
    // ... (kode method store dan destroy Anda tetap di sini) ...
    // ...

    /**
     * Menyimpan reservasi baru.
     */
    public function store(Request $request)
    {
        $request->validate(['book_id' => 'required|exists:books,id']);

        $book = Book::findOrFail($request->book_id);
        $user = Auth::user();

        // 1. Cek apakah stok buku masih ada
        if ($book->stock > 0) {
            return back()->with('error', 'Buku ini masih tersedia dan bisa langsung dipinjam, tidak perlu reservasi.');
        }

        // 2. Cek apakah user sudah punya pinjaman aktif untuk buku ini
        $hasActiveLoan = Loan::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->exists();

        if ($hasActiveLoan) {
            return back()->with('error', 'Anda sudah meminjam buku ini.');
        }

        // 3. Cek apakah user sudah punya reservasi aktif untuk buku ini
        $hasActiveReservation = Reservation::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'available'])
            ->exists();

        if ($hasActiveReservation) {
            return back()->with('error', 'Anda sudah memiliki reservasi untuk buku ini.');
        }

        // Menggunakan transaction untuk menjaga konsistensi data
        DB::transaction(function () use ($book, $user) {
            // Cari posisi antrian terakhir untuk buku ini
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
        // Pastikan hanya pemilik reservasi yang bisa membatalkan
        if ($reservation->user_id !== Auth::id()) {
            // Admin juga tidak bisa membatalkan lewat sini, harus ada fitur khusus jika diperlukan
            abort(403, 'Unauthorized action.');
        }

        // Hanya reservasi yang 'pending' atau 'available' yang bisa dibatalkan
        if (!in_array($reservation->status, ['pending', 'available'])) {
            return back()->with('error', 'Reservasi ini tidak dapat dibatalkan.');
        }

        $book = $reservation->book;
        $queuePosition = $reservation->queue_position;

        DB::transaction(function () use ($reservation, $book, $queuePosition) {
            $reservation->update(['status' => 'cancelled']);

            // Update posisi antrian untuk user lain di belakangnya
            Reservation::where('book_id', $book->id)
                ->where('status', 'pending')
                ->where('queue_position', '>', $queuePosition)
                ->decrement('queue_position');
        });

        return back()->with('success', 'Reservasi berhasil dibatalkan.');
    }
}