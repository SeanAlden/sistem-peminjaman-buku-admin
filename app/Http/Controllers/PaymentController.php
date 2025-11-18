<?php

// namespace App\Http\Controllers;

// use App\Models\Payment;
// use App\Models\Employee;
// use App\Models\Supplier;
// use Illuminate\Http\Request;

// class PaymentController extends Controller
// {
//     public function index()
//     {
//         $payments = Payment::with(['employee','supplier'])->get();
//         return view('payments.index', compact('payments'));
//     }

//     public function create()
//     {
//         $employees = Employee::all();
//         $suppliers = Supplier::all();
//         return view('payments.create', compact('employees','suppliers'));
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'amount' => 'required|numeric',
//             'payment_date' => 'required|date',
//             'method' => 'required|in:cash,transfer,other',
//         ]);

//         Payment::create($request->all());

//         return redirect()->route('payments.index')->with('success','Payment recorded.');
//     }

//     public function destroy($id)
//     {
//         Payment::destroy($id);
//         return redirect()->route('payments.index')->with('success','Payment deleted.');
//     }
// }

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Employee;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        // $payments = Payment::with(['employee','supplier'])
        //                    ->orderBy('payment_date','desc')
        //                    ->get();

        // return view('payments.index', compact('payments'));

        $search = $request->input('search', '');

        $perPage = (int) $request->input('per_page', 5);

        $query = Payment::with(['employee', 'supplier'])
            ->orderBy('payment_date', 'desc');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q
                    ->where('amount', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%")
                    ->orWhere('method', 'like', "%{$search}%")
                    ->orWhere('payment_date', 'like', "%{$search}%")
                    ->orWhereHas('employee', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('supplier', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $payments = $query->paginate($perPage)->appends($request->except('page'));

        $employees = Employee::all();
        $suppliers = Supplier::all();

        return view('payments.index', compact('payments', 'employees', 'suppliers', 'search', 'perPage'));
    }

    public function create()
    {
        $employees = Employee::all();
        $suppliers = Supplier::all();
        return view('payments.create', compact('employees', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'nullable|exists:employees,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'method' => 'required|in:cash,transfer,other',
            'notes' => 'nullable|string'
        ]);

        if (!$request->employee_id && !$request->supplier_id) {
            return back()->withErrors('Either Employee or Supplier must be selected.')
                ->withInput();
        }

        if ($request->employee_id && $request->supplier_id) {
            return back()->withErrors('Select only Employee OR Supplier, not both.')
                ->withInput();
        }

        Payment::create($request->only([
            'employee_id',
            'supplier_id',
            'amount',
            'payment_date',
            'method',
            'notes'
        ]));

        return redirect()->route('payments.index')->with('success', 'Payment recorded.');
    }

    public function edit(Payment $payment)
    {
        $employees = Employee::all();
        $suppliers = Supplier::all();
        return view('payments.edit', compact('payment', 'employees', 'suppliers'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'employee_id' => 'nullable|exists:employees,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'method' => 'required|in:cash,transfer,other',
            'notes' => 'nullable|string'
        ]);

        if (!$request->employee_id && !$request->supplier_id) {
            return back()->withErrors('Either Employee or Supplier must be selected.')
                ->withInput();
        }

        if ($request->employee_id && $request->supplier_id) {
            return back()->withErrors('Select only Employee OR Supplier, not both.')
                ->withInput();
        }

        $payment->update($request->only([
            'employee_id',
            'supplier_id',
            'amount',
            'payment_date',
            'method',
            'notes'
        ]));

        return redirect()->route('payments.index')->with('success', 'Payment updated.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted.');
    }
}

