<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Purchase;
use App\Models\EntryBook;
use Illuminate\Http\Request;

class EntryBookController extends Controller
{
    public function index()
    {
        $entries = EntryBook::with('book.category')->latest()->get();

        $books = Book::all();

        // Ambil stok maksimum dari tabel purchases
        $purchaseStockMap = Purchase::selectRaw('book_id, SUM(quantity) as total')
            ->groupBy('book_id')
            ->pluck('total', 'book_id');

        return view('entry_books.entry_books', compact('entries', 'books', 'purchaseStockMap'));
    }

    public function create()
    {
        $books = Book::whereHas('purchases')->get();
        return response()->json($books);
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'book_id' => 'required|exists:books,id',
    //         'stock_in' => 'required|integer|min:1',
    //     ]);

    //     $book = Book::findOrFail($request->book_id);
    //     $purchase = Purchase::where('book_id', $book->id)->latest()->first();

    //     if (!$purchase) {
    //         return back()->withErrors(['book_id' => 'Tidak ada data pembelian untuk buku ini.']);
    //     }

    //     // Hitung total entry untuk pembelian ini
    //     $totalEntries = EntryBook::where('purchase_id', $purchase->id)->sum('stock_in');

    //     if ($totalEntries + $request->stock_in > $purchase->quantity) {
    //         return back()->withErrors(['stock_in' => 'Jumlah barang masuk melebihi kuantitas pembelian.']);
    //     }

    //     $stockBefore = $book->stock;
    //     $stockAfter = $stockBefore + $request->stock_in;

    //     // Tambahkan entry book
    //     EntryBook::create([
    //         'book_id' => $book->id,
    //         'purchase_id' => $purchase->id,
    //         'stock_before' => $stockBefore,
    //         'stock_in' => $request->stock_in,
    //         'stock_after' => $stockAfter,
    //     ]);

    //     // Update stok di books
    //     $book->update(['stock' => $stockAfter]);

    //     return redirect()->route('entry_books.index')->with('success', 'Barang masuk berhasil dicatat.');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'stock_in' => 'required|integer|min:1',
        ]);

        $book = Book::findOrFail($request->book_id);
        $purchase = Purchase::where('book_id', $book->id)->latest()->first();

        if (!$purchase) {
            return back()->withErrors(['book_id' => 'Tidak ada data pembelian untuk buku ini.']);
        }

        // Hitung total entry untuk pembelian ini
        $totalEntries = EntryBook::where('purchase_id', $purchase->id)->sum('stock_in');

        if ($totalEntries + $request->stock_in > $purchase->quantity) {
            return back()->withErrors(['stock_in' => 'Jumlah barang masuk melebihi kuantitas pembelian.']);
        }

        $stockBefore = $book->stock;
        $stockAfter = $stockBefore + $request->stock_in;

        // Tambahkan entry book
        EntryBook::create([
            'book_id' => $book->id,
            'purchase_id' => $purchase->id,
            'stock_before' => $stockBefore,
            'stock_in' => $request->stock_in,
            'stock_after' => $stockAfter,
        ]);

        // Update stok di tabel books
        $book->update(['stock' => $stockAfter]);

        // ✅ Update sisa quantity di tabel purchases
        $purchase->update([
            'quantity' => $purchase->quantity - $request->stock_in,
        ]);

        return redirect()->route('entry_books.index')->with('success', 'Barang masuk berhasil dicatat.');
    }

    public function edit($id)
    {
        $entry = EntryBook::with('book')->findOrFail($id);
        return response()->json($entry);
    }

    public function update(Request $request, $id)
    {
        $entry = EntryBook::findOrFail($id);
        $book = $entry->book;
        $purchase = $entry->purchase;

        $request->validate([
            'stock_in' => 'required|integer|min:1',
        ]);

        $totalOtherEntries = EntryBook::where('purchase_id', $purchase->id)
            ->where('id', '!=', $entry->id)
            ->sum('stock_in');

        if ($totalOtherEntries + $request->stock_in > $purchase->quantity) {
            return back()->withErrors(['stock_in' => 'Jumlah barang masuk melebihi kuantitas pembelian.']);
        }

        // Update stok buku
        $newStock = $book->stock - $entry->stock_in + $request->stock_in;

        $entry->update([
            'stock_before' => $book->stock - $entry->stock_in,
            'stock_in' => $request->stock_in,
            'stock_after' => $newStock,
        ]);

        $book->update(['stock' => $newStock]);

        return redirect()->route('entry_books.index')->with('success', 'Barang masuk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $entry = EntryBook::findOrFail($id);
        $book = $entry->book;

        // Kurangi stok
        $book->update(['stock' => $book->stock - $entry->stock_in]);

        $entry->delete();

        return redirect()->route('entry_books.index')->with('success', 'Data barang masuk berhasil dihapus.');
    }
}
