{{-- @extends('layouts.app')

@section('content')
<h2>Payroll Detail</h2>
<ul class="mb-3 list-group">
    <li class="list-group-item"><b>ID:</b> {{ $payroll->id }}</li>
    <li class="list-group-item"><b>Employee:</b> {{ $payroll->employee->name }}</li>
    <li class="list-group-item"><b>Basic Salary:</b> {{ number_format($payroll->basic_salary,0,',','.') }}</li>
    <li class="list-group-item"><b>Bonus:</b> {{ number_format($payroll->bonus ?? 0,0,',','.') }}</li>
    <li class="list-group-item"><b>Deduction:</b> {{ number_format($payroll->deduction ?? 0,0,',','.') }}</li>
    <li class="list-group-item"><b>Net Salary:</b> <b>{{ number_format($payroll->net_salary,0,',','.') }}</b></li>
    <li class="list-group-item"><b>Payment Date:</b> {{ $payroll->payment_date }}</li>
</ul>
<a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Back</a>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-2xl p-8 bg-white shadow-lg rounded-2xl">
        <h2 class="mb-6 text-2xl font-bold text-center text-gray-800">Payroll Detail</h2>

        <ul class="border divide-y divide-gray-200 rounded-lg">
            <li class="px-4 py-3">
                <span class="font-semibold text-gray-700">ID:</span>
                <span class="ml-2 text-gray-900">{{ $payroll->id }}</span>
            </li>
            <li class="px-4 py-3">
                <span class="font-semibold text-gray-700">Employee:</span>
                <span class="ml-2 text-gray-900">{{ $payroll->employee->name }}</span>
            </li>
            <li class="px-4 py-3">
                <span class="font-semibold text-gray-700">Basic Salary:</span>
                <span class="ml-2 text-gray-900">{{ number_format($payroll->basic_salary,0,',','.') }}</span>
            </li>
            <li class="px-4 py-3">
                <span class="font-semibold text-gray-700">Bonus:</span>
                <span class="ml-2 text-gray-900">{{ number_format($payroll->bonus ?? 0,0,',','.') }}</span>
            </li>
            <li class="px-4 py-3">
                <span class="font-semibold text-gray-700">Deduction:</span>
                <span class="ml-2 text-gray-900">{{ number_format($payroll->deduction ?? 0,0,',','.') }}</span>
            </li>
            <li class="px-4 py-3">
                <span class="font-semibold text-gray-700">Net Salary:</span>
                <span class="ml-2 font-bold text-green-600">{{ number_format($payroll->net_salary,0,',','.') }}</span>
            </li>
            <li class="px-4 py-3">
                <span class="font-semibold text-gray-700">Payment Date:</span>
                <span class="ml-2 text-gray-900">{{ $payroll->payment_date }}</span>
            </li>
        </ul>

        <div class="mt-6 text-center">
            <a href="{{ route('payrolls.index') }}" 
               class="px-5 py-2 text-gray-700 transition duration-200 bg-gray-200 rounded-lg shadow hover:bg-gray-300">
                Back
            </a>
        </div>
    </div>
</div>
@endsection
