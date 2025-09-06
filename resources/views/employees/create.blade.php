{{-- @extends('layouts.app')

@section('content')
<h2>Add Employee</h2>
<form method="POST" action="{{ route('employees.store') }}">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Position</label>
        <input type="text" name="position" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Base Salary</label>
        <input type="number" name="base_salary" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <button class="btn btn-success">Save</button>
    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-lg p-8 bg-white shadow-lg rounded-2xl">
        <h2 class="mb-6 text-2xl font-bold text-center text-gray-800">Add Employee</h2>
        
        <form method="POST" action="{{ route('employees.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Name</label>
                <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none" required>
            </div>
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Position</label>
                <input type="text" name="position" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none" required>
            </div>
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Base Salary</label>
                <input type="number" name="base_salary" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none" required>
            </div>
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none" required>
            </div>

            <div class="flex items-center justify-between pt-4">
                <button class="px-5 py-2 text-white transition duration-200 bg-indigo-600 rounded-lg shadow hover:bg-indigo-700">Save</button>
                <a href="{{ route('employees.index') }}" class="px-5 py-2 text-gray-700 transition duration-200 bg-gray-200 rounded-lg shadow hover:bg-gray-300">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
