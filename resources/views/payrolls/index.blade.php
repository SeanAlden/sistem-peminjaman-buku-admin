{{-- @extends('layouts.app')

@section('content')
<div class="min-h-screen px-4 py-8 bg-gray-100">
    <div class="max-w-6xl p-6 mx-auto bg-white shadow-lg rounded-2xl">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Payroll List</h2>
            <a href="{{ route('payrolls.create') }}" 
               class="px-4 py-2 text-white transition duration-200 bg-indigo-600 rounded-lg shadow hover:bg-indigo-700">
               + Add Payroll
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full overflow-hidden border-collapse rounded-lg">
                <thead>
                    <tr class="text-white bg-indigo-600">
                        <th class="px-4 py-3 text-sm font-semibold text-left">ID</th>
                        <th class="px-4 py-3 text-sm font-semibold text-left">Employee</th>
                        <th class="px-4 py-3 text-sm font-semibold text-left">Basic Salary</th>
                        <th class="px-4 py-3 text-sm font-semibold text-left">Bonus</th>
                        <th class="px-4 py-3 text-sm font-semibold text-left">Deduction</th>
                        <th class="px-4 py-3 text-sm font-semibold text-left">Net Salary</th>
                        <th class="px-4 py-3 text-sm font-semibold text-left">Date</th>
                        <th class="px-4 py-3 text-sm font-semibold text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($payrolls as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $p->id }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $p->employee->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ number_format($p->basic_salary,0,',','.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ number_format($p->bonus ?? 0,0,',','.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ number_format($p->deduction ?? 0,0,',','.') }}</td>
                        <td class="px-4 py-3 font-semibold text-green-600">{{ number_format($p->net_salary,0,',','.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $p->payment_date }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('payrolls.show',$p->id) }}" 
                                   class="px-3 py-1 text-xs font-medium text-white transition bg-blue-500 rounded hover:bg-blue-600">
                                   Detail
                                </a>
                                <a href="{{ route('payrolls.edit',$p->id) }}" 
                                   class="px-3 py-1 text-xs font-medium text-white transition bg-yellow-500 rounded hover:bg-yellow-600">
                                   Edit
                                </a>
                                <form action="{{ route('payrolls.destroy',$p->id) }}" method="POST" onsubmit="return confirm('Delete payroll?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1 text-xs font-medium text-white transition bg-red-500 rounded hover:bg-red-600">
                                        Del
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="min-h-screen px-4 py-8 transition-colors duration-300 bg-gray-100 dark:bg-gray-900">
    <div class="max-w-6xl p-6 mx-auto transition-colors duration-300 bg-white shadow-lg dark:bg-gray-800 rounded-2xl">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Payroll List</h2>
            <a href="{{ route('payrolls.create') }}" 
               class="px-4 py-2 text-white transition duration-200 bg-indigo-600 rounded-lg shadow hover:bg-indigo-700">
               + Add Payroll
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full overflow-hidden border-collapse rounded-lg">
                <thead>
                    <tr class="text-white bg-indigo-600">
                        <th class="px-4 py-3 text-sm font-semibold text-left">ID</th>
                        <th class="px-4 py-3 text-sm font-semibold text-left">Employee</th>
                        <th class="px-4 py-3 text-sm font-semibold text-left">Basic Salary</th>
                        <th class="px-4 py-3 text-sm font-semibold text-left">Bonus</th>
                        <th class="px-4 py-3 text-sm font-semibold text-left">Deduction</th>
                        <th class="px-4 py-3 text-sm font-semibold text-left">Net Salary</th>
                        <th class="px-4 py-3 text-sm font-semibold text-left">Date</th>
                        <th class="px-4 py-3 text-sm font-semibold text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($payrolls as $p)
                    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $p->id }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $p->employee->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ number_format($p->basic_salary,0,',','.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ number_format($p->bonus ?? 0,0,',','.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ number_format($p->deduction ?? 0,0,',','.') }}</td>
                        <td class="px-4 py-3 font-semibold text-green-600 dark:text-green-400">{{ number_format($p->net_salary,0,',','.') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $p->payment_date }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('payrolls.show',$p->id) }}" 
                                   class="px-3 py-1 text-xs font-medium text-white transition bg-blue-500 rounded hover:bg-blue-600">
                                   Detail
                                </a>
                                <a href="{{ route('payrolls.edit',$p->id) }}" 
                                   class="px-3 py-1 text-xs font-medium text-white transition bg-yellow-500 rounded hover:bg-yellow-600">
                                   Edit
                                </a>
                                <form action="{{ route('payrolls.destroy',$p->id) }}" method="POST" onsubmit="return confirm('Delete payroll?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1 text-xs font-medium text-white transition bg-red-500 rounded hover:bg-red-600">
                                        Del
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
