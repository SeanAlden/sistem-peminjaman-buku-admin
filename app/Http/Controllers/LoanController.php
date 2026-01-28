<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use App\Models\Reservation; // Pastikan Reservation di-import
use Illuminate\Support\Facades\Log; // Pastikan Log di-import

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = (int) $request->input('per_page', 5);

        // Mengurutkan berdasarkan status 'pending_return' terlebih dahulu
        $query = Loan::with(['book', 'user'])
            ->orderByRaw("FIELD(status, 'pending_return', 'borrowed', 'returned')")
            ->latest();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('status', 'like', "%{$search}%")
                    ->orWhere('return_status_note', 'like', "%{$search}%")
                    ->orWhereHas('book', function ($q2) use ($search) {
                        $q2->where('title', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $loans = $query->paginate($perPage)->appends($request->except('page'));
        return view('loan', compact('loans', 'search', 'perPage'));
    }

    public function show($id)
    {
        $loan = Loan::with(['book', 'user'])->findOrFail($id);
        $duration = null;
        if ($loan->actual_returned_at && $loan->loan_date) {
            $duration = intval($loan->loan_date->diffInDays($loan->actual_returned_at));
        }
        return view('loan_detail', compact('loan', 'duration'));
    }

    /**
     * Method baru untuk mengonfirmasi pengembalian buku oleh admin.
     * Ini berisi logika inti yang sebelumnya ada di API.
     */
    public function confirmReturn(Request $request, $id)
    {
        Log::info("Admin memulai konfirmasi pengembalian untuk loan ID: {$id}");

        $loan = Loan::with('book')->where('status', 'pending_return')->findOrFail($id);

        $now = Carbon::now();
        $loanDate = Carbon::parse($loan->loan_date);
        $expectedReturnDate = Carbon::parse($loan->max_returned_at);
        $maxReturnDate = $loanDate->copy()->addDays($loan->book->loan_duration);

        $statusNote = 'returned_on_time';
        $lateDays = 0;
        $fine = 0;

        if ($now->lt($expectedReturnDate)) {
            $statusNote = 'Returned Earlier';
        } elseif ($now->isSameDay($expectedReturnDate)) {
            $statusNote = 'Returned On Time';
        } elseif ($now->gt($expectedReturnDate)) {
            if ($now->lte($maxReturnDate)) {
                $statusNote = 'Late Within Allowed Duration';
                $lateDays = $expectedReturnDate->diffInDays($now);
            } else {
                $statusNote = 'Overdue';
                $lateDays = $maxReturnDate->diffInDays($now);
                $fine = $lateDays * 1000; // Contoh denda per hari
            }
        }

        $loan->update([
            'status' => 'returned',
            'actual_returned_at' => $now,
            'return_status_note' => $statusNote,
            'late_days' => $lateDays,
            'fine_amount' => $fine,
        ]);
        Log::info("Data peminjaman loan ID: {$id} telah dikonfirmasi dan diperbarui.");

        // 1. Tambah stok buku
        $loan->book->increment('stock');
        Log::info("Stok buku ID: {$loan->book_id} ditambah. Stok baru: " . $loan->book->fresh()->stock);

        // 2. Proses antrian reservasi jika ada
        $this->processReservationQueue($loan->book);

        return redirect()->route('loans.index')->with('success', 'Pengembalian buku berhasil dikonfirmasi.');
    }

    /**
     * Method private untuk memproses antrian reservasi.
     * Dipanggil setelah pengembalian dikonfirmasi.
     */
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
                'expires_at' => now()->addDay(),
            ]);
            Log::info("Reservasi {$nextInQueue->id} tersedia untuk user {$nextInQueue->user_id}");
        }
    }
}
