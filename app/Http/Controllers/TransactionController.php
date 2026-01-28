<?php

// namespace App\Http\Controllers;

// use App\Models\Transaction;
// use App\Models\JournalEntry;
// use Illuminate\Http\Request;
// use App\Models\ChartOfAccount;

// class TransactionController extends Controller
// {
//     public function index()
//     {
//         $transactions = Transaction::with('journalEntries.account')->get();
//         return view('transactions.index', compact('transactions'));
//     }

//     public function create()
//     {
//         $accounts = ChartOfAccount::all();
//         return view('transactions.create', compact('accounts'));
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'reference' => 'required|unique:transactions,reference',
//             'transaction_date' => 'required|date',
//             'journal.*.coa_id' => 'required|exists:chart_of_accounts,id',
//             'journal.*.debit' => 'nullable|numeric',
//             'journal.*.credit' => 'nullable|numeric'
//         ]);

//         $transaction = Transaction::create($request->only(['reference','description','transaction_date']));

//         foreach ($request->journal as $line) {
//             JournalEntry::create([
//                 'transaction_id' => $transaction->id,
//                 'coa_id' => $line['coa_id'],
//                 'debit' => $line['debit'] ?? 0,
//                 'credit' => $line['credit'] ?? 0,
//             ]);
//         }

//         return redirect()->route('transactions.index')->with('success', 'Transaction recorded.');
//     }

//     public function show($id)
//     {
//         $transaction = Transaction::with('journalEntries.account')->findOrFail($id);
//         return view('transactions.show', compact('transaction'));
//     }

//     public function destroy($id)
//     {
//         Transaction::destroy($id);
//         return redirect()->route('transactions.index')->with('success','Transaction deleted.');
//     }
// }

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\JournalEntry;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTransactionRequest;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // $transactions = Transaction::with('journalEntries.account')
        //     ->orderByDesc('transaction_date')
        //     ->paginate(15);

        // return view('transactions.index', compact('transactions'));

        // // Mengambil nilai 'search' dari request, defaultnya string kosong
        $search = $request->input('search', '');

        // Mengambil nilai 'per_page' dari request, defaultnya 10
        // dan memastikan nilainya adalah integer
        $perPage = (int) $request->input('per_page', 5);

        // Memulai query pada model Supplier
        // $query = Book::query();
        $query = Transaction::with('journalEntries.account')
            ->orderByDesc('transaction_date');

        // Jika ada keyword pencarian, tambahkan kondisi where
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->
                    where('reference', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('transaction_date', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('created_by', 'like', "%{$search}%")
                    ->orWhere('is_reversal', 'like', "%{$search}%")
                    ->orWhere('reversal_of_id', 'like', "%{$search}%");
            });
        }

        // Lakukan pagination pada hasil query
        // 'appends' digunakan agar parameter 'search' dan 'per_page' tetap ada di URL pagination
        $transactions = $query->paginate($perPage)->appends($request->except('page'));

        // Kembalikan view 'suppliers.supplier_list' dengan data suppliers, search, dan perPage
        return view('transactions.index', compact('transactions', 'search', 'perPage'));
    }

    public function create()
    {
        $accounts = ChartOfAccount::orderBy('code')->get();
        return view('transactions.create', compact('accounts'));
    }

    public function show($id)
    {
        $transaction = Transaction::with('journalEntries.account')->findOrFail($id);
        $totalDebit = $transaction->journalEntries->sum('debit');
        $totalCredit = $transaction->journalEntries->sum('credit');

        return view('transactions.show', compact('transaction', 'totalDebit', 'totalCredit'));
    }

    public function submit(StoreTransactionRequest $request)
    {
        $journal = $request->input('journal', []);

        $totalDebit = 0.0;
        $totalCredit = 0.0;
        foreach ($journal as $i => $line) {
            $debit = floatval($line['debit'] ?? 0);
            $credit = floatval($line['credit'] ?? 0);

            if ($debit > 0 && $credit > 0) {
                throw ValidationException::withMessages(["journal.{$i}" => 'Line cannot have both debit and credit.']);
            }
            if ($debit == 0 && $credit == 0) {
                throw ValidationException::withMessages(["journal.{$i}" => 'Line must have debit or credit value.']);
            }
            $totalDebit += $debit;
            $totalCredit += $credit;
        }

        if (abs($totalDebit - $totalCredit) > 0.001) {
            throw ValidationException::withMessages(['journal' => 'Total debit must equal total credit.']);
        }

        DB::transaction(function () use ($request, $journal) {
            $trx = Transaction::create([
                'reference' => $request->reference,
                'description' => $request->description,
                'transaction_date' => $request->transaction_date,
                'created_by' => auth()->id() ?? null,
                'status' => 'posted',
            ]);

            $rows = [];
            $now = now();
            foreach ($journal as $line) {
                $rows[] = [
                    'transaction_id' => $trx->id,
                    'coa_id' => $line['coa_id'],
                    'debit' => $line['debit'] ?? 0,
                    'credit' => $line['credit'] ?? 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            JournalEntry::insert($rows);
        });

        return redirect()->route('transactions.index')->with('success', 'Transaction recorded.');
    }

    /**
     * Reverse (create reversal transaction) instead of hard delete
     */
    public function reverse($id)
    {
        $orig = Transaction::with('journalEntries')->findOrFail($id);

        DB::transaction(function () use ($orig) {
            $now = now();
            $rev = Transaction::create([
                'reference' => $orig->reference . '-REV',
                'description' => 'Reversal of trx #' . $orig->id,
                'transaction_date' => now(),
                'created_by' => auth()->id() ?? null,
                'is_reversal' => true,
                'reversal_of_id' => $orig->id,
                'status' => 'posted',
            ]);

            $rows = [];
            foreach ($orig->journalEntries as $je) {
                $rows[] = [
                    'transaction_id' => $rev->id,
                    'coa_id' => $je->coa_id,
                    'debit' => $je->credit, // swap
                    'credit' => $je->debit,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            JournalEntry::insert($rows);

            $orig->update(['status' => 'reversed']);
        });

        return redirect()->route('transactions.index')->with('success', 'Transaction reversed.');
    }

    /**
     * Trial balance / ledger summary (simple)
     */
    public function trial_balance()
    {
        $coins = ChartOfAccount::all(); // will use account model
        $entries = \DB::table('journal_entries')
            ->select('coa_id', \DB::raw('SUM(debit) as total_debit'), \DB::raw('SUM(credit) as total_credit'))
            ->groupBy('coa_id')
            ->pluck('total_debit', 'coa_id')
            ->toArray();

        // simpler: build array of accounts with totals
        $accounts = ChartOfAccount::with([])->get()->map(function ($acc) {
            $totals = \DB::table('journal_entries')
                ->where('coa_id', $acc->id)
                ->selectRaw('COALESCE(SUM(debit),0) as debit, COALESCE(SUM(credit),0) as credit')
                ->first();
            return [
                'account' => $acc,
                'debit' => $totals->debit,
                'credit' => $totals->credit,
            ];
        });

        return view('transactions.trial_balance', compact('accounts'));
    }

    /**
     * If you still want to delete (not recommended), keep for admin only.
     */
    public function destroy($id)
    {
        $trx = Transaction::findOrFail($id);
        DB::transaction(function () use ($trx) {
            $trx->journalEntries()->delete();
            $trx->delete();
        });
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted.');
    }

}