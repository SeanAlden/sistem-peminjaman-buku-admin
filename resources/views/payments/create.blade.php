{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Payment</h2>
    <form action="{{ route('payments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Employee</label>
            <select name="employee_id" class="form-control">
                <option value="">-- Optional --</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Supplier</label>
            <select name="supplier_id" class="form-control">
                <option value="">-- Optional --</option>
                @foreach($suppliers as $sup)
                    <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Amount</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="payment_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Method</label>
            <select name="method" class="form-control" required>
                <option value="cash">Cash</option>
                <option value="transfer">Transfer</option>
                <option value="other">Other</option>
            </select>
        </div>
        <button class="btn btn-success">Save Payment</button>
    </form>
</div>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
<div class="container px-6 py-8 mx-auto">
    <h2 class="mb-6 text-2xl font-bold text-gray-800">Create Payment</h2>

    <div class="p-6 bg-white rounded-lg shadow">
        <form action="{{ route('payments.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Employee</label>
                <select name="employee_id" 
                        class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500">
                    <option value="">-- Optional --</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Supplier</label>
                <select name="supplier_id" 
                        class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500">
                    <option value="">-- Optional --</option>
                    @foreach($suppliers as $sup)
                        <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Amount</label>
                <input type="number" step="0.01" name="amount" required
                       class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500">
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="payment_date" required
                       class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500">
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Method</label>
                <select name="method" required
                        class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500">
                    <option value="cash">Cash</option>
                    <option value="transfer">Transfer</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div>
                <button type="submit" 
                        class="px-5 py-2 text-white bg-green-600 rounded-lg shadow hover:bg-green-700">
                    Save Payment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="container max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-4">Create Payment</h2>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('payments.store') }}" method="POST" class="space-y-3">
        @csrf

        <div>
            <label class="block">Employee</label>
            <select name="employee_id" class="w-full border px-2 py-1">
                <option value="">-- Optional --</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}" {{ old('employee_id')==$emp->id ? 'selected':'' }}>
                        {{ $emp->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block">Supplier</label>
            <select name="supplier_id" class="w-full border px-2 py-1">
                <option value="">-- Optional --</option>
                @foreach($suppliers as $sup)
                    <option value="{{ $sup->id }}" {{ old('supplier_id')==$sup->id ? 'selected':'' }}>
                        {{ $sup->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block">Amount</label>
            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" required
                   class="w-full border px-2 py-1">
        </div>

        <div>
            <label class="block">Payment Date</label>
            <input type="date" name="payment_date" value="{{ old('payment_date') }}" required
                   class="w-full border px-2 py-1">
        </div>

        <div>
            <label class="block">Method</label>
            <select name="method" class="w-full border px-2 py-1">
                <option value="cash" {{ old('method')=='cash'?'selected':'' }}>Cash</option>
                <option value="transfer" {{ old('method')=='transfer'?'selected':'' }}>Transfer</option>
                <option value="other" {{ old('method')=='other'?'selected':'' }}>Other</option>
            </select>
        </div>

        <div>
            <label class="block">Notes</label>
            <textarea name="notes" rows="3" class="w-full border px-2 py-1">{{ old('notes') }}</textarea>
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
    </form>
</div>
@endsection

