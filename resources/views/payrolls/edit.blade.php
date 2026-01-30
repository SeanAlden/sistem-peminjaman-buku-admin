{{-- @extends('layouts.app')

@section('content')
<h2>Edit Payroll</h2>
<form method="POST" action="{{ route('payrolls.update',$payroll->id) }}">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Employee</label>
        <select name="employee_id" class="form-control" required>
            @foreach ($employees as $e)
                <option value="{{ $e->id }}" {{ $payroll->employee_id == $e->id ? 'selected' : '' }}>
                    {{ $e->name }} - {{ $e->position }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Basic Salary</label>
        <input type="number" name="basic_salary" value="{{ $payroll->basic_salary }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Bonus</label>
        <input type="number" name="bonus" value="{{ $payroll->bonus }}" class="form-control">
    </div>
    <div class="mb-3">
        <label>Deduction</label>
        <input type="number" name="deduction" value="{{ $payroll->deduction }}" class="form-control">
    </div>
    <div class="mb-3">
        <label>Payment Date</label>
        <input type="date" name="payment_date" value="{{ $payroll->payment_date }}" class="form-control" required>
    </div>
    <button class="btn btn-primary">Update</button>
    <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
<div class="flex justify-center items-center bg-gray-100 min-h-screen">
    <div class="bg-white shadow-lg p-8 rounded-2xl w-full max-w-2xl">
        <h2 class="mb-6 font-bold text-gray-800 text-2xl text-center">Edit Payroll</h2>

        <form method="POST" action="{{ route('payrolls.update',$payroll->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-2 font-semibold text-gray-700 text-sm">Employee</label>
                <select name="employee_id" required
                        class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full">
                    @foreach ($employees as $e)
                        <option value="{{ $e->id }}" {{ $payroll->employee_id == $e->id ? 'selected' : '' }}>
                            {{ $e->name }} - {{ $e->position }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700 text-sm">Basic Salary</label>
                <input type="number" name="basic_salary" value="{{ $payroll->basic_salary }}" required
                       class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full">
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700 text-sm">Bonus</label>
                <input type="number" name="bonus" value="{{ $payroll->bonus }}"
                       class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full">
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700 text-sm">Deduction</label>
                <input type="number" name="deduction" value="{{ $payroll->deduction }}"
                       class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full">
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700 text-sm">Payment Date</label>
                <input type="date" name="payment_date" value="{{ $payroll->payment_date }}" required
                       class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full">
            </div>

            <div class="flex justify-between items-center pt-4">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 shadow px-5 py-2 rounded-lg text-white transition duration-200">
                    Update
                </button>
                <a href="{{ route('payrolls.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 shadow px-5 py-2 rounded-lg text-gray-700 transition duration-200">
                    Back
                </a>
            </div>
        </form>
    </div>
</div>
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center bg-gray-100 dark:bg-gray-900 min-h-screen transition-colors duration-300">
        <div class="bg-white dark:bg-gray-800 shadow-lg p-8 rounded-2xl w-full max-w-2xl transition-colors duration-300">
            <h2 class="mb-6 font-bold text-gray-800 dark:text-white text-3xl text-center">
                Edit Payroll
            </h2>

            <form method="POST" action="{{ route('payrolls.update', $payroll->id) }}" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Employee --}}
                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200 text-sm">
                        Employee
                    </label>
                    {{--
                    <select name="employee_id" required
                    class="bg-gray-50 dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full text-gray-900 dark:text-gray-100 transition">
                    @foreach ($employees as $e)
                    <option value="{{ $e->id }}" {{ $payroll->employee_id == $e->id ? 'selected' : '' }}
                        class="dark:bg-gray-700">
                        {{ $e->name }} - {{ $e->position }}
                        </option>
                        @endforeach
                        </select>
                        --}}

                    <select name="employee_id" id="employeeSelect" required
                        class="bg-gray-50 dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full text-gray-900 dark:text-gray-100 transition">

                        @foreach ($employees as $e)
                            <option value="{{ $e->id }}" data-salary="{{ $e->base_salary }}"
                                {{ $payroll->employee_id == $e->id ? 'selected' : '' }}>
                                {{ $e->name }} - {{ $e->position }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Basic Salary --}}
                {{--

                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200 text-sm">
                        Basic Salary
                        </label>
                        <input type="number" name="basic_salary" value="{{ $payroll->basic_salary }}" required
                        class="bg-gray-50 dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full text-gray-900 dark:text-gray-100 transition">
                        </div>
                        --}}

                {{-- Basic Salary --}}
                {{--
                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200 text-sm">
                        Basic Salary
                        </label>
                        <div
                        class="bg-gray-100 dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg w-full dark:text-gray-100">
                        Rp {{ number_format($payroll->employee->base_salary, 0, ',', '.') }}
                        </div>
                        </div>
                        --}}

                {{-- Basic Salary --}}
                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200 text-sm">
                        Basic Salary
                    </label>
                    <div id="basicSalaryText"
                        class="bg-gray-100 dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg w-full dark:text-gray-100">
                        Rp {{ number_format($payroll->employee->base_salary, 0, ',', '.') }}
                    </div>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200 text-sm">
                        Net Salary (Preview)
                    </label>
                    <div id="netSalaryPreview"
                        class="bg-green-100 dark:bg-green-900 px-4 py-2 border border-green-300 dark:border-green-700 rounded-lg w-full dark:text-green-200">
                        -
                    </div>
                </div>

                {{-- Bonus --}}
                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200 text-sm">
                        Bonus
                    </label>
                    <input type="number" name="bonus" value="{{ $payroll->bonus }}"
                        class="bg-gray-50 dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full text-gray-900 dark:text-gray-100 transition">
                </div>

                {{-- Deduction --}}
                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200 text-sm">
                        Deduction
                    </label>
                    <input type="number" name="deduction" value="{{ $payroll->deduction }}"
                        class="bg-gray-50 dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full text-gray-900 dark:text-gray-100 transition">
                </div>

                {{-- Payment Date --}}
                {{--

            <div>
                <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200 text-sm">
                    Payment Date
                    </label>
                    <input type="date" name="payment_date" value="{{ $payroll->payment_date }}" required
                    class="bg-gray-50 dark:bg-gray-700 [&::-webkit-calendar-picker-indicator]:invert-[1] dark:[&::-webkit-calendar-picker-indicator]:invert-[1] px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full text-gray-900 dark:text-gray-100 transition">
                    </div>
                    --}}

                <div>
                    <label class="block dark:text-gray-200">Payment Date</label>
                    <input type="date" name="payment_date" value="{{ $payroll->payment_date }}" required
                        class="bg-gray-50 dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full dark:text-gray-100 dark:[color-scheme:dark]">
                </div>

                {{-- Buttons --}}
                <div class="flex justify-between items-center pt-6">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 shadow px-6 py-2.5 rounded-lg font-semibold text-white transition duration-200">
                        Update
                    </button>
                    <a href="{{ route('payrolls.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 shadow px-6 py-2.5 rounded-lg font-semibold text-gray-800 dark:text-gray-200 transition duration-200">
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>
    <script>
        const employeeSelect = document.getElementById('employeeSelect');
        const salaryText = document.getElementById('basicSalaryText');

        function formatRupiah(value) {
            return 'Rp ' + Number(value).toLocaleString('id-ID');
        }

        employeeSelect?.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const salary = selectedOption.dataset.salary;

            salaryText.innerText = salary ? formatRupiah(salary) : '-';
        });

        const bonusInput = document.querySelector('input[name="bonus"]');
        const deductionInput = document.querySelector('input[name="deduction"]');
        const netPreview = document.getElementById('netSalaryPreview');

        function updateNetSalary() {
            const salary = Number(employeeSelect.options[employeeSelect.selectedIndex]?.dataset.salary || 0);
            const bonus = Number(bonusInput.value || 0);
            const deduction = Number(deductionInput.value || 0);

            netPreview.innerText = formatRupiah(salary + bonus - deduction);
        }

        employeeSelect.addEventListener('change', updateNetSalary);
        bonusInput.addEventListener('input', updateNetSalary);
        deductionInput.addEventListener('input', updateNetSalary);
    </script>
@endsection
