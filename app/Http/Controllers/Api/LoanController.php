<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Reservation;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\User;
use App\Events\NewNotificationEvent;
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

        // Notification::create([
        //     'user_id' => $book->id, // bisa diarahkan ke admin / user sesuai kebutuhan
        //     'title' => 'Buku Dipinjam',
        //     'message' => auth()->user()->name . " meminjam buku {$book->title}",
        // ]);

        $message = auth()->user()->name . " meminjam buku {$book->title}";
        $title = 'Buku Dipinjam';

        $admins = User::where('usertype', 'admin')->get();

        if ($admins->isEmpty()) {
            // fallback: buat notifikasi global (user_id null)
            $notif = Notification::create([
                'user_id' => null,
                'title' => $title,
                'message' => $message,
            ]);
            event(new NewNotificationEvent($notif));
        } else {
            foreach ($admins as $admin) {
                $notif = Notification::create([
                    'user_id' => $admin->id,
                    'title' => $title,
                    'message' => $message,
                ]);
                event(new NewNotificationEvent($notif));
            }
        }

        // event(new NewNotificationEvent(Notification::latest()->first()));

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

        // Notification::create([
        //     'user_id' => $id,
        //     'title' => 'Request Pengembalian',
        //     'message' => auth()->user()->name . " meminta pengembalian buku {$loan->book->title}",
        // ]);

        // event(new NewNotificationEvent(Notification::latest()->first()));

        $admins = User::where('usertype', 'admin')->get();

        foreach ($admins as $admin) {
            $notif = Notification::create([
                'user_id' => $admin->id,   // ✅ admin id, valid di tabel users
                'title' => 'Request Pengembalian',
                'message' => auth()->user()->name . " meminta pengembalian buku {$loan->book->title}",
            ]);

            event(new NewNotificationEvent($notif));
        }

        return response()->json([
            'success' => true,
            'message' => 'Permintaan pengembalian telah dikirim. Harap serahkan buku ke admin untuk konfirmasi.',
        ]);
    }

    // ... method store(), index(), cancelLoan(), checkActiveLoan() Anda tetap sama ...

    // Anda bisa menghapus method processReservationQueue() dari controller API ini
    // karena logikanya sudah dipindahkan ke LoanController web.
}
