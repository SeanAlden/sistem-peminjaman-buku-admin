@extends('layouts.app')

@section('content')
<div class="container px-6 mx-auto mt-8">
    <h2 class="text-2xl font-semibold mb-4">Transaction: {{ $transaction->reference }}</h2>

    <div class="bg-white p-4 rounded shadow mb-4">
        <p><strong>Date:</strong> {{ $transaction->transaction_date->format('Y-m-d') }}</p>
        <p><strong>Description:</strong> {{ $transaction->description }}</p>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-3 py-2 text-left">Account</th>
                    <th class="px-3 py-2 text-right">Debit</th>
                    <th class="px-3 py-2 text-right">Credit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->journalEntries as $je)
                <tr class="border-t">
                    <td class="px-3 py-2">{{ $je->account->code ?? $je->coa_id }} - {{ $je->account->name ?? '-' }}</td>
                    <td class="px-3 py-2 text-right">{{ number_format($je->debit,2) }}</td>
                    <td class="px-3 py-2 text-right">{{ number_format($je->credit,2) }}</td>
                </tr>
                @endforeach
                <tr class="font-semibold bg-gray-50">
                    <td class="px-3 py-2 text-right">Total</td>
                    <td class="px-3 py-2 text-right">{{ number_format($totalDebit,2) }}</td>
                    <td class="px-3 py-2 text-right">{{ number_format($totalCredit,2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="{{ route('transactions.index') }}" class="px-3 py-2 bg-gray-600 text-white rounded">Back</a>
        @if(!$transaction->is_reversal && $transaction->status !== 'reversed')
            <form action="{{ route('transactions.reverse', $transaction->id) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Reverse this transaction?')">
                @csrf
                <button class="px-3 py-2 bg-orange-600 text-white rounded">Reverse</button>
            </form>
        @endif
    </div>
</div>
@endsection
