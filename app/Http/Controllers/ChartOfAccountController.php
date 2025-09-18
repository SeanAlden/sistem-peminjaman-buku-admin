<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChartOfAccount;

class ChartOfAccountController extends Controller
{
    public function index()
    {
        $accounts = ChartOfAccount::all();
        return view('accounts.index', compact('accounts'));
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
