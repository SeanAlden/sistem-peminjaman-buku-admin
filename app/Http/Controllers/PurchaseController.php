<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    // public function index(Request $request)
    // {
    //     // $purchases = Purchase::with(['supplier', 'book'])->get();
    //     // return view('purchases.purchase_list', compact('purchases'));

    //     // Mengambil nilai 'search' dari request, defaultnya string kosong
    //     $search = $request->input('search', '');

    //     // Mengambil nilai 'per_page' dari request, defaultnya 10
    //     // dan memastikan nilainya adalah integer
    //     $perPage = (int) $request->input('per_page', 5);

    //     // Memulai query pada model Purchase
    //     // $query = Book::query();
    //     $query = Purchase::query();

    //     // Jika ada keyword pencarian, tambahkan kondisi where
    //     if (!empty($search)) {
    //         $query->where(function ($q) use ($search) {
    //             $q->
    //                 where('total_price', 'like', "%{$search}%")
    //                 ->orWhere('notes', 'like', "%{$search}%")
    //                 ->orWhereHas('book', function ($q2) use ($search) {
    //                     $q2->where('title', 'like', "%{$search}%");
    //                 })
    //                 ->orWhereHas('supplier', function ($q2) use ($search) {
    //                     $q2->where('name', 'like', "%{$search}%");
    //                 });
    //         });
    //     }

    //     // Lakukan pagination pada hasil query
    //     // 'appends' digunakan agar parameter 'search' dan 'per_page' tetap ada di URL pagination
    //     $purchases = $query->paginate($perPage)->appends($request->except('page'));

    //     // Kembalikan view 'purchases.purchase_list' dengan data suppliers, search, dan perPage
    //     return view('purchases.purchase_list', compact('purchases', 'search', 'perPage'));
    // }

    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = (int) $request->input('per_page', 5);

        // Memulai query pada model Purchase
        $query = Purchase::with(['supplier', 'book']); // Eager load relasi

        // ... (logika pencarian Anda tidak perlu diubah) ...
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('total_price', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%")
                    ->orWhereHas('book', function ($q2) use ($search) {
                        $q2->where('title', 'like', "%{$search}%");
                    })
                    ->orWhereHas('supplier', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // --- PERUBAHAN 1: Mengurutkan data berdasarkan buku ---
        // Ini akan mengelompokkan semua pembelian untuk buku yang sama secara visual.
        $query->orderBy('book_id', 'asc')->orderBy('purchase_date', 'asc');

        $purchases = $query->paginate($perPage)->appends($request->except('page'));

        // --- PERUBAHAN 2: Menghitung total kuantitas awal untuk setiap buku ---
        // Kita membuat sebuah array asosiatif [book_id => total_quantity]
        $bookTotalQuantities = Purchase::select('book_id', DB::raw('SUM(initial_quantity) as total'))
            ->groupBy('book_id')
            ->pluck('total', 'book_id');

        // Kembalikan view dengan data tambahan '$bookTotalQuantities'
        return view('purchases.purchase_list', compact('purchases', 'bookTotalQuantities', 'search', 'perPage'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $books = Book::all();
        return view('purchases.add_purchase', compact('suppliers', 'books'));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'supplier_id' => 'required',
        //     'book_id' => 'required',
        //     'quantity' => 'nullable|integer|min:1',
        //     'purchase_date' => 'required|date',
        //     'total_price' => 'required|numeric',
        //     'notes'=> 'nullable'
        // ]);

        // Purchase::create($request->all());

        Purchase::create([
            'supplier_id' => $request->supplier_id,
            'book_id' => $request->book_id,
            'quantity' => $request->quantity,
            'initial_quantity' => $request->quantity, // isi sama dengan quantity saat pertama kali
            'purchase_date' => $request->purchase_date,
            'total_price' => $request->total_price,
            'notes' => $request->notes,
        ]);
        return redirect()->route('purchases.index')->with('success', 'Pengadaan berhasil disimpan.');
    }
    // public function edit($id)
    // {
    //     $purchase = Purchase::findOrFail($id);
    //     $suppliers = Supplier::all();
    //     $books = Book::all();
    //     return response()->json(['purchase' => $purchase, 'suppliers' => $suppliers, 'books' => $books]);
    // }

    public function edit($id)
    {
        $purchase = Purchase::findOrFail($id);
        $suppliers = Supplier::all();
        $books = Book::all();
        return view('purchases.edit_purchase', compact('purchase', 'suppliers', 'books'));
    }

    public function update(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);
        $request->validate([
            'supplier_id' => 'required',
            'book_id' => 'required',
            'initial_quantity' => 'required|integer|min:1',
            'purchase_date' => 'required|date',
            'total_price' => 'required|numeric',
        ]);
        $purchase->update($request->all());
        return redirect()->route('purchases.index')->with('success', 'Data pengadaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Purchase::destroy($id);
        return redirect()->route('purchases.index')->with('success', 'Data pengadaan berhasil dihapus.');
    }

}
