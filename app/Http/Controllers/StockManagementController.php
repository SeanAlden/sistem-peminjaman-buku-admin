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
        $stockLogs = $entries->concat($exits)->sortBy([
            ['book_id', 'asc'],
            ['created_at', 'asc']
        ])->groupBy('book_id');

        return view('stock_management', compact('stockLogs'));
    }
}

