<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ExitBook;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ExitBookController extends Controller
{
    public function index()
    {
        $exits = ExitBook::with(['book.category', 'supplier'])->latest()->get();
        $books = Book::all();
        $suppliers = Supplier::all();

        return view('exit_books.exit_books', compact('exits', 'books', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'stock_out' => 'required|integer|min:1',
            'reason' => 'nullable|string',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($request->stock_out > $book->stock) {
            return back()->withErrors(['stock_out' => 'Jumlah barang keluar melebihi stok tersedia.']);
        }

        $stockBefore = $book->stock;
        $stockAfter = $stockBefore - $request->stock_out;

        ExitBook::create([
            'book_id' => $book->id,
            'supplier_id' => $request->supplier_id,
            'stock_before' => $stockBefore,
            'stock_out' => $request->stock_out,
            'stock_after' => $stockAfter,
            'reason' => $request->reason,
        ]);

        $book->update(['stock' => $stockAfter]);

        return redirect()->route('exit_books.index')->with('success', 'Barang keluar berhasil dicatat.');
    }

    public function edit($id)
    {
        $exit = ExitBook::findOrFail($id);
        $books = Book::all();
        $suppliers = Supplier::all();

        return view('exit_books.edit', compact('exit', 'books', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $exit = ExitBook::findOrFail($id);
        $book = Book::findOrFail($request->book_id);

        $request->validate([
            'book_id' => 'required|exists:books,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'stock_out' => 'required|integer|min:1',
            'reason' => 'nullable|string',
        ]);

        // Kembalikan stok lama sebelum update
        $book->stock += $exit->stock_out;

        if ($request->stock_out > $book->stock) {
            return back()->withErrors(['stock_out' => 'Jumlah barang keluar melebihi stok tersedia saat ini.']);
        }

        $stockBefore = $book->stock;
        $stockAfter = $stockBefore - $request->stock_out;

        $exit->update([
            'book_id' => $request->book_id,
            'supplier_id' => $request->supplier_id,
            'stock_before' => $stockBefore,
            'stock_out' => $request->stock_out,
            'stock_after' => $stockAfter,
            'reason' => $request->reason,
        ]);

        $book->stock = $stockAfter;
        $book->save();

        return redirect()->route('exit_books.index')->with('success', 'Data barang keluar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $exit = ExitBook::findOrFail($id);
        $book = $exit->book;

        // Kembalikan stok
        $book->update(['stock' => $book->stock + $exit->stock_out]);

        $exit->delete();

        return redirect()->route('exit_books.index')->with('success', 'Data barang keluar berhasil dihapus.');
    }
}

