<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Menampilkan semua data student 
    // public function Index()
    // {
    //     $students = Student::all();
    //     return view('student', compact('students'));
    // }

    // public function index(Request $request)
    // {
    //     $search = $request->input('search');
    //     $perPage = $request->input('per_page', 10);

    //     $query = Student::query();

    //     if ($search) {
    //         $query->where('name', 'like', "%$search%")
    //             ->orWhere('major', 'like', "%$search%")
    //             ->orWhere('email', 'like', "%$search%")
    //             ->orWhere('phone', 'like', "%$search%");
    //     }

    //     $students = $query->paginate($perPage);

    //     return view('student', compact('students'));
    // }

    /**
     * Menampilkan semua data student dengan pagination dan search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Mengambil nilai 'search' dari request, defaultnya string kosong
        $search = $request->input('search', '');

        // Mengambil nilai 'per_page' dari request, defaultnya 10
        // dan memastikan nilainya adalah integer
        $perPage = (int) $request->input('per_page', 5);

        // Memulai query pada model Student
        $query = Student::query();

        // Jika ada keyword pencarian, tambahkan kondisi where
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('major', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Lakukan pagination pada hasil query
        // 'appends' digunakan agar parameter 'search' dan 'per_page' tetap ada di URL pagination
        $students = $query->paginate($perPage)->appends($request->except('page'));

        // Kembalikan view 'student' dengan data students, search, dan perPage
        return view('student', compact('students', 'search', 'perPage'));
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
            'description' => 'nullable|string',
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
            'description' => 'nullable|string',
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
