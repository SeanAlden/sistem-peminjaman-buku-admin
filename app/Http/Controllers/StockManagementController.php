<?php

namespace App\Http\Controllers;

use App\Models\ExitBook;
use App\Models\EntryBook;
use Illuminate\Http\Request;

class StockManagementController extends Controller
{
    public function index(Request $request)
    {
        $entries = EntryBook::with('book.category')->get()->map(function ($item) {
            return [
                'type' => 'Masuk',
                'book_id' => $item->book->id,
                'book' => $item->book,
                'category' => $item->book->category->name ?? '-',
                'stock_before' => $item->stock_before,
                'amount' => $item->stock_in,
                'stock_after' => $item->stock_after,
                'created_at' => $item->created_at,
            ];
        });

        $exits = ExitBook::with('book.category')->get()->map(function ($item) {
            return [
                'type' => 'Keluar',
                'book_id' => $item->book->id,
                'book' => $item->book,
                'category' => $item->book->category->name ?? '-',
                'stock_before' => $item->stock_before,
                'amount' => $item->stock_out,
                'stock_after' => $item->stock_after,
                'created_at' => $item->created_at,
            ];
        });

        // Gabungkan dan urutkan berdasarkan buku dan waktu
        // $stockLogs = $entries->concat($exits)->sortBy([
        //     ['book_id', 'asc'],
        //     ['created_at', 'asc']
        // ])->groupBy('book_id');

        // return view('stock_management', compact('stockLogs'));

        // // Mengambil nilai 'search' dari request, defaultnya string kosong
        $search = $request->input('search', '');

        // Mengambil nilai 'per_page' dari request, defaultnya 10
        // dan memastikan nilainya adalah integer
        $perPage = (int) $request->input('per_page', 5);

        // Memulai query pada model Supplier
        // $query = Book::query();
        $query = $entries->concat($exits)->sortBy([
            ['book_id', 'asc'],
            ['created_at', 'asc']
        ])->groupBy('book_id');

        // Jika ada keyword pencarian, tambahkan kondisi where
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->
                    where('type', 'like', "%{$search}%")
                    ->orWhere('book.title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%")
                    ->orWhere('stock_before', 'like', "%{$search}%")
                    ->orWhere('stock_after', 'like', "%{$search}%");
            });
        }

        // Lakukan pagination pada hasil query
        // 'appends' digunakan agar parameter 'search' dan 'per_page' tetap ada di URL pagination
        $stockLogs = $query->paginate($perPage)->appends($request->except('page'));

        // Kembalikan view 'suppliers.supplier_list' dengan data suppliers, search, dan perPage
        return view('stock_management', compact('stockLogs', 'search', 'perPage'));
    }
}

