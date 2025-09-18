@extends('layouts.app')

@section('content')
<div class="container max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-4">Edit Payment #{{ $payment->id }}</h2>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
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
            <select name="employee_id" class="w-full border px-2 py-1">
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
            <select name="supplier_id" class="w-full border px-2 py-1">
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
                   class="w-full border px-2 py-1">
        </div>

        <div>
            <label class="block">Payment Date</label>
            <input type="date" name="payment_date" value="{{ old('payment_date',$payment->payment_date) }}" required
                   class="w-full border px-2 py-1">
        </div>

        <div>
            <label class="block">Method</label>
            <select name="method" class="w-full border px-2 py-1">
                <option value="cash" {{ old('method',$payment->method)=='cash'?'selected':'' }}>Cash</option>
                <option value="transfer" {{ old('method',$payment->method)=='transfer'?'selected':'' }}>Transfer</option>
                <option value="other" {{ old('method',$payment->method)=='other'?'selected':'' }}>Other</option>
            </select>
        </div>

        <div>
            <label class="block">Notes</label>
            <textarea name="notes" rows="3" class="w-full border px-2 py-1">{{ old('notes',$payment->notes) }}</textarea>
        </div>

        <button class="px-4 py-2 bg-green-600 text-white rounded">Update</button>
    </form>
</div>
@endsection
