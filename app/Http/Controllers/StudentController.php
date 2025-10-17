<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Menampilkan semua data student dengan pagination dan search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $perPage = (int) $request->input('per_page', 5);

        $query = Student::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('major', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $students = $query->paginate($perPage)->appends($request->except('page'));

        return view('students.student', compact('students', 'search', 'perPage'));
    }

    public function create()
    {
        return view('students.student_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'major' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:12',
            'description' => 'nullable|string',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')->with('success', 'Student Created Successfully');
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('students.student_show', compact('student'));
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('students.student_edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'major' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:12',
            'description' => 'nullable|string',
        ]);

        $student = Student::findOrFail($id);
        $student->update($request->all());

        return redirect()->route('students.index')->with('success', 'Student Updated Successfully');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student Deleted Successfully');
    }
}
