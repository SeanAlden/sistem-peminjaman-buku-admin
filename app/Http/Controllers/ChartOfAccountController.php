<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChartOfAccount;

class ChartOfAccountController extends Controller
{
    public function index(Request $request)
    {
        // $accounts = ChartOfAccount::all();
        // return view('accounts.index', compact('accounts'));

        // // Mengambil nilai 'search' dari request, defaultnya string kosong
        $search = $request->input('search', '');

        // Mengambil nilai 'per_page' dari request, defaultnya 10
        // dan memastikan nilainya adalah integer
        $perPage = (int) $request->input('per_page', 5);

        // Memulai query pada model Supplier
        // $query = Book::query();
        $query = ChartOfAccount::query();

        // Jika ada keyword pencarian, tambahkan kondisi where
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->
                    where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Lakukan pagination pada hasil query
        // 'appends' digunakan agar parameter 'search' dan 'per_page' tetap ada di URL pagination
        $accounts = $query->paginate($perPage)->appends($request->except('page'));

        // Kembalikan view 'suppliers.supplier_list' dengan data suppliers, search, dan perPage
        return view('accounts.index', compact('accounts', 'search', 'perPage'));
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:chart_of_accounts,code',
            'name' => 'required',
            'type' => 'required|in:asset,liability,equity,revenue,expense'
        ]);

        ChartOfAccount::create($request->all());

        return redirect()->route('accounts.index')->with('success', 'Account created successfully.');
    }

    public function edit($id)
    {
        $account = ChartOfAccount::findOrFail($id);
        return view('accounts.edit', compact('account'));
    }

    public function update(Request $request, $id)
    {
        $account = ChartOfAccount::findOrFail($id);

        $request->validate([
            'code' => 'required|unique:chart_of_accounts,code,'.$account->id,
            'name' => 'required',
            'type' => 'required|in:asset,liability,equity,revenue,expense'
        ]);

        $account->update($request->all());

        return redirect()->route('accounts.index')->with('success', 'Account updated successfully.');
    }

    public function destroy($id)
    {
        ChartOfAccount::destroy($id);
        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully.');
    }
}
