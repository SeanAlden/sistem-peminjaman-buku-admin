<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use App\Models\BookPrediction;
use Illuminate\Support\Facades\DB;

class PredictionController extends Controller
{
    // View Predictions
    public function index(Request $request)
    {
        // Mengambil nilai 'search' dari request, defaultnya string kosong
        $search = $request->input('search', '');

        // Mengambil nilai 'per_page' dari request, defaultnya 10
        // dan memastikan nilainya adalah integer
        $perPage = (int) $request->input('per_page', 5);

        // Memulai query pada model BookPrediction
        $query = BookPrediction::with('book')->orderByDesc('predicted_popularity');

        // Jika ada keyword pencarian, tambahkan kondisi where
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->
                    where('loan_count', 'like', "%{$search}%")
                    ->orWhere('des_prediction', 'like', "%{$search}%")
                    ->orWhereHas('book', function ($q2) use ($search) {
                        $q2->where('title', 'like', "%{$search}%")
                            ->orWhereHas('category', function ($q2) use ($search) {
                                $q2->where('name', 'like', "%{$search}%");
                            });
                    });
            });
        }

        // Lakukan pagination pada hasil query
        // 'appends' digunakan agar parameter 'search' dan 'per_page' tetap ada di URL pagination
        $predictions = $query->paginate($perPage)->appends($request->except('page'));

        // Kembalikan view 'prediction' dengan data predictions, search, dan perPage
        return view('prediction', compact('predictions', 'search', 'perPage'));
    }

    // Refresh predictions (Normalization)
    // public function refresh()
    // {
    //     // Ambil jumlah peminjaman per buku
    //     $loanCounts = Loan::select('book_id', DB::raw('COUNT(*) as total'))
    //         ->groupBy('book_id')
    //         ->get();

    //     $maxLoan = $loanCounts->max('total') ?? 1;

    //     foreach ($loanCounts as $data) {
    //         $score = ($data->total / $maxLoan) * 100;

    //         BookPrediction::updateOrCreate(
    //             ['book_id' => $data->book_id],
    //             [
    //                 'loan_count' => $data->total,
    //                 'predicted_popularity' => round($score, 2)
    //             ]
    //         );
    //     }

    //     return redirect()->route('predictions.index')->with('success', 'Prediksi berhasil diperbarui.');
    // }

    // public function refresh()
    // {
    //     $monthlyLoanData = Loan::selectRaw('book_id, DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
    //         ->groupBy('book_id', 'month')
    //         ->orderBy('book_id')
    //         ->orderBy('month')
    //         ->get()
    //         ->groupBy('book_id');

    //     foreach ($monthlyLoanData as $bookId => $monthlyLoans) {
    //         $loanCounts = $monthlyLoans->pluck('total')->toArray();

    //         if (count($loanCounts) < 2) {
    //             // Tidak cukup data untuk DES
    //             continue;
    //         }

    //         $forecast = $this->doubleExponentialSmoothing($loanCounts);
    //         $totalLoan = array_sum($loanCounts);

    //         BookPrediction::updateOrCreate(
    //             ['book_id' => $bookId],
    //             [
    //                 'loan_count' => $totalLoan,
    //                 'predicted_popularity' => round($forecast, 2),
    //             ]
    //         );
    //     }

    //     return redirect()->route('predictions.index')->with('success', 'Prediksi dengan tren berhasil diperbarui.');
    // }

    // private function doubleExponentialSmoothing($data, $alpha = 0.5, $beta = 0.3)
    // {
    //     $level = $data[0]; // S₀
    //     $trend = $data[1] - $data[0]; // T₀
    //     $result = [];

    //     foreach ($data as $i => $actual) {
    //         if ($i == 0) {
    //             $result[] = $level + $trend;
    //             continue;
    //         }

    //         $prevLevel = $level;
    //         $level = $alpha * $actual + (1 - $alpha) * ($level + $trend);
    //         $trend = $beta * ($level - $prevLevel) + (1 - $beta) * $trend;

    //         $forecast = $level + $trend;
    //         $result[] = round($forecast, 2);
    //     }

    //     return end($result); // Return the latest forecast
    // }

    public function refresh()
    {
        // Masih mempertahankan logika lama (simple count-based)
        $loanCounts = Loan::select('book_id', DB::raw('COUNT(*) as total'))
            ->groupBy('book_id')
            ->get();

        $maxLoan = $loanCounts->max('total') ?? 1;

        foreach ($loanCounts as $data) {
            $score = ($data->total / $maxLoan) * 100;

            BookPrediction::updateOrCreate(
                ['book_id' => $data->book_id],
                [
                    'loan_count' => $data->total,
                    'predicted_popularity' => round($score, 2)
                ]
            );
        }

        // 🔥 Tambahkan metode prediksi baru
        $this->predictWithDES();

        return redirect()->route('predictions.index')->with('success', 'Prediksi berhasil diperbarui.');
    }

    /**
     * 🔮 Double Exponential Smoothing Prediction
     */
    private function predictWithDES()
    {
        $books = Book::all();

        foreach ($books as $book) {
            // Ambil jumlah peminjaman per bulan (6 bulan terakhir)
            $monthlyLoans = Loan::where('book_id', $book->id)
                ->selectRaw('DATE_FORMAT(loan_date, "%Y-%m") as month, COUNT(*) as total')
                ->where('loan_date', '>=', now()->subMonths(6))
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total')
                ->toArray();

            if (count($monthlyLoans) < 2)
                continue; // DES minimal butuh 2 data

            // Inisialisasi parameter smoothing
            $alpha = 0.6; // level
            $beta = 0.2;  // trend

            // Inisialisasi DES
            $L_prev = $monthlyLoans[0];
            $T_prev = $monthlyLoans[1] - $monthlyLoans[0];

            $L = $L_prev;
            $T = $T_prev;

            for ($t = 1; $t < count($monthlyLoans); $t++) {
                $Yt = $monthlyLoans[$t];
                $L_new = $alpha * $Yt + (1 - $alpha) * ($L + $T);
                $T_new = $beta * ($L_new - $L) + (1 - $beta) * $T;

                $L = $L_new;
                $T = $T_new;
            }

            // Prediksi untuk bulan berikutnya
            $forecast = $L + $T;

            // Constraint bisnis
            $forecast = max(0, round($forecast));

            // Update hasil prediksi ke tabel book_predictions
            BookPrediction::updateOrCreate(
                ['book_id' => $book->id],
                [
                    'des_prediction' => round($forecast, 2),
                ]
            );
        }
    }

}
