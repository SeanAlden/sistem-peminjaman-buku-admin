<?php

// namespace App\Http\Controllers;

// use App\Models\Book;
// use App\Models\Purchase;
// use App\Models\EntryBook;
// use Illuminate\Http\Request;

// class EntryBookController extends Controller
// {
//     public function index(Request $request)
//     {
//         // $entries = EntryBook::with('book.category')->latest()->get();

//         // $books = Book::all();

//         // // Ambil stok maksimum dari tabel purchases
//         // $purchaseStockMap = Purchase::selectRaw('book_id, SUM(quantity) as total')
//         //     ->groupBy('book_id')
//         //     ->pluck('total', 'book_id');

//         // return view('entry_books.entry_books', compact('entries', 'books', 'purchaseStockMap'));

//         // Mengambil nilai 'search' dari request, defaultnya string kosong
//         $search = $request->input('search', '');

//         // Mengambil nilai 'per_page' dari request, defaultnya 5
//         // dan memastikan nilainya adalah integer
//         $perPage = (int) $request->input('per_page', 5);

//         // Memulai query pada model EntryBook
//         $query = EntryBook::with('book.category')->latest();

//         // Jika ada keyword pencarian, tambahkan kondisi where
//         if (!empty($search)) {
//             $query->where(function ($q) use ($search) {
//                 $q->
//                     where('stock_before', 'like', "%{$search}%")
//                     ->orWhere('stock_in', 'like', "%{$search}%")
//                     ->orWhere('stock_after', 'like', "%{$search}%")
//                     ->orWhereHas('book', function ($q2) use ($search) {
//                         $q2->where('title', 'like', "%{$search}%")
//                             ->orWhereHas('category', function ($q2) use ($search) {
//                                 $q2->where('name', 'like', "%{$search}%");
//                             });
//                     });
//             });
//         }

//         $books = Book::all();

//         $entries = $query->paginate($perPage)->appends($request->except('page'));
//         // Lakukan pagination pada hasil query
//         // 'appends' digunakan agar parameter 'search' dan 'per_page' tetap ada di URL pagination

//         $purchaseStockMap = Purchase::selectRaw('book_id, SUM(quantity) as total')
//             ->groupBy('book_id')
//             ->pluck('total', 'book_id');

//         // Kembalikan view 
//         return view('entry_books.entry_books', compact('entries', 'books', 'purchaseStockMap', 'search', 'perPage'));
//     }

//     public function create()
//     {
//         $books = Book::whereHas('purchases')->get();
//         return response()->json($books);
//     }

//     // public function store(Request $request)
//     // {
//     //     $request->validate([
//     //         'book_id' => 'required|exists:books,id',
//     //         'stock_in' => 'required|integer|min:1',
//     //     ]);

//     //     $book = Book::findOrFail($request->book_id);
//     //     $purchase = Purchase::where('book_id', $book->id)->latest()->first();

//     //     if (!$purchase) {
//     //         return back()->withErrors(['book_id' => 'Tidak ada data pembelian untuk buku ini.']);
//     //     }

//     //     // Hitung total entry untuk pembelian ini
//     //     $totalEntries = EntryBook::where('purchase_id', $purchase->id)->sum('stock_in');

//     //     if ($totalEntries + $request->stock_in > $purchase->quantity) {
//     //         return back()->withErrors(['stock_in' => 'Jumlah barang masuk melebihi kuantitas pembelian.']);
//     //     }

//     //     $stockBefore = $book->stock;
//     //     $stockAfter = $stockBefore + $request->stock_in;

//     //     // Tambahkan entry book
//     //     EntryBook::create([
//     //         'book_id' => $book->id,
//     //         'purchase_id' => $purchase->id,
//     //         'stock_before' => $stockBefore,
//     //         'stock_in' => $request->stock_in,
//     //         'stock_after' => $stockAfter,
//     //     ]);

//     //     // Update stok di books
//     //     $book->update(['stock' => $stockAfter]);

//     //     return redirect()->route('entry_books.index')->with('success', 'Barang masuk berhasil dicatat.');
//     // }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'book_id' => 'required|exists:books,id',
//             'stock_in' => 'required|integer|min:1',
//         ]);

//         $book = Book::findOrFail($request->book_id);
//         $purchase = Purchase::where('book_id', $book->id)->latest()->first();

//         if (!$purchase) {
//             return back()->withErrors(['book_id' => 'Tidak ada data pembelian untuk buku ini.']);
//         }

//         // Hitung total entry untuk pembelian ini
//         $totalEntries = EntryBook::where('purchase_id', $purchase->id)->sum('stock_in');

//         if ($totalEntries + $request->stock_in > $purchase->quantity) {
//             return back()->withErrors(['stock_in' => 'Jumlah barang masuk melebihi kuantitas pembelian.']);
//         }

//         $stockBefore = $book->stock;
//         $stockAfter = $stockBefore + $request->stock_in;

//         // Tambahkan entry book
//         EntryBook::create([
//             'book_id' => $book->id,
//             'purchase_id' => $purchase->id,
//             'stock_before' => $stockBefore,
//             'stock_in' => $request->stock_in,
//             'stock_after' => $stockAfter,
//         ]);

//         // Update stok di tabel books
//         $book->update(['stock' => $stockAfter]);

//         // ✅ Update sisa quantity di tabel purchases
//         $purchase->update([
//             'quantity' => $purchase->quantity - $request->stock_in,
//         ]);

//         return redirect()->route('entry_books.index')->with('success', 'Barang masuk berhasil dicatat.');
//     }

//     public function edit($id)
//     {
//         $entry = EntryBook::with('book')->findOrFail($id);
//         return response()->json($entry);
//     }

//     public function update(Request $request, $id)
//     {
//         $entry = EntryBook::findOrFail($id);
//         $book = $entry->book;
//         $purchase = $entry->purchase;

//         $request->validate([
//             'stock_in' => 'required|integer|min:1',
//         ]);

//         $totalOtherEntries = EntryBook::where('purchase_id', $purchase->id)
//             ->where('id', '!=', $entry->id)
//             ->sum('stock_in');

//         if ($totalOtherEntries + $request->stock_in > $purchase->quantity) {
//             return back()->withErrors(['stock_in' => 'Jumlah barang masuk melebihi kuantitas pembelian.']);
//         }

//         // Update stok buku
//         $newStock = $book->stock - $entry->stock_in + $request->stock_in;

//         $entry->update([
//             'stock_before' => $book->stock - $entry->stock_in,
//             'stock_in' => $request->stock_in,
//             'stock_after' => $newStock,
//         ]);

//         $book->update(['stock' => $newStock]);

//         return redirect()->route('entry_books.index')->with('success', 'Barang masuk berhasil diperbarui.');
//     }

//     public function destroy($id)
//     {
//         $entry = EntryBook::findOrFail($id);
//         $book = $entry->book;

//         // Kurangi stok
//         $book->update(['stock' => $book->stock - $entry->stock_in]);

//         $entry->delete();

//         return redirect()->route('entry_books.index')->with('success', 'Data barang masuk berhasil dihapus.');
//     }
// }



// namespace App\Http\Controllers;

// use App\Models\Book;
// use App\Models\Purchase;
// use App\Models\EntryBook;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Log; // Pastikan ini di-import

// class EntryBookController extends Controller
// {
//     public function index(Request $request)
//     {
//         Log::info('Mengakses halaman daftar barang masuk.', ['request' => $request->all()]);

//         $search = $request->input('search', '');
//         $perPage = (int) $request->input('per_page', 5);

//         $query = EntryBook::with('book.category')->latest();

//         if (!empty($search)) {
//             Log::info('Melakukan pencarian barang masuk dengan keyword.', ['search' => $search]);
//             $query->where(function ($q) use ($search) {
//                 $q->where('stock_before', 'like', "%{$search}%")
//                   ->orWhere('stock_in', 'like', "%{$search}%")
//                   ->orWhere('stock_after', 'like', "%{$search}%")
//                   ->orWhereHas('book', function ($q2) use ($search) {
//                       $q2->where('title', 'like', "%{$search}%")
//                          ->orWhereHas('category', function ($q3) use ($search) {
//                              $q3->where('name', 'like', "%{$search}%");
//                          });
//                   });
//             });
//         }

//         $books = Book::all();
//         $entries = $query->paginate($perPage)->appends($request->except('page'));
//         $purchaseStockMap = Purchase::selectRaw('book_id, SUM(quantity) as total')
//             ->groupBy('book_id')
//             ->pluck('total', 'book_id');

//         Log::info('Menampilkan data barang masuk ke view.', ['total_entries' => $entries->total()]);
//         return view('entry_books.entry_books', compact('entries', 'books', 'purchaseStockMap', 'search', 'perPage'));
//     }

//     public function create()
//     {
//         Log::info('Mengambil data buku untuk form barang masuk.');
//         $books = Book::whereHas('purchases')->get();
//         return response()->json($books);
//     }

//     public function store(Request $request)
//     {
//         Log::info('Memulai proses pencatatan barang masuk baru.', ['request_data' => $request->all()]);

//         $request->validate([
//             'book_id' => 'required|exists:books,id',
//             'stock_in' => 'required|integer|min:1',
//         ]);

//         $book = Book::findOrFail($request->book_id);
//         $purchase = Purchase::where('book_id', $book->id)->latest()->first();

//         if (!$purchase) {
//             Log::warning('Gagal mencatat barang masuk: Tidak ada data pembelian.', ['book_id' => $book->id]);
//             return back()->withErrors(['book_id' => 'Tidak ada data pembelian untuk buku ini.']);
//         }

//         $totalEntries = EntryBook::where('purchase_id', $purchase->id)->sum('stock_in');
//         if ($totalEntries + $request->stock_in > $purchase->initial_quantity) { // Validasi ke initial_quantity
//             Log::error('Gagal mencatat barang masuk: Jumlah melebihi kuantitas pembelian.', [
//                 'purchase_id' => $purchase->id,
//                 'purchase_quantity' => $purchase->initial_quantity,
//                 'total_entries' => $totalEntries,
//                 'requested_stock_in' => $request->stock_in
//             ]);
//             return back()->withErrors(['stock_in' => 'Jumlah barang masuk melebihi kuantitas pembelian awal.']);
//         }

//         $stockBefore = $book->stock;
//         $stockAfter = $stockBefore + $request->stock_in;

//         $entry = EntryBook::create([
//             'book_id' => $book->id,
//             'purchase_id' => $purchase->id,
//             'stock_before' => $stockBefore,
//             'stock_in' => $request->stock_in,
//             'stock_after' => $stockAfter,
//         ]);
//         Log::info('Data barang masuk berhasil dibuat.', ['entry_id' => $entry->id]);

//         $book->update(['stock' => $stockAfter]);
//         Log::info('Stok buku berhasil diperbarui.', ['book_id' => $book->id, 'new_stock' => $stockAfter]);

//         // Opsi: Anda bisa memilih untuk tidak mengurangi quantity di purchases agar data historis pembelian tetap utuh
//         // $purchase->decrement('quantity', $request->stock_in);
//         // Log::info('Sisa kuantitas pembelian diperbarui.', ['purchase_id' => $purchase->id, 'remaining_quantity' => $purchase->fresh()->quantity]);

//         return redirect()->route('entry_books.index')->with('success', 'Barang masuk berhasil dicatat.');
//     }

//     public function edit($id)
//     {
//         Log::info('Mengambil data entry book untuk diedit.', ['entry_id' => $id]);
//         $entry = EntryBook::with('book')->findOrFail($id);
//         return response()->json($entry);
//     }

//     public function update(Request $request, $id)
//     {
//         Log::info('Memulai proses update data barang masuk.', ['entry_id' => $id, 'request_data' => $request->all()]);

//         $entry = EntryBook::findOrFail($id);
//         $book = $entry->book;
//         $purchase = $entry->purchase;
//         $oldStockIn = $entry->stock_in; // Simpan nilai lama

//         $request->validate(['stock_in' => 'required|integer|min:1']);

//         $totalOtherEntries = EntryBook::where('purchase_id', $purchase->id)
//             ->where('id', '!=', $entry->id)
//             ->sum('stock_in');

//         if ($totalOtherEntries + $request->stock_in > $purchase->initial_quantity) { // Validasi ke initial_quantity
//             Log::error('Gagal update barang masuk: Jumlah melebihi kuantitas pembelian.', [
//                 'purchase_id' => $purchase->id,
//                 'purchase_quantity' => $purchase->initial_quantity,
//                 'total_other_entries' => $totalOtherEntries,
//                 'requested_stock_in' => $request->stock_in
//             ]);
//             return back()->withErrors(['stock_in' => 'Jumlah barang masuk melebihi kuantitas pembelian awal.']);
//         }

//         // Hitung selisih stok untuk update
//         $stockDifference = $request->stock_in - $oldStockIn;
//         $newBookStock = $book->stock + $stockDifference;

//         $entry->update([
//             'stock_in' => $request->stock_in,
//             'stock_after' => $entry->stock_before + $request->stock_in, // Sesuaikan stock_after
//         ]);
//         Log::info('Data barang masuk berhasil diupdate.', ['entry_id' => $entry->id]);

//         $book->update(['stock' => $newBookStock]);
//         Log::info('Stok buku berhasil diupdate setelah edit.', ['book_id' => $book->id, 'new_stock' => $newBookStock]);

//         return redirect()->route('entry_books.index')->with('success', 'Barang masuk berhasil diperbarui.');
//     }

//     public function destroy($id)
//     {
//         Log::info('Memulai proses penghapusan data barang masuk.', ['entry_id' => $id]);

//         $entry = EntryBook::findOrFail($id);
//         $book = $entry->book;
//         $stockToRevert = $entry->stock_in;

//         // Kurangi stok buku sejumlah yang dihapus
//         $newStock = $book->stock - $stockToRevert;
//         $book->update(['stock' => $newStock]);
//         Log::info('Stok buku dikembalikan setelah data barang masuk dihapus.', ['book_id' => $book->id, 'reverted_stock' => $stockToRevert, 'new_stock' => $newStock]);

//         $entry->delete();
//         Log::info('Data barang masuk berhasil dihapus dari database.', ['entry_id' => $id]);

//         return redirect()->route('entry_books.index')->with('success', 'Data barang masuk berhasil dihapus.');
//     }
// }



namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Purchase;
use App\Models\EntryBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Pastikan ini di-import

class EntryBookController extends Controller
{
    public function index(Request $request)
    {
        Log::info('Mengakses halaman daftar barang masuk.', ['request' => $request->all()]);

        $search = $request->input('search', '');
        $perPage = (int) $request->input('per_page', 5);

        $query = EntryBook::with('book.category')->latest();

        if (!empty($search)) {
            Log::info('Melakukan pencarian barang masuk dengan keyword.', ['search' => $search]);
            $query->where(function ($q) use ($search) {
                $q->where('stock_before', 'like', "%{$search}%")
                    ->orWhere('stock_in', 'like', "%{$search}%")
                    ->orWhere('stock_after', 'like', "%{$search}%")
                    ->orWhereHas('book', function ($q2) use ($search) {
                        $q2->where('title', 'like', "%{$search}%")
                            ->orWhereHas('category', function ($q3) use ($search) {
                                $q3->where('name', 'like', "%{$search}%");
                            });
                    });
            });
        }

        $books = Book::all();
        $entries = $query->paginate($perPage)->appends($request->except('page'));
        $purchaseStockMap = Purchase::selectRaw('book_id, SUM(quantity) as total')
            ->groupBy('book_id')
            ->pluck('total', 'book_id');

        Log::info('Menampilkan data barang masuk ke view.', ['total_entries' => $entries->total()]);
        return view('entry_books.entry_books', compact('entries', 'books', 'purchaseStockMap', 'search', 'perPage'));
    }

    public function create()
    {
        Log::info('Mengambil data buku untuk form barang masuk.');
        $books = Book::whereHas('purchases')->get();
        return response()->json($books);
    }

    // public function store(Request $request)
    // {
    //     Log::info('Memulai proses pencatatan barang masuk baru.', ['request_data' => $request->all()]);

    //     $request->validate([
    //         'book_id' => 'required|exists:books,id',
    //         'stock_in' => 'required|integer|min:1',
    //     ]);

    //     $book = Book::findOrFail($request->book_id);

    //     // --- PERBAIKAN LOGIKA DIMULAI DI SINI ---

    //     // 1. Ambil SEMUA purchase record untuk buku ini
    //     $purchases = Purchase::where('book_id', $book->id)->get();

    //     if ($purchases->isEmpty()) {
    //         Log::warning('Gagal mencatat barang masuk: Tidak ada data pembelian.', ['book_id' => $book->id]);
    //         return back()->withErrors(['book_id' => 'Tidak ada data pembelian untuk buku ini.']);
    //     }

    //     // 2. Hitung total kuantitas pembelian dan total barang yang sudah masuk
    //     $totalPurchaseQuantity = $purchases->sum('initial_quantity');
    //     $totalEntries = EntryBook::whereIn('purchase_id', $purchases->pluck('id'))->sum('stock_in');

    //     // 3. Validasi berdasarkan total
    //     if ($totalEntries + $request->stock_in > $totalPurchaseQuantity) {
    //         Log::error('Gagal mencatat barang masuk: Jumlah melebihi total kuantitas pembelian.', [
    //             'book_id' => $book->id,
    //             'total_purchase_quantity' => $totalPurchaseQuantity,
    //             'current_total_entries' => $totalEntries,
    //             'requested_stock_in' => $request->stock_in
    //         ]);
    //         return back()->withErrors(['stock_in' => 'Jumlah barang masuk melebihi total kuantitas dari semua pembelian.']);
    //     }

    //     // 4. Tetap asosiasikan dengan purchase TERBARU untuk pencatatan
    //     $latestPurchase = $purchases->sortByDesc('created_at')->first();

    //     // --- AKHIR PERBAIKAN LOGIKA ---

    //     $stockBefore = $book->stock;
    //     $stockAfter = $stockBefore + $request->stock_in;

    //     $entry = EntryBook::create([
    //         'book_id' => $book->id,
    //         'purchase_id' => $latestPurchase->id, // Gunakan ID purchase terbaru
    //         'stock_before' => $stockBefore,
    //         'stock_in' => $request->stock_in,
    //         'stock_after' => $stockAfter,
    //     ]);
    //     Log::info('Data barang masuk berhasil dibuat.', ['entry_id' => $entry->id, 'associated_purchase_id' => $latestPurchase->id]);

    //     $book->update(['stock' => $stockAfter]);
    //     Log::info('Stok buku berhasil diperbarui.', ['book_id' => $book->id, 'new_stock' => $stockAfter]);

    //     return redirect()->route('entry_books.index')->with('success', 'Barang masuk berhasil dicatat.');
    // }

    // public function edit($id)
    // {
    //     Log::info('Mengambil data entry book untuk diedit.', ['entry_id' => $id]);
    //     $entry = EntryBook::with('book')->findOrFail($id);
    //     return response()->json($entry);
    // }

    // public function update(Request $request, $id)
    // {
    //     Log::info('Memulai proses update data barang masuk.', ['entry_id' => $id, 'request_data' => $request->all()]);

    //     $entry = EntryBook::findOrFail($id);
    //     $book = $entry->book;
    //     $oldStockIn = $entry->stock_in; // Simpan nilai lama

    //     $request->validate(['stock_in' => 'required|integer|min:1']);

    //     // --- PERBAIKAN LOGIKA VALIDASI UPDATE ---
    //     $allBookPurchases = Purchase::where('book_id', $book->id)->get();
    //     $totalPurchaseQuantity = $allBookPurchases->sum('initial_quantity');

    //     // Hitung total entry lain untuk buku ini (di semua purchase record terkait)
    //     $totalOtherEntries = EntryBook::whereIn('purchase_id', $allBookPurchases->pluck('id'))
    //         ->where('id', '!=', $entry->id)
    //         ->sum('stock_in');

    //     if ($totalOtherEntries + $request->stock_in > $totalPurchaseQuantity) {
    //         Log::error('Gagal update barang masuk: Jumlah melebihi total kuantitas pembelian.', [
    //             'book_id' => $book->id,
    //             'total_purchase_quantity' => $totalPurchaseQuantity,
    //             'total_other_entries' => $totalOtherEntries,
    //             'requested_stock_in' => $request->stock_in
    //         ]);
    //         return back()->withErrors(['stock_in' => 'Jumlah barang masuk melebihi total kuantitas dari semua pembelian.']);
    //     }
    //     // --- AKHIR PERBAIKAN ---

    //     // Hitung selisih stok untuk update
    //     $stockDifference = $request->stock_in - $oldStockIn;
    //     $newBookStock = $book->stock + $stockDifference;

    //     $entry->update([
    //         'stock_in' => $request->stock_in,
    //         'stock_after' => $entry->stock_before + $request->stock_in, // Sesuaikan stock_after
    //     ]);
    //     Log::info('Data barang masuk berhasil diupdate.', ['entry_id' => $entry->id]);

    //     $book->update(['stock' => $newBookStock]);
    //     Log::info('Stok buku berhasil diupdate setelah edit.', ['book_id' => $book->id, 'new_stock' => $newBookStock]);

    //     return redirect()->route('entry_books.index')->with('success', 'Barang masuk berhasil diperbarui.');
    // }

    // public function destroy($id)
    // {
    //     Log::info('Memulai proses penghapusan data barang masuk.', ['entry_id' => $id]);

    //     $entry = EntryBook::findOrFail($id);
    //     $book = $entry->book;
    //     $stockToRevert = $entry->stock_in;

    //     // Kurangi stok buku sejumlah yang dihapus
    //     $newStock = $book->stock - $stockToRevert;
    //     $book->update(['stock' => $newStock]);
    //     Log::info('Stok buku dikembalikan setelah data barang masuk dihapus.', ['book_id' => $book->id, 'reverted_stock' => $stockToRevert, 'new_stock' => $newStock]);

    //     $entry->delete();
    //     Log::info('Data barang masuk berhasil dihapus dari database.', ['entry_id' => $id]);

    //     return redirect()->route('entry_books.index')->with('success', 'Data barang masuk berhasil dihapus.');
    // }

    public function store(Request $request)
    {
        Log::info('Memulai proses pencatatan barang masuk baru.', ['request_data' => $request->all()]);

        $request->validate([
            'book_id' => 'required|exists:books,id',
            'stock_in' => 'required|integer|min:1',
        ]);

        $book = Book::findOrFail($request->book_id);

        // Menggunakan transaction untuk memastikan semua proses berhasil atau dibatalkan
        DB::transaction(function () use ($request, $book) {
            $stockToEntry = $request->stock_in;

            // 1. Validasi total kuantitas yang tersedia (sisa)
            $availableQuantity = Purchase::where('book_id', $book->id)->sum('quantity');
            if ($stockToEntry > $availableQuantity) {
                // Menggunakan \ValidationException agar bisa ditangkap oleh Laravel
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'stock_in' => 'Jumlah barang masuk melebihi sisa kuantitas dari semua pembelian (' . $availableQuantity . ' unit).',
                ]);
            }

            // 2. Buat record di entry_books
            $stockBefore = $book->stock;
            $stockAfter = $stockBefore + $stockToEntry;

            // Kita perlu purchase_id untuk entry_book, kita ambil yang terbaru
            $latestPurchase = Purchase::where('book_id', $book->id)->latest()->first();

            $entry = EntryBook::create([
                'book_id' => $book->id,
                'purchase_id' => $latestPurchase->id,
                'stock_before' => $stockBefore,
                'stock_in' => $stockToEntry,
                'stock_after' => $stockAfter,
            ]);
            Log::info('Data barang masuk berhasil dibuat.', ['entry_id' => $entry->id]);

            // 3. Update stok utama di tabel books
            $book->update(['stock' => $stockAfter]);
            Log::info('Stok buku berhasil diperbarui.', ['book_id' => $book->id, 'new_stock' => $stockAfter]);

            // 4. --- LOGIKA FIFO UNTUK MENGURANGI KUANTITAS ---
            $purchasesToDeduct = Purchase::where('book_id', $book->id)
                ->where('quantity', '>', 0)
                ->orderBy('purchase_date', 'asc') // Urutkan dari yang paling lama
                ->get();

            foreach ($purchasesToDeduct as $purchase) {
                if ($stockToEntry <= 0)
                    break; // Berhenti jika semua stok sudah dialokasikan

                $deductAmount = min($stockToEntry, $purchase->quantity);

                $purchase->decrement('quantity', $deductAmount);
                Log::info('Mengurangi kuantitas dari pembelian.', [
                    'purchase_id' => $purchase->id,
                    'deducted' => $deductAmount,
                    'remaining' => $purchase->quantity - $deductAmount
                ]);

                $stockToEntry -= $deductAmount;
            }
        });

        return redirect()->route('entry_books.index')->with('success', 'Barang masuk berhasil dicatat.');
    }

    public function edit($id)
    {
        Log::info('Mengambil data entry book untuk diedit.', ['entry_id' => $id]);
        $entry = EntryBook::with('book')->findOrFail($id);
        return response()->json($entry);
    }

    public function update(Request $request, $id)
    {
        Log::info('Memulai proses update data barang masuk.', ['entry_id' => $id, 'request_data' => $request->all()]);

        $request->validate(['stock_in' => 'required|integer|min:1']);

        DB::transaction(function () use ($request, $id) {
            $entry = EntryBook::findOrFail($id);
            $book = $entry->book;
            $oldStockIn = $entry->stock_in;
            $newStockIn = $request->stock_in;

            // 1. Validasi: Cek apakah stok tersedia untuk diubah
            $currentAvailableQuantity = Purchase::where('book_id', $book->id)->sum('quantity');
            $requiredQuantity = $newStockIn - $oldStockIn; // Kebutuhan stok tambahan

            if ($requiredQuantity > $currentAvailableQuantity) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'stock_in' => 'Perubahan jumlah melebihi sisa kuantitas pembelian (' . $currentAvailableQuantity . ' unit).',
                ]);
            }

            // 2. --- LOGIKA FIFO UNTUK MENGEMBALIKAN KUANTITAS LAMA ---
            $this->restorePurchaseQuantity($book, $oldStockIn);

            // 3. --- LOGIKA FIFO UNTUK MENGURANGI KUANTITAS BARU ---
            $this->deductPurchaseQuantity($book, $newStockIn);

            // 4. Update stok buku utama
            $stockDifference = $newStockIn - $oldStockIn;
            $newBookStock = $book->stock + $stockDifference;
            $book->update(['stock' => $newBookStock]);
            Log::info('Stok buku berhasil diupdate setelah edit.', ['book_id' => $book->id, 'new_stock' => $newBookStock]);

            // 5. Update record entry book itu sendiri
            $entry->update([
                'stock_in' => $newStockIn,
                'stock_after' => $entry->stock_before + $newBookStock,
            ]);
            Log::info('Data barang masuk berhasil diupdate.', ['entry_id' => $entry->id]);
        });

        return redirect()->route('entry_books.index')->with('success', 'Barang masuk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Log::info('Memulai proses penghapusan data barang masuk.', ['entry_id' => $id]);

        DB::transaction(function () use ($id) {
            $entry = EntryBook::findOrFail($id);
            $book = $entry->book;
            $stockToRevert = $entry->stock_in;

            // 1. Kurangi stok buku utama
            $newStock = $book->stock - $stockToRevert;
            $book->update(['stock' => $newStock]);
            Log::info('Stok buku dikurangi setelah data barang masuk dihapus.', ['book_id' => $book->id, 'new_stock' => $newStock]);

            // 2. --- LOGIKA FIFO UNTUK MENGEMBALIKAN KUANTITAS ---
            $this->restorePurchaseQuantity($book, $stockToRevert);

            // 3. Hapus record entry book
            $entry->delete();
            Log::info('Data barang masuk berhasil dihapus dari database.', ['entry_id' => $id]);
        });

        return redirect()->route('entry_books.index')->with('success', 'Data barang masuk berhasil dihapus.');
    }

    /**
     * Helper function untuk mengurangi kuantitas pembelian (FIFO).
     */
    private function deductPurchaseQuantity(Book $book, int $amount)
    {
        $purchases = Purchase::where('book_id', $book->id)
            ->where('quantity', '>', 0)
            ->orderBy('purchase_date', 'asc')
            ->get();

        foreach ($purchases as $purchase) {
            if ($amount <= 0)
                break;
            $deduct = min($amount, $purchase->quantity);
            $purchase->decrement('quantity', $deduct);
            Log::info('FIFO Deduct:', ['purchase_id' => $purchase->id, 'amount' => $deduct]);
            $amount -= $deduct;
        }
    }

    /**
     * Helper function untuk mengembalikan kuantitas pembelian (Reverse FIFO).
     */
    private function restorePurchaseQuantity(Book $book, int $amount)
    {
        // Saat mengembalikan, kita isi dari pembelian terbaru yang belum penuh
        $purchases = Purchase::where('book_id', $book->id)
            ->whereColumn('quantity', '<', 'initial_quantity')
            ->orderBy('purchase_date', 'desc')
            ->get();

        foreach ($purchases as $purchase) {
            if ($amount <= 0)
                break;
            $availableSpace = $purchase->initial_quantity - $purchase->quantity;
            $restore = min($amount, $availableSpace);
            $purchase->increment('quantity', $restore);
            Log::info('FIFO Restore:', ['purchase_id' => $purchase->id, 'amount' => $restore]);
            $amount -= $restore;
        }
    }
}

