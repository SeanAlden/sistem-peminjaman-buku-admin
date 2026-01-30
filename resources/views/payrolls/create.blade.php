{{-- @extends('layouts.app')

@section('content')
<div class="flex justify-center items-center bg-gray-100 min-h-screen">
    <div class="bg-white shadow-lg p-8 rounded-2xl w-full max-w-2xl">
        <h2 class="mb-6 font-bold text-gray-800 text-2xl text-center">Add Payroll</h2>

        <form method="POST" action="{{ route('payrolls.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block mb-2 font-semibold text-gray-700 text-sm">Employee</label>
                <select name="employee_id" required
                        class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full">
                    <option value="">-- Select Employee --</option>
                    @foreach ($employees as $e)
                        <option value="{{ $e->id }}">{{ $e->name }} - {{ $e->position }}</option>
                    @endforeaselectch
                </select>
            </div>
            <div>
                <label class="block mb-2 font-semibold text-gray-700 text-sm">Basic Salary</label>
                <input type="number" name="basic_salary" required
                       class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full">
            </div>
            <div>
                <label class="block mb-2 font-semibold text-gray-700 text-sm">Bonus</label>
                <input type="number" name="bonus"
                       class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full">
            </div>
            <div>
                <label class="block mb-2 font-semibold text-gray-700 text-sm">Deduction</label>
                <input type="number" name="deduction"
                       class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full">
            </div>
            <div>
                <label class="block dark:text-gray-200">Payment Date</label>
                <input type="date" name="payment_date" required
                   class="dark:bg-gray-800 px-2 py-1 border dark:border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 w-full dark:text-gray-100 dark:[color-scheme:dark]">
            </div>

            <div class="flex justify-between items-center pt-4">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 shadow px-5 py-2 rounded-lg text-white transition duration-200">
                    Save
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
                Add Payroll
            </h2>

            <form method="POST" action="{{ route('payrolls.store') }}" class="space-y-5">
                @csrf

                {{-- Employee --}}
                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200 text-sm">
                        Employee
                    </label>
                    {{--

                    <select name="employee_id" required
                    class="bg-gray-50 dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full text-gray-900 dark:text-gray-100 transition">
                    <option value="" class="dark:bg-gray-700">-- Select Employee --</option>
                    @foreach ($employees as $e)
                    <option value="{{ $e->id }}" class="dark:bg-gray-700">
                        {{ $e->name }} - {{ $e->position }}
                        </option>
                        @endforeach
                        </select>
                        --}}
                    <select name="employee_id" id="employeeSelect" required
                        class="bg-gray-50 dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full text-gray-900 dark:text-gray-100 transition">
                        <option value="" class="dark:bg-gray-700">-- Select Employee --</option>
                        @foreach ($employees as $e)
                            <option value="{{ $e->id }}" class="dark:bg-gray-700"
                                data-salary="{{ $e->base_salary }}">
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
                        <input type="number" name="basic_salary" required //
                        class="bg-gray-50 dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full text-gray-900 dark:text-gray-100 transition">
                        </div>
                        --}}

                {{-- Basic Salary --}}
                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200 text-sm">
                        Basic Salary
                    </label>
                    <div id="basicSalaryText"
                        class="bg-gray-100 dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg w-full dark:text-gray-100">
                        -
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
                    <input type="number" name="bonus"
                        class="bg-gray-50 dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full text-gray-900 dark:text-gray-100 transition">
                </div>

                {{-- Deduction --}}
                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200 text-sm">
                        Deduction
                    </label>
                    <input type="number" name="deduction"
                        class="bg-gray-50 dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full text-gray-900 dark:text-gray-100 transition">
                </div>

                {{-- Payment Date --}}

                {{--
                    <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200 text-sm">
                        Payment Date
                    </label>
                    <input type="date" name="payment_date" required
                        class="bg-gray-50 dark:bg-gray-700 [&::-webkit-calendar-picker-indicator]:invert-[1] dark:[&::-webkit-calendar-picker-indicator]:invert-[1] px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 w-full text-gray-900 dark:text-gray-100 transition">
                </div>
                --}}

                <div>
                    <label class="block dark:text-gray-200">Payment Date</label>
                    <input type="date" name="payment_date" required
                        class="bg-gray-50 dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full dark:text-gray-100 dark:[color-scheme:dark]">
                </div>

                {{-- Buttons --}}
                <div class="flex justify-between items-center pt-6">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 shadow px-6 py-2.5 rounded-lg font-semibold text-white transition duration-200">
                        Save
                    </button>
                    <a href="{{ route('payrolls.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 shadow px-6 py-2.5 rounded-lg font-semibold text-gray-800 dark:text-gray-200 transition duration-200">
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>
    {{-- <script>
        const employeeSelect = document.getElementById('employeeSelect');
        // const salaryText = document.getElementById('basicSalaryText');

        function formatRupiah(value) {
            return 'Rp ' + Number(value).toLocaleString('id-ID');
        }

        // employeeSelect?.addEventListener('change', function() {
        //     const selectedOption = this.options[this.selectedIndex];
        //     const salary = selectedOption.dataset.salary;

        //     salaryText.innerText = salary ? formatRupiah(salary) : '-';
        // });

        document.getElementById('employeeSelect')?.addEventListener('change', function() {
            const salary = this.options[this.selectedIndex].dataset.salary;
            document.getElementById('basicSalaryText').innerText =
                salary ? 'Rp ' + Number(salary).toLocaleString('id-ID') : '-';
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
    </script> --}}
    <script>
        const employeeSelect = document.getElementById('employeeSelect');
        const bonusInput = document.querySelector('input[name="bonus"]');
        const deductionInput = document.querySelector('input[name="deduction"]');
        const basicSalaryText = document.getElementById('basicSalaryText');
        const netPreview = document.getElementById('netSalaryPreview');

        function formatRupiah(value) {
            return 'Rp ' + Number(value).toLocaleString('id-ID');
        }

        function updateSalaryDisplay() {
            const selectedOption = employeeSelect.options[employeeSelect.selectedIndex];
            const salary = Number(selectedOption?.dataset.salary || 0);

            // Basic Salary
            basicSalaryText.innerText = salary ? formatRupiah(salary) : '-';

            // Net Salary
            const bonus = Number(bonusInput.value || 0);
            const deduction = Number(deductionInput.value || 0);

            netPreview.innerText = salary ?
                formatRupiah(salary + bonus - deduction) :
                '-';
        }

        // Event listeners
        employeeSelect.addEventListener('change', updateSalaryDisplay);
        bonusInput.addEventListener('input', updateSalaryDisplay);
        deductionInput.addEventListener('input', updateSalaryDisplay);
    </script>
@endsection
