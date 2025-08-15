<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
        $totalBorrowedBooks = Loan::where('status', 'borrowed')->count();

        // Grafik Line - Peminjaman per Bulan
        $loansPerMonth = Loan::selectRaw('MONTH(loan_date) as month, COUNT(*) as count')
            ->whereYear('loan_date', now()->year)
            ->groupByRaw('MONTH(loan_date)')
            ->pluck('count', 'month')
            ->toArray();

        $labels = [];
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->format('F');
            $data[] = $loansPerMonth[$i] ?? 0;
        }

        // Ambil top 5 kategori
        $topCategories = DB::table('categories')
            ->select('categories.name', DB::raw('COUNT(loans.id) as total_loans'))
            ->join('books', 'categories.id', '=', 'books.category_id')
            ->join('loans', 'books.id', '=', 'loans.book_id')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_loans')
            ->limit(5)
            ->get();

        $totalAll = $topCategories->sum('total_loans');

        $categoryLabels = [];
        $categoryData = [];
        $categoryPercentages = [];
        $backgroundColors = [];
        $borderColors = [];

        foreach ($topCategories as $item) {
            $categoryLabels[] = $item->name;
            $categoryData[] = $item->total_loans;
            $categoryPercentages[] = round(($item->total_loans / $totalAll) * 100, 1);

            $color = sprintf('rgba(%d, %d, %d, 0.6)', rand(50, 255), rand(50, 255), rand(50, 255));
            $border = str_replace('0.6', '1', $color);

            $backgroundColors[] = $color;
            $borderColors[] = $border;
        }

        return view('dashboard', [
            'totalBooks' => $totalBooks,
            'totalFine' => $totalFine,
            'totalUsers' => $totalUsers,
            'totalBorrowedBooks' => $totalBorrowedBooks, 
            // chart data
            'chartLabels' => $labels,
            'chartData' => $data,
            'categoryLabels' => $categoryLabels,
            'categoryData' => $categoryData,
            'categoryPercentages' => $categoryPercentages,
            'categoryBgColors' => $backgroundColors,
            'categoryBorderColors' => $borderColors,
            'userName' => auth()->user()->name,
        ]);
    }

    // public function viewDashboard()
    // {
    //     $totalBooks = Book::count();
    //     $totalFine = Loan::sum('fine_amount');
    //     $totalUsers = User::where('usertype', 'user')->count();

    //     // Grafik Line - Peminjaman per Bulan
    //     $loansPerMonth = Loan::selectRaw('MONTH(loan_date) as month, COUNT(*) as count')
    //         ->whereYear('loan_date', now()->year)
    //         ->groupByRaw('MONTH(loan_date)')
    //         ->pluck('count', 'month')
    //         ->toArray();

    //     $labels = [];
    //     $data = [];
    //     for ($i = 1; $i <= 12; $i++) {
    //         $labels[] = Carbon::create()->month($i)->format('F');
    //         $data[] = $loansPerMonth[$i] ?? 0;
    //     }

    //     // 🔥 Tambahkan Pie Chart: 5 kategori teratas berdasarkan total peminjaman buku
    //     $topCategories = DB::table('categories')
    //         ->select('categories.name', DB::raw('COUNT(loans.id) as total_loans'))
    //         ->join('books', 'categories.id', '=', 'books.category_id')
    //         ->join('loans', 'books.id', '=', 'loans.book_id')
    //         ->groupBy('categories.id', 'categories.name')
    //         ->orderByDesc('total_loans')
    //         ->limit(5)
    //         ->get();

    //     $categoryLabels = $topCategories->pluck('name');
    //     $categoryData = $topCategories->pluck('total_loans');

    //     return view('dashboard', [
    //         'totalBooks' => $totalBooks,
    //         'totalFine' => $totalFine,
    //         'totalUsers' => $totalUsers,
    //         'chartLabels' => $labels,
    //         'chartData' => $data,
    //         'categoryLabels' => $categoryLabels,
    //         'categoryData' => $categoryData,
    //         'userName' => \Illuminate\Support\Facades\Auth::user()->name,
    //     ]);
    // }

    // public function viewDashboard()
    // {
    //     $totalBooks = Book::count();
    //     $totalFine = Loan::sum('fine_amount');
    //     $totalUsers = User::where('usertype', 'user')->count();

    //     // Ambil jumlah peminjaman per bulan (12 bulan terakhir)
    //     $loansPerMonth = Loan::selectRaw('MONTH(loan_date) as month, COUNT(*) as count')
    //         ->whereYear('loan_date', now()->year)
    //         ->groupByRaw('MONTH(loan_date)')
    //         ->pluck('count', 'month')
    //         ->toArray();

    //     // Format agar setiap bulan tetap muncul (jika tidak ada peminjaman = 0)
    //     $labels = [];
    //     $data = [];
    //     for ($i = 1; $i <= 12; $i++) {
    //         $labels[] = Carbon::create()->month($i)->format('F');
    //         $data[] = $loansPerMonth[$i] ?? 0;
    //     }

    //     return view('dashboard', [
    //         'totalBooks' => $totalBooks,
    //         'totalFine' => $totalFine,
    //         'totalUsers' => $totalUsers,
    //         'chartLabels' => $labels,
    //         'chartData' => $data,
    //         'userName' => \Illuminate\Support\Facades\Auth::user()->name,
    //     ]);
    // }

    // public function viewDashboard(Request $request)
    // {
    //     $year = $request->input('year', now()->year);

    //     $totalBooks = Book::count();
    //     $totalFine = Loan::whereYear('loan_date', $year)->sum('fine_amount');
    //     $totalUsers = User::where('usertype', 'user')->count();

    //     $loansPerMonth = Loan::selectRaw('MONTH(loan_date) as month, COUNT(*) as count')
    //         ->whereYear('loan_date', $year)
    //         ->groupByRaw('MONTH(loan_date)')
    //         ->pluck('count', 'month')
    //         ->toArray();

    //     $labels = [];
    //     $data = [];
    //     for ($i = 1; $i <= 12; $i++) {
    //         $labels[] = Carbon::create()->month($i)->format('F');
    //         $data[] = $loansPerMonth[$i] ?? 0;
    //     }

    //     // Tahun-tahun tersedia untuk dropdown
    //     $availableYears = Loan::selectRaw('YEAR(loan_date) as year')
    //         ->distinct()
    //         ->orderByDesc('year')
    //         ->pluck('year');

    //     return view('dashboard', [
    //         'totalBooks' => $totalBooks,
    //         'totalFine' => $totalFine,
    //         'totalUsers' => $totalUsers,
    //         'chartLabels' => $labels,
    //         'chartData' => $data,
    //         'userName' => \Illuminate\Support\Facades\Auth::user()->name,
    //         'availableYears' => $availableYears,
    //         'year' => $year,
    //     ]);
    // }
}
