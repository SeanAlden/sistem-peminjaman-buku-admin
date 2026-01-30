<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        // $payrolls = Payroll::with('employee')->latest()->get();
        // return view('payrolls.index', compact('payrolls'));

        // // Mengambil nilai 'search' dari request, defaultnya string kosong
        $search = $request->input('search', '');

        // Mengambil nilai 'per_page' dari request, defaultnya 10
        // dan memastikan nilainya adalah integer
        $perPage = (int) $request->input('per_page', 5);

        // Memulai query pada model Supplier
        // $query = Book::query();
        $query = Payroll::query();

        // Jika ada keyword pencarian, tambahkan kondisi where
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('basic_salary', 'like', "%{$search}%")
                    ->orWhere('bonus', 'like', "%{$search}%")
                    ->orWhere('deduction', 'like', "%{$search}%")
                    ->orWhere('net_salary', 'like', "%{$search}%")
                    ->orWhere('payment_date', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('employee', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Lakukan pagination pada hasil query
        // 'appends' digunakan agar parameter 'search' dan 'per_page' tetap ada di URL pagination
        $payrolls = $query->paginate($perPage)->appends($request->except('page'));

        // Kembalikan view 'suppliers.supplier_list' dengan data suppliers, search, dan perPage
        return view('payrolls.index', compact('payrolls', 'search', 'perPage'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('payrolls.create', compact('employees'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'employee_id'=>'required|exists:employees,id',
    //         'basic_salary'=>'required|numeric',
    //         'bonus'=>'nullable|numeric',
    //         'deduction'=>'nullable|numeric',
    //         'payment_date'=>'required|date'
    //     ]);

    //     $net = $request->basic_salary + ($request->bonus ?? 0) - ($request->deduction ?? 0);

    //     Payroll::create([
    //         'employee_id'=>$request->employee_id,
    //         'basic_salary'=>$request->basic_salary,
    //         'bonus'=>$request->bonus,
    //         'deduction'=>$request->deduction,
    //         'net_salary'=>$net,
    //         'payment_date'=>$request->payment_date
    //     ]);

    //     return redirect()->route('payrolls.index')->with('success','Payroll added!');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'bonus' => 'nullable|numeric',
            'deduction' => 'nullable|numeric',
            'payment_date' => 'required|date',
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        $basicSalary = $employee->base_salary;
        $bonus = $request->bonus ?? 0;
        $deduction = $request->deduction ?? 0;

        Payroll::create([
            'employee_id' => $employee->id,
            'basic_salary' => $basicSalary,
            'bonus' => $bonus,
            'deduction' => $deduction,
            'net_salary' => $basicSalary + $bonus - $deduction,
            'payment_date' => $request->payment_date,
        ]);

        return redirect()->route('payrolls.index')
            ->with('success', 'Payroll berhasil ditambahkan.');
    }

    public function show($id)
    {
        $payroll = Payroll::with('employee')->findOrFail($id);
        return view('payrolls.show', compact('payroll'));
    }

    public function edit($id)
    {
        $payroll = Payroll::findOrFail($id);
        $employees = Employee::all();
        return view('payrolls.edit', compact('payroll', 'employees'));
    }

    // public function update(Request $request, $id)
    // {
    //     $payroll = Payroll::findOrFail($id);

    //     $request->validate([
    //         'employee_id'=>'required|exists:employees,id',
    //         'basic_salary'=>'required|numeric',
    //         'bonus'=>'nullable|numeric',
    //         'deduction'=>'nullable|numeric',
    //         'payment_date'=>'required|date'
    //     ]);

    //     $net = $request->basic_salary + ($request->bonus ?? 0) - ($request->deduction ?? 0);

    //     $payroll->update([
    //         'employee_id'=>$request->employee_id,
    //         'basic_salary'=>$request->basic_salary,
    //         'bonus'=>$request->bonus,
    //         'deduction'=>$request->deduction,
    //         'net_salary'=>$net,
    //         'payment_date'=>$request->payment_date
    //     ]);

    //     return redirect()->route('payrolls.index')->with('success','Payroll updated!');
    // }

    public function update(Request $request, Payroll $payroll)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'bonus' => 'nullable|numeric',
            'deduction' => 'nullable|numeric',
            'payment_date' => 'required|date',
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        $basicSalary = $employee->base_salary;
        $bonus = $request->bonus ?? 0;
        $deduction = $request->deduction ?? 0;

        $payroll->update([
            'employee_id' => $employee->id,
            'basic_salary' => $basicSalary,
            'bonus' => $bonus,
            'deduction' => $deduction,
            'net_salary' => $basicSalary + $bonus - $deduction,
            'payment_date' => $request->payment_date,
        ]);

        return redirect()->route('payrolls.index')
            ->with('success', 'Payroll berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $payroll = Payroll::findOrFail($id);
        $payroll->delete();
        return redirect()->route('payrolls.index')->with('success', 'Payroll deleted!');
    }

    public function markPaid($id)
    {
        $payroll = Payroll::findOrFail($id);

        if ($payroll->status === 'paid') {
            return back()->with('error', 'Payroll sudah paid.');
        }

        $payroll->update([
            'status' => 'paid'
        ]);

        return back()->with('success', 'Payroll berhasil ditandai sebagai PAID.');
    }

    public function markDraft($id)
    {
        $payroll = Payroll::findOrFail($id);

        if ($payroll->status === 'draft') {
            return back()->with('error', 'Payroll sudah draft.');
        }

        $payroll->update([
            'status' => 'draft'
        ]);

        return back()->with('success', 'Status payroll dikembalikan ke DRAFT.');
    }
}
