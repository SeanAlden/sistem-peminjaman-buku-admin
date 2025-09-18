@extends('layouts.app')

@section('content')
<div class="container px-6 mx-auto mt-8">
    <h2 class="mb-4 text-2xl font-semibold">Trial Balance</h2>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Account</th>
                    <th class="px-4 py-2 text-right">Debit</th>
                    <th class="px-4 py-2 text-right">Credit</th>
                </tr>
            </thead>
            <tbody>
                @php $sumD = 0; $sumC = 0; @endphp
                @foreach($accounts as $row)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $row['account']->code }} - {{ $row['account']->name }}</td>
                        <td class="px-4 py-2 text-right">{{ number_format($row['debit'],2) }}</td>
                        <td class="px-4 py-2 text-right">{{ number_format($row['credit'],2) }}</td>
                    </tr>
                    @php $sumD += $row['debit']; $sumC += $row['credit']; @endphp
                @endforeach
                <tr class="font-semibold bg-gray-50">
                    <td class="px-4 py-2 text-right">Total</td>
                    <td class="px-4 py-2 text-right">{{ number_format($sumD,2) }}</td>
                    <td class="px-4 py-2 text-right">{{ number_format($sumC,2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
