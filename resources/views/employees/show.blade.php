{{-- @extends('layouts.app')

@section('content')
<h2>Employee Detail</h2>
<ul class="mb-3 list-group">
    <li class="list-group-item"><b>ID:</b> {{ $employee->id }}</li>
    <li class="list-group-item"><b>Name:</b> {{ $employee->name }}</li>
    <li class="list-group-item"><b>Position:</b> {{ $employee->position }}</li>
    <li class="list-group-item"><b>Base Salary:</b> {{ number_format($employee->base_salary,0,',','.') }}</li>
    <li class="list-group-item"><b>Email:</b> {{ $employee->email }}</li>
</ul>
<a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="max-w-3xl p-6 mx-auto bg-white rounded-lg shadow-lg">
    <h2 class="pb-3 mb-6 text-2xl font-bold text-gray-800 border-b">Employee Detail</h2>

    <div class="space-y-4">
        <div class="flex justify-between p-4 rounded-lg bg-gray-50">
            <span class="font-semibold text-gray-600">ID:</span>
            <span class="text-gray-800">{{ $employee->id }}</span>
        </div>
        <div class="flex justify-between p-4 bg-white border rounded-lg">
            <span class="font-semibold text-gray-600">Name:</span>
            <span class="text-gray-800">{{ $employee->name }}</span>
        </div>
        <div class="flex justify-between p-4 rounded-lg bg-gray-50">
            <span class="font-semibold text-gray-600">Position:</span>
            <span class="text-gray-800">{{ $employee->position }}</span>
        </div>
        <div class="flex justify-between p-4 bg-white border rounded-lg">
            <span class="font-semibold text-gray-600">Base Salary:</span>
            <span class="font-semibold text-green-600">Rp {{ number_format($employee->base_salary,0,',','.') }}</span>
        </div>
        <div class="flex justify-between p-4 rounded-lg bg-gray-50">
            <span class="font-semibold text-gray-600">Email:</span>
            <span class="text-gray-800">{{ $employee->email }}</span>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('employees.index') }}" 
           class="px-5 py-2 text-white transition bg-gray-600 rounded-lg shadow hover:bg-gray-700">
           ← Back
        </a>
    </div>
</div>
@endsection
