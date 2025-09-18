{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Transactions</h2>
    <a href="{{ route('transactions.create') }}" class="mb-3 btn btn-primary">+ Add Transaction</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr><th>Reference</th><th>Date</th><th>Entries</th><th>Action</th></tr>
        </thead>
        <tbody>
            @foreach($transactions as $t)
            <tr>
                <td>{{ $t->reference }}</td>
                <td>{{ $t->transaction_date }}</td>
                <td>
                    <ul>
                        @foreach($t->journalEntries as $entry)
                            <li>{{ $entry->account->name }} - Debit: {{ $entry->debit }} | Credit: {{ $entry->credit }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <a href="{{ route('transactions.show',$t->id) }}" class="btn btn-info btn-sm">View</a>
                    <form action="{{ route('transactions.destroy',$t->id) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete transaction?')">Delete</button>
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
    @if(session('success'))
        <div class="px-4 py-3 mb-4 text-green-800 bg-green-100 border border-green-300 rounded-lg dark:bg-green-800 dark:text-green-100">
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
                @foreach($transactions as $t)
                <tr class="transition border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900">
                    <!-- Reference -->
                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100">{{ $t->reference }}</td>
                    
                    <!-- Date -->
                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100">{{ $t->transaction_date }}</td>
                    
                    <!-- Entries -->
                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100">
                        <ul class="space-y-1 list-disc list-inside">
                            @foreach($t->journalEntries as $entry)
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
        <a href="{{ route('transactions.create') }}" class="px-4 py-2 text-white bg-blue-600 rounded">+ Add Transaction</a>
        <a href="{{ route('transactions.trial_balance') }}" class="px-4 py-2 text-white bg-gray-700 rounded">Trial Balance</a>
    </div>

    @if(session('success'))
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
                @foreach($transactions as $t)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $t->reference }}</td>
                    <td class="px-4 py-2">{{ $t->transaction_date->format('Y-m-d') }}</td>
                    <td class="px-4 py-2">{{ \Illuminate\Support\Str::limit($t->description, 50) }}</td>
                    <td class="px-4 py-2">
                        <ul class="text-sm">
                            @foreach($t->journalEntries as $je)
                                <li>{{ $je->account->code ?? $je->coa_id }} — {{ $je->account->name ?? '-' }}: D {{ number_format($je->debit,2) }} / C {{ number_format($je->credit,2) }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <a href="{{ route('transactions.show', $t->id) }}" class="px-2 py-1 text-white rounded bg-cyan-600">View</a>
                        @if(!$t->is_reversal && $t->status !== 'reversed')
                        <form action="{{ route('transactions.reverse', $t->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Reverse this transaction?')">
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

@extends('layouts.app')

@section('content')
<div class="container px-6 mx-auto mt-8">
    <h2 class="mb-4 text-2xl font-semibold text-gray-900 dark:text-gray-300">Transactions</h2>

    <div class="flex items-center gap-3 mb-4">
        <a href="{{ route('transactions.create') }}" class="px-4 py-2 text-white bg-blue-600 rounded">+ Add Transaction</a>
        <a href="{{ route('transactions.trial_balance') }}" class="px-4 py-2 text-white bg-gray-700 rounded">Trial Balance</a>
    </div>

    @if(session('success'))
        <div class="p-3 mb-4 text-green-800 bg-green-100 rounded">{{ session('success') }}</div>
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
                @foreach($transactions as $t)
                <tr class="border-t hover:bg-gray-50 dark:hover:bg-gray-500">
                    <td class="px-4 py-2 text-gray-900 dark:text-gray-200">{{ $t->reference }}</td>
                    <td class="px-4 py-2 text-gray-900 dark:text-gray-200">{{ $t->transaction_date->format('Y-m-d') }}</td>
                    <td class="px-4 py-2 text-gray-900 dark:text-gray-200">{{ \Illuminate\Support\Str::limit($t->description, 50) }}</td>
                    <td class="px-4 py-2 text-gray-900 dark:text-gray-200">
                        <ul class="text-sm">
                            @foreach($t->journalEntries as $je)
                                <li>{{ $je->account->code ?? $je->coa_id }} — {{ $je->account->name ?? '-' }}: D {{ number_format($je->debit,2) }} / C {{ number_format($je->credit,2) }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <a href="{{ route('transactions.show', $t->id) }}" class="px-2 py-1 text-white rounded bg-cyan-600">View</a>
                        @if(!$t->is_reversal && $t->status !== 'reversed')
                        <form action="{{ route('transactions.reverse', $t->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Reverse this transaction?')">
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
@endsection


