@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-2xl p-8 bg-white shadow-lg rounded-2xl">
        <h2 class="mb-6 text-2xl font-bold text-center text-gray-800">Add Payroll</h2>
        
        <form method="POST" action="{{ route('payrolls.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Employee</label>
                <select name="employee_id" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                    <option value="">-- Select Employee --</option>
                    @foreach($employees as $e)
                        <option value="{{ $e->id }}">{{ $e->name }} - {{ $e->position }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Basic Salary</label>
                <input type="number" name="basic_salary" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Bonus</label>
                <input type="number" name="bonus"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Deduction</label>
                <input type="number" name="deduction"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">Payment Date</label>
                <input type="date" name="payment_date" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <div class="flex items-center justify-between pt-4">
                <button type="submit" 
                        class="px-5 py-2 text-white transition duration-200 bg-indigo-600 rounded-lg shadow hover:bg-indigo-700">
                    Save
                </button>
                <a href="{{ route('payrolls.index') }}" 
                   class="px-5 py-2 text-gray-700 transition duration-200 bg-gray-200 rounded-lg shadow hover:bg-gray-300">
                    Back
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
