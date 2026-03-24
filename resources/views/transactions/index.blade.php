{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Transactions</h2>
    <a href="{{ route('transactions.create') }}" class="mb-3 btn btn-primary">+ Add Transaction</a>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Reference</th>
                <th>Date</th>
                <th>Entries</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $t)
            <tr>
                <td>{{ $t->reference }}</td>
                <td>{{ $t->transaction_date }}</td>
                <td>
                    <ul>
                        @foreach ($t->journalEntries as $entry)
                        <li>{{ $entry->account->name }} - Debit: {{ $entry->debit }} | Credit: {{ $entry->credit }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <a href="{{ route('transactions.show',$t->id) }}" class="btn btn-info btn-sm">View</a>
                    <form action="{{ route('transactions.destroy',$t->id) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Delete transaction?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
<div class="container px-6 mx-auto mt-10">
    <h2 class="mb-6 text-2xl font-bold text-gray-800 dark:text-gray-100">Transactions</h2>

    <!-- Add Transaction Button -->
    <a href="{{ route('transactions.create') }}"
        class="inline-block px-4 py-2 mb-5 font-medium text-white transition bg-blue-600 rounded-lg shadow-md hover:bg-blue-700">
        + Add Transaction
    </a>

    <!-- Success Alert -->
    @if (session('success'))
    <div
        class="px-4 py-3 mb-4 text-green-800 bg-green-100 border border-green-300 rounded-lg dark:bg-green-800 dark:text-green-100">
        {{ session('success') }}
    </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-lg dark:bg-gray-800">
        <table class="min-w-full border border-gray-200 dark:border-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-2 font-semibold text-left text-gray-700 dark:text-gray-200">Reference</th>
                    <th class="px-4 py-2 font-semibold text-left text-gray-700 dark:text-gray-200">Date</th>
                    <th class="px-4 py-2 font-semibold text-left text-gray-700 dark:text-gray-200">Entries</th>
                    <th class="px-4 py-2 font-semibold text-center text-gray-700 dark:text-gray-200">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $t)
                <tr
                    class="transition border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900">
                    <!-- Reference -->
                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100">{{ $t->reference }}</td>

                    <!-- Date -->
                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100">{{ $t->transaction_date }}</td>

                    <!-- Entries -->
                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100">
                        <ul class="space-y-1 list-disc list-inside">
                            @foreach ($t->journalEntries as $entry)
                            <li>
                                <span class="font-medium">{{ $entry->account->name }}</span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    — Debit: {{ $entry->debit }} | Credit: {{ $entry->credit }}
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    </td>

                    <!-- Actions -->
                    <td class="flex justify-center gap-2 px-4 py-2">
                        <!-- View Button -->
                        <a href="{{ route('transactions.show',$t->id) }}"
                            class="px-3 py-1 text-sm font-medium text-white transition bg-blue-500 rounded-lg shadow hover:bg-blue-600">
                            View
                        </a>
                        <!-- Delete Button -->
                        <form action="{{ route('transactions.destroy',$t->id) }}" method="POST"
                            onsubmit="return confirm('Delete transaction?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="px-3 py-1 text-sm font-medium text-white transition bg-red-600 rounded-lg shadow hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
<div class="container px-6 mx-auto mt-8">
    <h2 class="mb-4 text-2xl font-semibold">Transactions</h2>

    <div class="flex items-center gap-3 mb-4">
        <a href="{{ route('transactions.create') }}" class="px-4 py-2 text-white bg-blue-600 rounded">+ Add
            Transaction</a>
        <a href="{{ route('transactions.trial_balance') }}" class="px-4 py-2 text-white bg-gray-700 rounded">Trial
            Balance</a>
    </div>

    @if (session('success'))
    <div class="p-3 mb-4 text-green-800 bg-green-100 rounded">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Reference</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Description</th>
                    <th class="px-4 py-2 text-left">Entries</th>
                    <th class="px-4 py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $t)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $t->reference }}</td>
                    <td class="px-4 py-2">{{ $t->transaction_date->format('Y-m-d') }}</td>
                    <td class="px-4 py-2">{{ \Illuminate\Support\Str::limit($t->description, 50) }}</td>
                    <td class="px-4 py-2">
                        <ul class="text-sm">
                            @foreach ($t->journalEntries as $je)
                            <li>{{ $je->account->code ?? $je->coa_id }} — {{ $je->account->name ?? '-' }}: D {{
                                number_format($je->debit,2) }} / C {{ number_format($je->credit,2) }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <a href="{{ route('transactions.show', $t->id) }}"
                            class="px-2 py-1 text-white rounded bg-cyan-600">View</a>
                        @if (!$t->is_reversal && $t->status !== 'reversed')
                        <form action="{{ route('transactions.reverse', $t->id) }}" method="POST" class="inline-block"
                            onsubmit="return confirm('Reverse this transaction?')">
                            @csrf
                            <button class="px-2 py-1 text-white bg-orange-600 rounded">Reverse</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
</div>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
    <div class="container px-6 mx-auto mt-8">
        <h2 class="mb-4 text-2xl font-semibold text-gray-900 dark:text-gray-300">Transactions</h2>

        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('transactions.create') }}" class="px-4 py-2 text-white bg-blue-600 rounded">+ Add
                Transaction</a>
            <a href="{{ route('transactions.trial_balance') }}" class="px-4 py-2 text-white bg-gray-700 rounded">Trial
                Balance</a>
        </div>

        <!-- Fitur Search dan Items per Page -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <form action="{{ route('transactions.index') }}" method="GET" class="flex items-center">
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
                <form action="{{ route('transactions.index') }}" method="GET" class="flex items-center">
                    <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>
        <!-- End Fitur -->

        @if (session('success'))
            <div id="success-alert"
                class="px-4 py-3 mb-6 text-green-700 bg-green-100 border border-green-400 rounded transition-opacity duration-500"
                role="alert">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => {
                    const alert = document.getElementById('success-alert');
                    if (alert) {
                        alert.classList.add('opacity-0');
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 2000);
            </script>
        @endif
        @if (session('error'))
            <div id="error-alert"
                class="px-4 py-3 mb-6 text-red-700 bg-red-100 border border-red-400 rounded transition-opacity duration-500"
                role="alert">
                {{ session('error') }}
            </div>
            <script>
                setTimeout(() => {
                    const alert = document.getElementById('error-alert');
                    if (alert) {
                        alert.classList.add('opacity-0');
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 2000);
            </script>
        @endif

        <div class="overflow-x-auto bg-white rounded shadow dark:bg-gray-600">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Reference</th>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-left">Description</th>
                        <th class="px-4 py-2 text-left">Entries</th>
                        <th class="px-4 py-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $t)
                        <tr class="border-t hover:bg-gray-50 dark:hover:bg-gray-500">
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-200">{{ $t->reference }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-200">
                                {{ $t->transaction_date->format('Y-m-d') }}
                            </td>
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-200">
                                {{ \Illuminate\Support\Str::limit($t->description, 50) }}
                            </td>
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-200">
                                <ul class="text-sm">
                                    @foreach ($t->journalEntries as $je)
                                        <li>{{ $je->account->code ?? $je->coa_id }} — {{ $je->account->name ?? '-' }}: D
                                            {{ number_format($je->debit, 2) }} / C {{ number_format($je->credit, 2) }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ route('transactions.show', $t->id) }}"
                                    class="px-2 py-1 text-white rounded bg-cyan-600">View</a>
                                @if (!$t->is_reversal && $t->status !== 'reversed')
                                    <form action="{{ route('transactions.reverse', $t->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Reverse this transaction?')">
                                        @csrf
                                        <button class="px-2 py-1 text-white bg-orange-600 rounded">Reverse</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Fitur Pagination -->
        <div class="flex items-center justify-between mt-4">
            <div>
                @if ($transactions->total() > 0)
                    <p class="text-sm text-gray-700 dark:text-white">
                        Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of
                        {{ $transactions->total() }}
                        entries
                    </p>
                @endif
            </div>
            <div>
                @if ($transactions->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                        @if ($transactions->onFirstPage())
                            <span
                                class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                        @else
                            <a href="{{ $transactions->previousPageUrl() }}" rel="prev"
                                class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                        @endif

                        @php
                            $currentPage = $transactions->currentPage();
                            $lastPage = $transactions->lastPage();
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
                                <span
                                    class="px-3 py-1 mr-1 text-gray-500 bg-white border rounded">{{ $link }}</span>
                            @elseif ($link == $currentPage)
                                <span
                                    class="px-3 py-1 mr-1 text-white bg-blue-500 border border-blue-500 rounded">{{ $link }}</span>
                            @else
                                <a href="{{ $transactions->url($link) }}"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                            @endif
                        @endforeach

                        @if ($transactions->hasMorePages())
                            <a href="{{ $transactions->nextPageUrl() }}" rel="next"
                                class="px-3 py-1 ml-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Next</a>
                        @else
                            <span
                                class="px-3 py-1 ml-1 text-gray-400 bg-white border rounded cursor-not-allowed">Next</span>
                        @endif
                    </nav>
                @endif
            </div>
        </div>
        <!-- End Fitur Pagination -->
    </div>
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="container px-6 mx-auto mt-8 min-h-screen">
        <h2 class="mb-4 text-2xl font-semibold text-gray-900 dark:text-gray-300">Transactions</h2>

        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('transactions.create') }}" class="px-4 py-2 text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 transition">
                + Add Transaction
            </a>
            <a href="{{ route('transactions.trial_balance') }}" class="px-4 py-2 text-white bg-gray-700 rounded-lg shadow hover:bg-gray-800 transition dark:bg-gray-600 dark:hover:bg-gray-500">
                Trial Balance
            </a>
        </div>

        @if (session('success'))
            <div id="success-alert"
                class="px-4 py-3 mb-6 text-green-700 transition-opacity duration-500 bg-green-100 border border-green-400 rounded shadow-sm"
                role="alert">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => {
                    const alert = document.getElementById('success-alert');
                    if (alert) {
                        alert.classList.add('opacity-0');
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 2000);
            </script>
        @endif
        @if (session('error'))
            <div id="error-alert"
                class="px-4 py-3 mb-6 text-red-700 transition-opacity duration-500 bg-red-100 border border-red-400 rounded shadow-sm"
                role="alert">
                {{ session('error') }}
            </div>
            <script>
                setTimeout(() => {
                    const alert = document.getElementById('error-alert');
                    if (alert) {
                        alert.classList.add('opacity-0');
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 2000);
            </script>
        @endif

        <div class="flex flex-col gap-3 mb-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center w-full sm:w-auto">
                <label for="per_page" class="mr-2 text-sm text-gray-600 dark:text-white">Show:</label>
                <select id="per_page" onchange="fetchData()"
                    class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:w-auto">
                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
            <div class="flex items-center w-full sm:w-auto">
                <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                <input type="text" id="search" oninput="handleSearch()"
                    class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:w-64"
                    value="{{ $search }}" placeholder="Search description/ref...">
            </div>
        </div>
        <div id="dynamic-content">
            <div class="overflow-x-auto bg-white rounded-lg shadow-lg dark:bg-gray-800">
                <table class="min-w-full border border-gray-200 dark:border-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-left text-gray-700 dark:text-gray-200">Reference</th>
                            <th class="px-4 py-3 font-semibold text-left text-gray-700 dark:text-gray-200">Date</th>
                            <th class="px-4 py-3 font-semibold text-left text-gray-700 dark:text-gray-200">Description</th>
                            <th class="px-4 py-3 font-semibold text-left text-gray-700 dark:text-gray-200">Entries</th>
                            <th class="px-4 py-3 font-semibold text-center text-gray-700 dark:text-gray-200">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($transactions as $t)
                            <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-200">{{ $t->reference }}</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-200">
                                    {{ $t->transaction_date->format('Y-m-d') }}
                                </td>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-200">
                                    {{ \Illuminate\Support\Str::limit($t->description, 50) }}
                                </td>
                                <td class="px-4 py-3 text-gray-900 dark:text-gray-200">
                                    <ul class="text-sm space-y-1">
                                        @foreach ($t->journalEntries as $je)
                                            <li>
                                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ $je->account->code ?? $je->coa_id }} — {{ $je->account->name ?? '-' }}:</span>
                                                <span class="text-green-600 dark:text-green-400">D {{ number_format($je->debit, 2) }}</span> /
                                                <span class="text-red-500 dark:text-red-400">C {{ number_format($je->credit, 2) }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('transactions.show', $t->id) }}"
                                            class="px-3 py-1.5 text-xs font-medium text-white transition bg-cyan-600 rounded hover:bg-cyan-700 shadow-sm">
                                            View
                                        </a>
                                        @if (!$t->is_reversal && $t->status !== 'reversed')
                                            <button type="button" onclick="openReverseModal({{ $t->id }})"
                                                class="px-3 py-1.5 text-xs font-medium text-white transition bg-orange-600 rounded hover:bg-orange-700 shadow-sm">
                                                Reverse
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                    No transactions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="pagination-links" class="flex flex-col items-center justify-between mt-6 sm:flex-row">
                <div class="mb-4 sm:mb-0">
                    @if ($transactions->total() > 0)
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of
                            {{ $transactions->total() }} entries
                        </p>
                    @endif
                </div>
                <div>
                    @if ($transactions->hasPages())
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                            {{-- Previous Page Link --}}
                            @if ($transactions->onFirstPage())
                                <span class="px-3 py-1 mr-1 text-gray-400 bg-white border border-gray-300 rounded cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500">Prev</span>
                            @else
                                <a href="{{ $transactions->previousPageUrl() }}" rel="prev"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">Prev</a>
                            @endif

                            @php
                                $currentPage = $transactions->currentPage();
                                $lastPage = $transactions->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            @endphp

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $currentPage)
                                    <span class="px-3 py-1 mr-1 text-white bg-blue-600 border border-blue-600 rounded dark:bg-blue-600 dark:border-blue-600">{{ $i }}</span>
                                @else
                                    <a href="{{ $transactions->url($i) }}"
                                        class="px-3 py-1 mr-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">{{ $i }}</a>
                                @endif
                            @endfor

                            {{-- Next Page Link --}}
                            @if ($transactions->hasMorePages())
                                <a href="{{ $transactions->nextPageUrl() }}" rel="next"
                                    class="px-3 py-1 ml-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">Next</a>
                            @else
                                <span class="px-3 py-1 ml-1 text-gray-400 bg-white border border-gray-300 rounded cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500">Next</span>
                            @endif
                        </nav>
                    @endif
                </div>
            </div>
        </div>
        </div>

    <form id="globalReverseForm" method="POST" style="display: none;">
        @csrf
        </form>
@endsection

@section('scripts')
    <script>
        // =========================================================
        // 1. ENGINE SPA (PREFETCH, CACHE, & REAL-TIME SEARCH)
        // =========================================================
        const pageCache = {};
        let currentAbortController = null;
        let debounceTimer;

        // Fungsi Debounce (Jeda 100ms agar server tidak down saat ngetik)
        function handleSearch() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetchData();
            }, 100);
        }

        // Fungsi Inti Fetch Data
        function fetchData(targetUrl = null) {
            if (typeof targetUrl !== 'string') targetUrl = null;

            const search = document.getElementById('search').value;
            const perPage = document.getElementById('per_page').value;

            let urlString = targetUrl || `{{ route('transactions.index') }}`;
            const urlObj = new URL(urlString, window.location.origin);

            // Fix Vercel HTTPS Protocol Error (Wajib!)
            if (window.location.protocol === 'https:') {
                urlObj.protocol = 'https:';
            }

            urlObj.searchParams.set('search', search);
            urlObj.searchParams.set('per_page', perPage);

            const finalUrl = urlObj.toString();

            // Cek Cache (0ms response)
            if (pageCache[finalUrl]) {
                renderDOM(pageCache[finalUrl]);
                window.history.pushState({ path: finalUrl }, '', finalUrl);
                return;
            }

            // Batalkan fetch lama jika user mengetik terlalu cepat
            if (currentAbortController) {
                currentAbortController.abort();
            }
            currentAbortController = new AbortController();

            // Transisi UI saat loading
            document.getElementById('dynamic-content').style.opacity = '0.5';

            fetch(finalUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                signal: currentAbortController.signal
            })
            .then(response => {
                if (!response.ok) throw new Error("Gagal memuat server");
                return response.text();
            })
            .then(html => {
                pageCache[finalUrl] = html;
                renderDOM(html);
                window.history.pushState({ path: finalUrl }, '', finalUrl);
            })
            .catch(error => {
                if (error.name !== 'AbortError') {
                    console.error('Fetch Error:', error);
                    document.getElementById('dynamic-content').style.opacity = '1';
                }
            });
        }

        function renderDOM(html) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const dynamicElement = doc.getElementById('dynamic-content');

            if (dynamicElement) {
                document.getElementById('dynamic-content').innerHTML = dynamicElement.innerHTML;
            }
            document.getElementById('dynamic-content').style.opacity = '1';
        }

        // INTENT PREDICTION (Fetch data sebelum user klik tombol halaman)
        document.addEventListener('mouseover', function (e) {
            const link = e.target.closest('#pagination-links a');
            if (link) {
                const hoverUrlObj = new URL(link.href, window.location.origin);
                if (window.location.protocol === 'https:') {
                    hoverUrlObj.protocol = 'https:';
                }
                const safeHoverUrl = hoverUrlObj.toString();

                if (!pageCache[safeHoverUrl]) {
                    fetch(safeHoverUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(res => res.text())
                        .then(html => pageCache[safeHoverUrl] = html)
                        .catch(() => { });
                }
            }
        });

        // EVENT DELEGATION (Aman dari DOM Replacement)
        document.addEventListener('click', function(e) {
            const link = e.target.closest('#pagination-links a');
            if (link) {
                e.preventDefault();
                fetchData(link.href);
            }
        });

        // SPA Navigation Back/Forward
        window.addEventListener('popstate', function(e) {
            if (e.state && e.state.path) {
                fetchData(e.state.path);
            } else {
                fetchData(window.location.href);
            }
        });


        // =========================================================
        // 2. SWEETALERT LOGIC (Reverse Transaction)
        // =========================================================
        const isDark = () => document.documentElement.classList.contains('dark');
        const swalBg = () => isDark() ? '#1f2937' : '#ffffff';
        const swalText = () => isDark() ? '#ffffff' : '#374151';

        function openReverseModal(transactionId) {
            Swal.fire({
                title: 'Reverse Transaction?',
                text: "Are you sure you want to reverse this transaction? This action will generate a reversal entry and cannot be undone.",
                icon: 'warning',
                background: swalBg(),
                color: swalText(),
                showCancelButton: true,
                confirmButtonColor: '#ea580c', // Orange-600
                cancelButtonColor: '#6b7280',  // Gray-500
                confirmButtonText: 'Yes, Reverse',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('globalReverseForm');
                    // Ganti placeholder dengan ID transaksi yang dipilih
                    const baseAction = "{{ route('transactions.reverse', 'ID_PLACEHOLDER') }}";
                    form.action = baseAction.replace('ID_PLACEHOLDER', transactionId);
                    form.submit();
                }
            });
        }
    </script>
@endsection
