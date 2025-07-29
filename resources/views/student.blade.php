@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6">
    <h2 class="mb-4 text-2xl font-bold text-gray-800">Student List</h2>

    @if(session('success'))
        <div class="px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('students.create') }}"
           class="inline-block px-4 py-2 font-semibold text-white bg-blue-600 rounded shadow hover:bg-blue-700">
            + Add Student
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr class="text-sm leading-normal text-gray-700 uppercase bg-gray-200">
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Major</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Phone</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                @foreach($students as $student)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-3">{{ $student->name }}</td>
                    <td class="px-6 py-3">{{ $student->major }}</td>
                    <td class="px-6 py-3">{{ $student->email }}</td>
                    <td class="px-6 py-3">{{ $student->phone }}</td>
                    <td class="flex px-6 py-3 space-x-2">
                        <a href="{{ route('students.show', $student->id) }}"
                           class="px-3 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">View</a>
                        <a href="{{ route('students.edit', $student->id) }}"
                           class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">Edit</a>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                              onsubmit="return confirm('Delete this student?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
