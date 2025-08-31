<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    // Menampilkan semua data peminjaman
    public function index(Request $request)
    {
        // $loans = Loan::with(['book', 'user'])->latest()->get();
        // return view('loan', compact('loans'));

        // Mengambil nilai 'search' dari request, defaultnya string kosong
        $search = $request->input('search', '');

        // Mengambil nilai 'per_page' dari request, defaultnya 10
        // dan memastikan nilainya adalah integer
        $perPage = (int) $request->input('per_page', 5);

        // Memulai query pada model Loan
        // $query = Book::query();
        $query = Loan::with(['book', 'user'])->latest();

        // Jika ada keyword pencarian, tambahkan kondisi where
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->
                    where('status', 'like', "%{$search}%")
                    ->orWhere('return_status_note', 'like', "%{$search}%")
                    ->orWhereHas('book', function ($q2) use ($search) {
                        $q2->where('title', 'like', "%{$search}%");
                    })->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('email', 'like', "%{$search}%");
                    });
            });
        }

        // Lakukan pagination pada hasil query
        // 'appends' digunakan agar parameter 'search' dan 'per_page' tetap ada di URL pagination
        $loans = $query->paginate($perPage)->appends($request->except('page'));

        // Kembalikan view 'loan' dengan data loans, search, dan perPage
        return view('loan', compact('loans', 'search', 'perPage'));
    }

    // Menampilkan detail peminjaman berdasarkan ID
    public function show($id)
    {
        $loan = Loan::with('book')->findOrFail($id);

        // Hitung durasi peminjaman jika return_date tersedia
        // $duration = null;
        // if ($loan->actual_returned_at && $loan->loan_date) {
        //     $duration = $loan->loan_date->diffInDays($loan->actual_returned_at);
        // }

        $duration = null;
        if ($loan->actual_returned_at && $loan->loan_date) {
            $duration = intval($loan->loan_date->diffInDays($loan->actual_returned_at));
        }

        return view('loan_detail', compact('loan', 'duration'));
    }

    // public function show($id)
    // {
    //     $loan = Loan::with('book')->findOrFail($id);

    //     $duration = null;
    //     if ($loan->return_date && $loan->loan_date) {
    //         $diff = $loan->loan_date->diff($loan->return_date);
    //         $duration = CarbonInterval::instance($diff)->cascade()->forHumans([
    //             'parts' => 4, // tampilkan hingga 4 bagian waktu
    //             'join' => true, // gabungkan dengan koma dan 'dan'
    //             'short' => false, // gunakan nama waktu lengkap
    //         ]);
    //     }

    //     return view('loan_detail', compact('loan', 'duration'));
    // }

    // public function show($id)
    // {
    //     $loan = Loan::with('book')->findOrFail($id);

    //     $duration = null;
    //     if ($loan->actual_returned_at && $loan->loan_date) {
    //         $diff = $loan->loan_date->diff($loan->actual_returned_at);

    //         // Ambil komponen waktu secara manual
    //         $days = $diff->d;
    //         $hours = $diff->h;
    //         $minutes = $diff->i;
    //         // $seconds = $diff->s;

    //         // Format ke dalam Bahasa Indonesia
    //         $parts = [];
    //         if ($days > 0)
    //             $parts[] = "$days hari";
    //         if ($hours > 0)
    //             $parts[] = "$hours jam";
    //         if ($minutes > 0)
    //             $parts[] = "$minutes menit";
    //         // if ($seconds > 0)
    //         //     $parts[] = "$seconds detik";

    //         if (count($parts) > 1) {
    //             $last = array_pop($parts);
    //             $duration = implode(' ', $parts) . ' dan ' . $last;
    //         } else {
    //             $duration = $parts[0] ?? '';
    //         }

    //         // $duration = implode(' ', $parts);
    //     }

    //     return view('loan_detail', compact('loan', 'duration'));
    // }

    // public function show($id)
    // {
    //     $loan = Loan::with('book')->findOrFail($id);

    //     $duration = null;
    //     if ($loan->actual_returned_at && $loan->loan_date) {
    //         $diff = $loan->loan_date->diff($loan->actual_returned_at);

    //         $years = $diff->y;
    //         $months = $diff->m;
    //         $days = $diff->d;
    //         $hours = $diff->h;
    //         $minutes = $diff->i;
    //         $seconds = $diff->s;

    //         $parts = [];
    //         if ($years > 0)
    //             $parts[] = "$years tahun";
    //         if ($months > 0)
    //             $parts[] = "$months bulan";
    //         if ($days > 0)
    //             $parts[] = "$days hari";
    //         if ($hours > 0)
    //             $parts[] = "$hours jam";
    //         if ($minutes > 0)
    //             $parts[] = "$minutes menit";
    //         if ($seconds > 0)
    //             $parts[] = "$seconds detik";

    //         // Tambahkan "dan" sebelum bagian terakhir jika lebih dari 1 elemen
    //         if (count($parts) > 1) {
    //             $last = array_pop($parts);
    //             $duration = implode(' ', $parts) . ' dan ' . $last;
    //         } else {
    //             $duration = $parts[0] ?? '';
    //         }
    //     }

    //     return view('loan_detail', compact('loan', 'duration'));
    // }
}
