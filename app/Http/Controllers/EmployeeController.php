<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        // $employees = Employee::latest()->get();
        // return view('employees.index', compact('employees'));

        // // Mengambil nilai 'search' dari request, defaultnya string kosong
        // $search = $request->input('search', '');

        // Mengambil nilai 'per_page' dari request, defaultnya 10
        // dan memastikan nilainya adalah integer
        $perPage = (int) $request->input('per_page', 5);

        // Memulai query pada model Supplier
        // $query = Book::query();
        $query = Employee::query();

        // Jika ada keyword pencarian, tambahkan kondisi where
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->
                    where('name', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%")
                    ->orWhere('base_salary', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Lakukan pagination pada hasil query
        // 'appends' digunakan agar parameter 'search' dan 'per_page' tetap ada di URL pagination
        $employees = $query->paginate($perPage)->appends($request->except('page'));

        // Kembalikan view 'suppliers.supplier_list' dengan data suppliers, search, dan perPage
        return view('employees.index', compact('employees', 'search', 'perPage'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'base_salary' => 'required|numeric',
            'email' => 'required|email|unique:employees,email'
        ]);

        Employee::create($request->all());
        return redirect()->route('employees.index')->with('success', 'Employee added!');
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'base_salary' => 'required|numeric',
            'email' => 'required|email|unique:employees,email,'.$employee->id
        ]);

        $employee->update($request->all());
        return redirect()->route('employees.index')->with('success', 'Employee updated!');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted!');
    }
}
