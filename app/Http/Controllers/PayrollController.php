<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('employee')->latest()->get();
        return view('payrolls.index', compact('payrolls'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('payrolls.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'=>'required|exists:employees,id',
            'basic_salary'=>'required|numeric',
            'bonus'=>'nullable|numeric',
            'deduction'=>'nullable|numeric',
            'payment_date'=>'required|date'
        ]);

        $net = $request->basic_salary + ($request->bonus ?? 0) - ($request->deduction ?? 0);

        Payroll::create([
            'employee_id'=>$request->employee_id,
            'basic_salary'=>$request->basic_salary,
            'bonus'=>$request->bonus,
            'deduction'=>$request->deduction,
            'net_salary'=>$net,
            'payment_date'=>$request->payment_date
        ]);

        return redirect()->route('payrolls.index')->with('success','Payroll added!');
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
        return view('payrolls.edit', compact('payroll','employees'));
    }

    public function update(Request $request, $id)
    {
        $payroll = Payroll::findOrFail($id);

        $request->validate([
            'employee_id'=>'required|exists:employees,id',
            'basic_salary'=>'required|numeric',
            'bonus'=>'nullable|numeric',
            'deduction'=>'nullable|numeric',
            'payment_date'=>'required|date'
        ]);

        $net = $request->basic_salary + ($request->bonus ?? 0) - ($request->deduction ?? 0);

        $payroll->update([
            'employee_id'=>$request->employee_id,
            'basic_salary'=>$request->basic_salary,
            'bonus'=>$request->bonus,
            'deduction'=>$request->deduction,
            'net_salary'=>$net,
            'payment_date'=>$request->payment_date
        ]);

        return redirect()->route('payrolls.index')->with('success','Payroll updated!');
    }

    public function destroy($id)
    {
        $payroll = Payroll::findOrFail($id);
        $payroll->delete();
        return redirect()->route('payrolls.index')->with('success','Payroll deleted!');
    }
}
