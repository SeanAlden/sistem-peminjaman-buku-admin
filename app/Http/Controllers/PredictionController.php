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
    public function index()
    {
        $predictions = BookPrediction::with('book')->orderByDesc('predicted_popularity')->get();
        return view('prediction', compact('predictions'));
    }

    // Refresh predictions
    public function refresh()
    {
        // Ambil jumlah peminjaman per buku
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

        return redirect()->route('predictions.index')->with('success', 'Prediksi berhasil diperbarui.');
    }
}
