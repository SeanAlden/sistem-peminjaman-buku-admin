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
                        <td class="px-4 py-3 text-sm text-gray-700">{{ number_format($p->deduction ?? 0,0,',','.') }}
                        </td>
                        <td class="px-4 py-3 font-semibold text-green-600">{{ number_format($p->net_salary,0,',','.') }}
                        </td>
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
                                <form action="{{ route('payrolls.destroy',$p->id) }}" method="POST"
                                    onsubmit="return confirm('Delete payroll?')">
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

        <!-- Fitur Search dan Items per Page -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <form action="{{ route('payrolls.index') }}" method="GET" class="flex items-center">
                    <label for="per_page" class="mr-2 text-sm text-gray-600 dark:text-white">Show:</label>
                    <select name="per_page" id="per_page"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        onchange="this.form.submit()">
                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <input type="hidden" name="search" value="{{ $search }}">
                </form>
            </div>
            <div class="flex items-center">
                <form action="{{ route('payrolls.index') }}" method="GET" class="flex items-center">
                    <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>
        <!-- End Fitur -->

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
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ number_format($p->basic_salary, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ number_format($p->bonus ?? 0, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ number_format($p->deduction ?? 0, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 font-semibold text-green-600 dark:text-green-400">
                                    {{ number_format($p->net_salary, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $p->payment_date }}</td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('payrolls.show', $p->id) }}"
                                            class="px-3 py-1 text-xs font-medium text-white transition bg-blue-500 rounded hover:bg-blue-600">
                                            Detail
                                        </a>
                                        <a href="{{ route('payrolls.edit', $p->id) }}"
                                            class="px-3 py-1 text-xs font-medium text-white transition bg-yellow-500 rounded hover:bg-yellow-600">
                                            Edit
                                        </a>
                                        <form action="{{ route('payrolls.destroy', $p->id) }}" method="POST"
                                            onsubmit="return confirm('Delete payroll?')">
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
            <!-- Fitur Pagination -->
            <div class="flex items-center justify-between mt-4">
                <div>
                    @if ($payrolls->total() > 0)
                        <p class="text-sm text-gray-700 dark:text-white">
                            Showing {{ $payrolls->firstItem() }} to {{ $payrolls->lastItem() }} of {{ $payrolls->total() }}
                            entries
                        </p>
                    @endif
                </div>
                <div>
                    @if ($payrolls->hasPages())
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                            {{-- Previous Page Link --}}
                            @if ($payrolls->onFirstPage())
                                <span class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                            @else
                                <a href="{{ $payrolls->previousPageUrl() }}" rel="prev"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                            @endif

                            @php
                                $currentPage = $payrolls->currentPage();
                                $lastPage = $payrolls->lastPage();
                                $links = [];

                                // Logic untuk menampilkan link pagination
                                if ($lastPage <= 7) {
                                    for ($i = 1; $i <= $lastPage; $i++) {
                                        $links[] = $i;
                                    }
                                } else {
                                    $links[] = 1;
                                    if ($currentPage > 4) {
                                        $links[] = '...';
                                    }

                                    $start = max(2, $currentPage - 1);
                                    $end = min($lastPage - 1, $currentPage + 1);

                                    if ($currentPage <= 4) {
                                        $start = 2;
                                        $end = 5;
                                    }

                                    if ($currentPage >= $lastPage - 3) {
                                        $start = $lastPage - 4;
                                        $end = $lastPage - 1;
                                    }

                                    for ($i = $start; $i <= $end; $i++) {
                                        $links[] = $i;
                                    }

                                    if ($currentPage < $lastPage - 3) {
                                        $links[] = '...';
                                    }
                                    $links[] = $lastPage;
                                }
                            @endphp

                            @foreach ($links as $link)
                                @if ($link === '...')
                                    <span class="px-3 py-1 mr-1 text-gray-500 bg-white border rounded">{{ $link }}</span>
                                @elseif ($link == $currentPage)
                                    <span
                                        class="px-3 py-1 mr-1 text-white bg-blue-500 border border-blue-500 rounded">{{ $link }}</span>
                                @else
                                    <a href="{{ $payrolls->url($link) }}"
                                        class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($payrolls->hasMorePages())
                                <a href="{{ $payrolls->nextPageUrl() }}" rel="next"
                                    class="px-3 py-1 ml-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Next</a>
                            @else
                                <span class="px-3 py-1 ml-1 text-gray-400 bg-white border rounded cursor-not-allowed">Next</span>
                            @endif
                        </nav>
                    @endif
                </div>
            </div>
            <!-- End Fitur Pagination -->
        </div>
    </div>
@endsection