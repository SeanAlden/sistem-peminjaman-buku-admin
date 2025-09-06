{{-- @extends('layouts.app')

@section('content')
<h2>Edit Employee</h2>
<form method="POST" action="{{ route('employees.update',$employee->id) }}">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="{{ $employee->name }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Position</label>
        <input type="text" name="position" value="{{ $employee->position }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Base Salary</label>
        <input type="number" name="base_salary" value="{{ $employee->base_salary }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ $employee->email }}" class="form-control" required>
    </div>
    <button class="btn btn-primary">Update</button>
    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-2xl p-8 bg-white shadow-lg rounded-2xl">
        <h2 class="mb-6 text-2xl font-bold text-center text-gray-800">Edit Employee</h2>

        <form method="POST" action="{{ route('employees.update',$employee->id) }}" class="space-y-5">
            @csrf 
            @method('PUT')

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Name</label>
                <input type="text" name="name" value="{{ $employee->name }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Position</label>
                <input type="text" name="position" value="{{ $employee->position }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Base Salary</label>
                <input type="number" name="base_salary" value="{{ $employee->base_salary }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Email</label>
                <input type="email" name="email" value="{{ $employee->email }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <div class="flex items-center justify-between pt-4">
                <button type="submit" 
                        class="px-5 py-2 text-white transition duration-200 bg-indigo-600 rounded-lg shadow hover:bg-indigo-700">
                    Update
                </button>
                <a href="{{ route('employees.index') }}" 
                   class="px-5 py-2 text-gray-700 transition duration-200 bg-gray-200 rounded-lg shadow hover:bg-gray-300">
                    Back
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
