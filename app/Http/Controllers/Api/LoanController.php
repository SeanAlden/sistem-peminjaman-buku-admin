<?php

namespace App\Http\Controllers\API;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class LoanController extends Controller
{
    // ... method store() dan index() tetap sama ...
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

        if ($activeReservation) {
            $activeReservation->update(['status' => 'completed']);
            Log::info("Peminjaman dari reservasi. Status reservasi ID {$activeReservation->id} diubah menjadi completed.");
        }

        $book->decrement('stock');
        Log::info("Stok buku ID {$book->id} dikurangi. Stok sekarang: " . $book->fresh()->stock);

        return response()->json(['success' => true, 'message' => 'Peminjaman berhasil disimpan.', 'data' => $loan]);
    }

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

    public function cancelLoan($id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->status == 'borrowed') {
            $loan->book->increment('stock');
        }

        $loan->delete();

        return response()->json(['success' => true, 'message' => 'Peminjaman dibatalkan']);
    }

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

    /**
     * Method baru yang dipanggil dari mobile app saat user menekan 'Kembalikan'.
     * HANYA mengubah status menjadi 'pending_return'.
     */
    public function requestReturn($id)
    {
        Log::info("User mengajukan pengembalian untuk loan ID: {$id}");

        $loan = Loan::where('user_id', auth()->id())
            ->where('status', 'borrowed')
            ->findOrFail($id);
        
        $loan->update(['status' => 'pending_return']);

        Log::info("Status loan ID: {$id} diubah menjadi 'pending_return'. Menunggu konfirmasi admin.");

        return response()->json([
            'success' => true,
            'message' => 'Permintaan pengembalian telah dikirim. Harap serahkan buku ke admin untuk konfirmasi.',
        ]);
    }

    // ... method store(), index(), cancelLoan(), checkActiveLoan() Anda tetap sama ...
    
    // Anda bisa menghapus method processReservationQueue() dari controller API ini
    // karena logikanya sudah dipindahkan ke LoanController web.
}
