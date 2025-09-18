{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Payments</h2>
    <a href="{{ route('payments.create') }}" class="mb-3 btn btn-primary">+ Add Payment</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr><th>ID</th><th>Employee</th><th>Supplier</th><th>Amount</th><th>Date</th><th>Method</th><th>Action</th></tr>
        </thead>
        <tbody>
            @foreach($payments as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->employee?->name }}</td>
                <td>{{ $p->supplier?->name }}</td>
                <td>{{ $p->amount }}</td>
                <td>{{ $p->payment_date }}</td>
                <td>{{ ucfirst($p->method) }}</td>
                <td>
                    <form action="{{ route('payments.destroy',$p->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete payment?')">Delete</button>
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
<div class="container px-6 py-8 mx-auto">
    <h2 class="mb-6 text-2xl font-bold text-gray-800">Payments</h2>

    <a href="{{ route('payments.create') }}" 
       class="inline-block px-4 py-2 mb-4 text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700">
        + Add Payment
    </a>

    @if(session('success'))
        <div class="px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full border border-gray-200">
            <thead class="text-white bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Employee</th>
                    <th class="px-4 py-2 text-left">Supplier</th>
                    <th class="px-4 py-2 text-left">Amount</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Method</th>
                    <th class="px-4 py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($payments as $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $p->id }}</td>
                    <td class="px-4 py-2">{{ $p->employee?->name }}</td>
                    <td class="px-4 py-2">{{ $p->supplier?->name }}</td>
                    <td class="px-4 py-2">{{ number_format($p->amount, 2) }}</td>
                    <td class="px-4 py-2">{{ $p->payment_date }}</td>
                    <td class="px-4 py-2">{{ ucfirst($p->method) }}</td>
                    <td class="px-4 py-2">
                        <form action="{{ route('payments.destroy',$p->id) }}" method="POST" onsubmit="return confirm('Delete payment?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach

                @if($payments->isEmpty())
                <tr>
                    <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                        No payments found.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-xl font-bold text-gray-800 dark:text-gray-200">Payments</h2>

    <a href="{{ route('payments.create') }}" 
       class="inline-block px-4 py-2 mb-3 text-white bg-blue-600 rounded-md hover:bg-blue-700">
       + New Payment
    </a>

    @if(session('success'))
        <div class="p-3 mb-4 text-green-800 bg-green-100 rounded">{{ session('success') }}</div>
    @endif

    <table class="w-full border dark:border-white">
        <thead>
            <tr class="text-left bg-gray-200">
                <th class="px-3 py-2">ID</th>
                <th class="px-3 py-2">Employee</th>
                <th class="px-3 py-2">Supplier</th>
                <th class="px-3 py-2">Amount</th>
                <th class="px-3 py-2">Date</th>
                <th class="px-3 py-2">Method</th>
                <th class="px-3 py-2">Notes</th>
                <th class="px-3 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $pay)
            <tr class="bg-gray-200 border-t dark:bg-gray-700">
                <td class="px-3 py-2 text-gray-900 dark:text-gray-100">{{ $pay->id }}</td>
                <td class="px-3 py-2 text-gray-900 dark:text-gray-100">{{ $pay->employee?->name ?? '-' }}</td>
                <td class="px-3 py-2 text-gray-900 dark:text-gray-100">{{ $pay->supplier?->name ?? '-' }}</td>
                <td class="px-3 py-2 text-gray-900 dark:text-gray-100">{{ number_format($pay->amount,2) }}</td>
                <td class="px-3 py-2 text-gray-900 dark:text-gray-100">{{ $pay->payment_date }}</td>
                <td class="px-3 py-2 text-gray-900 dark:text-gray-100">{{ ucfirst($pay->method) }}</td>
                <td class="px-3 py-2 text-gray-900 dark:text-gray-100">{{ $pay->notes ?? '-' }}</td>
                <td class="px-3 py-2">
                    <a href="{{ route('payments.edit',$pay) }}" 
                       class="px-2 py-1 text-white bg-yellow-500 rounded">Edit</a>
                    <form action="{{ route('payments.destroy',$pay) }}" method="POST" class="inline"
                          onsubmit="return confirm('Delete this payment?')">
                        @csrf @method('DELETE')
                        <button class="px-2 py-1 text-white bg-red-600 rounded">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="py-4 text-center">No payments found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
