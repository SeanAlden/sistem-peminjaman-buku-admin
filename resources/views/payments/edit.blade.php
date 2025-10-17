{{-- @extends('layouts.app')

@section('content')
<div class="container max-w-lg mx-auto">
    <h2 class="mb-4 text-xl font-bold">Edit Payment #{{ $payment->id }}</h2>

    @if($errors->any())
        <div class="p-3 mb-4 text-red-700 bg-red-100 rounded">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('payments.update',$payment) }}" method="POST" class="space-y-3">
        @csrf @method('PUT')

        <div>
            <label class="block">Employee</label>
            <select name="employee_id" class="w-full px-2 py-1 border">
                <option value="">-- Optional --</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}" {{ old('employee_id',$payment->employee_id)==$emp->id ? 'selected':'' }}>
                        {{ $emp->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block">Supplier</label>
            <select name="supplier_id" class="w-full px-2 py-1 border">
                <option value="">-- Optional --</option>
                @foreach($suppliers as $sup)
                    <option value="{{ $sup->id }}" {{ old('supplier_id',$payment->supplier_id)==$sup->id ? 'selected':'' }}>
                        {{ $sup->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block">Amount</label>
            <input type="number" step="0.01" name="amount" value="{{ old('amount',$payment->amount) }}" required
                   class="w-full px-2 py-1 border">
        </div>

        <div>
            <label class="block">Payment Date</label>
            <input type="date" name="payment_date" value="{{ old('payment_date',$payment->payment_date) }}" required
                   class="w-full px-2 py-1 border">
        </div>

        <div>
            <label class="block">Method</label>
            <select name="method" class="w-full px-2 py-1 border">
                <option value="cash" {{ old('method',$payment->method)=='cash'?'selected':'' }}>Cash</option>
                <option value="transfer" {{ old('method',$payment->method)=='transfer'?'selected':'' }}>Transfer</option>
                <option value="other" {{ old('method',$payment->method)=='other'?'selected':'' }}>Other</option>
            </select>
        </div>

        <div>
            <label class="block">Notes</label>
            <textarea name="notes" rows="3" class="w-full px-2 py-1 border">{{ old('notes',$payment->notes) }}</textarea>
        </div>

        <button class="px-4 py-2 text-white bg-green-600 rounded">Update</button>
    </form>
</div>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="container max-w-lg p-4 mx-auto rounded-lg shadow dark:bg-gray-900 dark:text-gray-100">
    <h2 class="mb-4 text-xl font-bold">Edit Payment #{{ $payment->id }}</h2>

    @if($errors->any())
        <div class="p-3 mb-4 text-red-700 bg-red-100 rounded dark:bg-red-900 dark:text-red-200">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('payments.update', $payment) }}" method="POST" class="space-y-3">
        @csrf 
        @method('PUT')

        <div>
            <label class="block dark:text-gray-200">Employee</label>
            <select name="employee_id" 
                    class="w-full px-2 py-1 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="">-- Optional --</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}" {{ old('employee_id',$payment->employee_id)==$emp->id ? 'selected':'' }}>
                        {{ $emp->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block dark:text-gray-200">Supplier</label>
            <select name="supplier_id" 
                    class="w-full px-2 py-1 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="">-- Optional --</option>
                @foreach($suppliers as $sup)
                    <option value="{{ $sup->id }}" {{ old('supplier_id',$payment->supplier_id)==$sup->id ? 'selected':'' }}>
                        {{ $sup->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block dark:text-gray-200">Amount</label>
            <input type="number" step="0.01" name="amount" value="{{ old('amount',$payment->amount) }}" required
                   class="w-full px-2 py-1 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block dark:text-gray-200">Payment Date</label>
            <input type="date" name="payment_date" value="{{ old('payment_date',$payment->payment_date) }}" required
                   class="w-full border px-2 py-1 rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:[color-scheme:dark] dark:invert-[0.9] focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block dark:text-gray-200">Method</label>
            <select name="method" 
                    class="w-full px-2 py-1 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="cash" {{ old('method',$payment->method)=='cash'?'selected':'' }}>Cash</option>
                <option value="transfer" {{ old('method',$payment->method)=='transfer'?'selected':'' }}>Transfer</option>
                <option value="other" {{ old('method',$payment->method)=='other'?'selected':'' }}>Other</option>
            </select>
        </div>

        <div>
            <label class="block dark:text-gray-200">Notes</label>
            <textarea name="notes" rows="3"
                      class="w-full px-2 py-1 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('notes',$payment->notes) }}</textarea>
        </div>

        <button class="px-4 py-2 text-white transition bg-green-600 rounded hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600">
            Update
        </button>
    </form>
</div>
@endsection
