{{-- @extends('layouts.app')

@section('content')
<h2 class="mb-3">Employee List</h2>
<a href="{{ route('employees.create') }}" class="mb-3 btn btn-primary">+ Add Employee</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th><th>Name</th><th>Position</th><th>Base Salary</th><th>Email</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employees as $emp)
        <tr>
            <td>{{ $emp->id }}</td>
            <td>{{ $emp->name }}</td>
            <td>{{ $emp->position }}</td>
            <td>{{ number_format($emp->base_salary,0,',','.') }}</td>
            <td>{{ $emp->email }}</td>
            <td>
                <a href="{{ route('employees.show',$emp->id) }}" class="btn btn-info btn-sm">Detail</a>
                <a href="{{ route('employees.edit',$emp->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('employees.destroy',$emp->id) }}" method="POST" style="display:inline-block">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Delete employee?')" class="btn btn-danger btn-sm">Del</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="container px-6 py-8 mx-auto">
    <h2 class="mb-6 text-3xl font-bold text-gray-800 dark:text-gray-200">Employee List</h2>

    <a href="{{ route('employees.create') }}" 
       class="inline-block px-5 py-2 mb-6 text-white transition bg-blue-600 rounded-lg shadow hover:bg-blue-700">
        + Add Employee
    </a>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-300 dark:bg-gray-600">
                <tr>
                    <th class="px-6 py-3 text-black dark:text-white">ID</th>
                    <th class="px-6 py-3 text-black dark:text-white">Name</th>
                    <th class="px-6 py-3 text-black dark:text-white">Position</th>
                    <th class="px-6 py-3 text-black dark:text-white">Base Salary</th>
                    <th class="px-6 py-3 text-black dark:text-white">Email</th>
                    <th class="px-6 py-3 text-center text-black dark:text-white">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-gray-200 divide-gray-200 dividbg-e-y dark:bg-gray-500 dark:divide-gray-800">
                @foreach($employees as $emp)
                <tr class="hover:bg-gray-50 hover:dark:bg-gray-600">
                    <td class="px-6 py-4 text-gray-800 dark:text-white">{{ $emp->id }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-white">{{ $emp->name }}</td>
                    <td class="px-6 py-4 text-gray-800 dark:text-white">{{ $emp->position }}</td>
                    <td class="px-6 py-4 text-gray-800 dark:text-white">Rp {{ number_format($emp->base_salary,0,',','.') }}</td>
                    <td class="px-6 py-4 text-gray-800 dark:text-white">{{ $emp->email }}</td>
                    <td class="px-6 py-4 space-x-2 text-center">
                        <a href="{{ route('employees.show',$emp->id) }}" 
                           class="inline-block px-3 py-1 text-white transition bg-blue-500 rounded hover:bg-blue-600">
                            Detail
                        </a>
                        <a href="{{ route('employees.edit',$emp->id) }}" 
                           class="inline-block px-3 py-1 text-white transition bg-yellow-500 rounded hover:bg-yellow-600">
                            Edit
                        </a>
                        <form action="{{ route('employees.destroy',$emp->id) }}" method="POST" class="inline-block">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete employee?')" 
                                    class="px-3 py-1 text-white transition bg-red-500 rounded hover:bg-red-600">
                                Del
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
