<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    // Menampilkan semua data peminjaman
    public function index()
    {
        $loans = Loan::with('book')->latest()->get();
        return view('loan', compact('loans'));
    }

    // Menampilkan detail peminjaman berdasarkan ID
    public function show($id)
    {
        $loan = Loan::with('book')->findOrFail($id);

        // Hitung durasi peminjaman jika return_date tersedia
        $duration = null;
        if ($loan->return_date && $loan->loan_date) {
            $duration = $loan->loan_date->diffInDays($loan->return_date);
        }

        return view('loan_detail', compact('loan', 'duration'));
    }
}
