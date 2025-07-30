<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\View;
use Illuminate\Container\Attributes\Auth;

class DashboardController extends Controller
{
    //
    public function viewDashboard()
    {
        $totalBooks = Book::count();
        $totalFine = Loan::sum('fine_amount');
        $totalUsers = User::where('usertype', 'user')->count();

        // Ambil jumlah peminjaman per bulan (12 bulan terakhir)
        $loansPerMonth = Loan::selectRaw('MONTH(loan_date) as month, COUNT(*) as count')
            ->whereYear('loan_date', now()->year)
            ->groupByRaw('MONTH(loan_date)')
            ->pluck('count', 'month')
            ->toArray();

        // Format agar setiap bulan tetap muncul (jika tidak ada peminjaman = 0)
        $labels = [];
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->format('F');
            $data[] = $loansPerMonth[$i] ?? 0;
        }

        return view('dashboard', [
            'totalBooks' => $totalBooks,
            'totalFine' => $totalFine,
            'totalUsers' => $totalUsers,
            'chartLabels' => $labels,
            'chartData' => $data,
            'userName' => \Illuminate\Support\Facades\Auth::user()->name,
        ]);
    }
}
