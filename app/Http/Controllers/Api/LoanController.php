<?php

namespace App\Http\Controllers\API;

use App\Models\Loan;
use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Enums\ReturnStatusNote;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class LoanController extends Controller
{

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'book_id' => 'required|exists:books,id',
    //         'loan_date' => 'required|date',
    //         'return_date' => 'required|date|after_or_equal:loan_date',
    //     ]);

    //     $book = Book::find($request->book_id);

    //     if ($book->stock <= 0) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Stok buku tidak mencukupi.',
    //         ], 400);
    //     }

    //     // Simpan ke tabel loans
    //     $loan = Loan::create([
    //         'book_id' => $book->id,
    //         'loan_date' => $request->loan_date,
    //         'return_date' => $request->return_date,
    //         'status' => 'borrowed',
    //     ]);

    //     // Kurangi stok buku
    //     $book->decrement('stock');

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Peminjaman berhasil disimpan.',
    //         'data' => $loan,
    //     ]);
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'book_id' => 'required|exists:books,id',
    //         'return_date' => 'required|date|after_or_equal:today',
    //     ]);

    //     $book = Book::findOrFail($request->book_id);

    //     if ($book->stock <= 0) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Stok buku tidak mencukupi.',
    //         ], 400);
    //     }

    //     $now = Carbon::now(); // real-time
    //     $returnDate = Carbon::parse($request->return_date)->setTime(16, 59, 59); // jam otomatis 23:59:59
    //     $loanDuration = $book->loan_duration;
    //     $maxReturnedAt = $now->copy()->addDays($loanDuration)->setTime(16, 59, 59); // max_returned_at

    //     $loan = Loan::create([
    //         'book_id' => $book->id,
    //         'user_id' => auth()->id(),
    //         'loan_date' => $now,
    //         'return_date' => $returnDate,
    //         'status' => 'borrowed',
    //         'loan_duration' => $loanDuration,
    //         'max_returned_at' => $maxReturnedAt, // tambahkan ini
    //     ]);

    //     $book->decrement('stock');

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Peminjaman berhasil disimpan.',
    //         'data' => $loan,
    //     ]);
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'book_id' => 'required|exists:books,id',
    //         'return_date' => 'required|date|after_or_equal:today',
    //     ]);

    //     $book = Book::findOrFail($request->book_id);
    //     $userId = auth()->id();

    //     // Cari reservasi available user
    //     $activeReservation = Reservation::where('user_id', $userId)
    //         ->where('book_id', $book->id)
    //         ->where('status', 'available')
    //         ->where('expires_at', '>=', now())
    //         ->first();

    //     if (!$activeReservation && $book->stock <= 0) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Stok buku tidak mencukupi.',
    //         ], 400);
    //     }

    //     $now = now();
    //     $returnDate = \Carbon\Carbon::parse($request->return_date)->setTime(16, 59, 59);
    //     $loanDuration = $book->loan_duration;
    //     $maxReturnedAt = $now->copy()->addDays($loanDuration)->setTime(16, 59, 59);

    //     $loan = Loan::create([
    //         'book_id' => $book->id,
    //         'user_id' => $userId,
    //         'loan_date' => $now,
    //         'return_date' => $returnDate,
    //         'status' => 'borrowed',
    //         'loan_duration' => $loanDuration,
    //         'max_returned_at' => $maxReturnedAt,
    //     ]);

    //     // // Kalau lewat reservasi available → ubah statusnya ke completed
    //     // if ($activeReservation) {
    //     //     $activeReservation->update(['status' => 'completed']);
    //     // } else {
    //     //     $book->decrement('stock');
    //     // }

    //     // return response()->json([
    //     //     'success' => true,
    //     //     'message' => 'Peminjaman berhasil disimpan.',
    //     //     'data' => $loan,
    //     // ]);

    //     // --- PERBAIKAN LOGIKA DI SINI ---

    //     // Jika peminjaman ini berasal dari reservasi, update status reservasinya.
    //     if ($activeReservation) {
    //         $activeReservation->update(['status' => 'completed']);
    //         Log::info("Peminjaman dari reservasi. Status reservasi ID {$activeReservation->id} diubah menjadi completed.");
    //     }

    //     // Stok buku SELALU dikurangi setiap kali peminjaman berhasil.
    //     $book->decrement('stock');
    //     Log::info("Stok buku ID {$book->id} dikurangi. Stok sekarang: " . $book->fresh()->stock);


    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Peminjaman berhasil disimpan.',
    //         'data' => $loan,
    //     ]);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'return_date' => 'required|date|after_or_equal:today',
        ]);

        $book = Book::findOrFail($request->book_id);
        $userId = auth()->id();

        $activeReservation = Reservation::where('user_id', $userId)
            ->where('book_id', $book->id)
            ->where('status', 'available')
            ->where('expires_at', '>=', now())
            ->first();

        if (!$activeReservation && $book->stock <= 0) {
            return response()->json(['success' => false, 'message' => 'Stok buku tidak mencukupi.'], 400);
        }

        $now = now();
        $returnDate = \Carbon\Carbon::parse($request->return_date)->setTime(16, 59, 59);
        $loanDuration = $book->loan_duration;
        $maxReturnedAt = $now->copy()->addDays($loanDuration)->setTime(16, 59, 59);

        $loan = Loan::create([
            'book_id' => $book->id,
            'user_id' => $userId,
            'loan_date' => $now,
            'return_date' => $returnDate,
            'status' => 'borrowed',
            'loan_duration' => $loanDuration,
            'max_returned_at' => $maxReturnedAt,
        ]);

        // --- LOGIKA YANG SUDAH DIPERBAIKI ---
        if ($activeReservation) {
            $activeReservation->update(['status' => 'completed']);
            Log::info("Peminjaman dari reservasi. Status reservasi ID {$activeReservation->id} diubah menjadi completed.");
        }

        // Stok buku SELALU dikurangi setiap kali peminjaman berhasil.
        $book->decrement('stock');
        Log::info("Stok buku ID {$book->id} dikurangi. Stok sekarang: " . $book->fresh()->stock);

        return response()->json(['success' => true, 'message' => 'Peminjaman berhasil disimpan.', 'data' => $loan]);
    }

    // Menampilkan semua data peminjaman
    public function index()
    {
        $loans = Loan::with('book')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $loans
        ]);
    }

    // Mengembalikan buku
    public function returnLoan($id)
    {
        Log::info("Proses pengembalian dimulai untuk loan ID: {$id}");

        $loan = Loan::with('book')->findOrFail($id);
        Log::info("Data peminjaman ditemukan", ['loan_id' => $loan->id, 'book_id' => $loan->book_id]);

        $now = Carbon::now();
        $loanDate = Carbon::parse($loan->loan_date);
        $expectedReturnDate = Carbon::parse($loan->return_date); // tanggal yang diset ketika pinjam
        $maxReturnDate = $loanDate->copy()->addDays($loan->book->loan_duration);

        Log::info("Tanggal saat ini: {$now}");
        Log::info("Tanggal pinjam: {$loanDate}");
        Log::info("Tanggal harus dikembalikan: {$expectedReturnDate}");
        Log::info("Tanggal maksimal pengembalian (dengan durasi): {$maxReturnDate}");

        $statusNote = 'returned_on_time';
        $lateDays = 0;
        $fine = 0;

        if ($now->isSameDay($expectedReturnDate)) {
            $statusNote = 'Returned On Time';
            Log::info("Pengembalian lebih awal dari tanggal yang ditentukan.");
        } elseif ($now->lt($expectedReturnDate)) {
            $statusNote = 'Returned Earlier';
            Log::info("Pengembalian tepat pada tanggal yang ditentukan.");
        } elseif ($now->gt($expectedReturnDate)) {
            if ($now->lte($maxReturnDate)) {
                $statusNote = 'Late Within Allowed Duration';
                $lateDays = $expectedReturnDate->diffInDays($now);
                Log::info("Pengembalian terlambat dalam batas durasi", ['late_days' => $lateDays]);
            } else {
                $statusNote = 'Overdue';
                $lateDays = $maxReturnDate->diffInDays($now);
                $fine = $lateDays * 1000;
                Log::info("Pengembalian lewat batas maksimal", ['late_days' => $lateDays, 'fine' => $fine]);
            }
        }

        // $loan->update([
        //     'status' => 'returned',
        //     'return_date' => $now,
        //     'return_status_note' => $statusNote,
        //     'late_days' => $lateDays,
        //     'fine_amount' => $fine,
        // ]);

        $loan->update([
            'status' => 'returned',
            // 'return_date' => $expectedReturnDate, // tetap menyimpan janji kembali
            'actual_returned_at' => $now, // catat waktu nyata saat dikembalikan
            'return_status_note' => $statusNote,
            'late_days' => $lateDays,
            'fine_amount' => $fine,
        ]);

        Log::info("Data peminjaman diperbarui", [
            'status' => 'returned',
            // 'return_date' => $now,
            'actual_returned_at' => $now,
            'return_status_note' => $statusNote,
            'late_days' => $lateDays,
            'fine_amount' => $fine,
        ]);

        $loan->book->increment('stock');
        Log::info("Stok buku bertambah", ['book_id' => $loan->book_id, 'stok_baru' => $loan->book->stock]);

        // Perubahan: Panggil fungsi untuk proses antrian reservasi
        $this->processReservationQueue($loan->book);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dikembalikan.',
            'data' => [
                'return_status_note' => $statusNote,
                'late_days' => $lateDays,
                'fine' => $fine > 0 ? 'Rp ' . number_format($fine, 0, ',', '.') : null,
            ],
        ]);
    }

    // Perubahan: Tambahkan method baru untuk memproses antrian
    // private function processReservationQueue(Book $book)
    // {
    //     $nextInQueue = Reservation::where('book_id', $book->id)
    //         ->where('status', 'pending')
    //         ->orderBy('queue_position', 'asc')
    //         ->first();

    //     if ($nextInQueue) {
    //         // Update status reservasi menjadi 'available'
    //         $nextInQueue->update([
    //             'status' => 'available',
    //             'notified_at' => now(),
    //             'expires_at' => now()->addDays(2) // Beri waktu 2 hari untuk mengambil buku
    //         ]);

    //         // Di sini Anda bisa menambahkan logic untuk mengirim notifikasi (email, push notification)
    //         Log::info("Notifikasi untuk reservasi ID:{$nextInQueue->id} telah dikirim kepada user ID:{$nextInQueue->user_id}.");

    //         // Karena buku ini sekarang 'dipegang' untuk user yang reservasi, stoknya kita kurangi lagi
    //         // $book->decrement('stock');
    //     }
    // }

    private function processReservationQueue(Book $book)
    {
        $nextInQueue = Reservation::where('book_id', $book->id)
            ->where('status', 'pending')
            ->orderBy('queue_position', 'asc')
            ->first();

        if ($nextInQueue) {
            $nextInQueue->update([
                'status' => 'available',
                'notified_at' => now(),
                'expires_at' => now()->addDay(), // max 1 hari
            ]);

            // stok diamankan untuk user ini
            // $book->decrement('stock');

            \Log::info("Reservasi {$nextInQueue->id} tersedia untuk user {$nextInQueue->user_id}");
        }
    }

    // Membatalkan peminjaman
    public function cancelLoan($id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->status == 'borrowed') {
            $loan->book->increment('stock'); // kembalikan stok
        }

        $loan->delete();

        return response()->json(['success' => true, 'message' => 'Peminjaman dibatalkan']);
    }

    // Mengecek apakah user saat ini sedang meminjam buku tersebut
    public function checkActiveLoan(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $hasActiveLoan = Loan::where('user_id', auth()->id())
            ->where('book_id', $request->book_id)
            ->where('status', 'borrowed')
            ->exists();

        return response()->json([
            'has_active_loan' => $hasActiveLoan
        ]);
    }
}
