<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Menampilkan semua data student 
    public function Index()
    {
        $students = Student::all();
        return view('student', compact('students'));
    }

    // Menuju ke halaman tambah data student
    public function create()
    {
        return view('student_create');
    }

    // Menyimpan data student
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'major' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:12',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')->with('success', 'Student Created Successfully');
    }

    // Menampilkan detail student
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('student_show', compact('student'));
    }

    // Menuju ke halaman edit data student
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('student_edit', compact('student'));
    }

    // Memperbarui data student
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'major' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:12',
        ]);

        $student = Student::findOrFail($id);
        $student->update($request->all());

        return redirect()->route('students.index')->with('success', 'Student Updated Successfully');
    }

    // Menghapus data student
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student Deleted Successfully');
    }

}
