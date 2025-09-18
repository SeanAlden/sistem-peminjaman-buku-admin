{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Chart of Accounts</h2>
    <a href="{{ route('accounts.create') }}" class="mb-3 btn btn-primary">+ Add Account</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Code</th><th>Name</th><th>Type</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $acc)
            <tr>
                <td>{{ $acc->code }}</td>
                <td>{{ $acc->name }}</td>
                <td>{{ ucfirst($acc->type) }}</td>
                <td>
                    <a href="{{ route('accounts.edit',$acc->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('accounts.destroy',$acc->id) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete account?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="container px-6 mx-auto mt-10">
    <h2 class="mb-6 text-2xl font-bold text-gray-800 dark:text-gray-100">Chart of Accounts</h2>

    <!-- Add Account Button -->
    <a href="{{ route('accounts.create') }}" 
       class="inline-block px-4 py-2 mb-5 font-medium text-white transition bg-blue-600 rounded-lg shadow-md hover:bg-blue-700">
        + Add Account
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
                    <th class="px-4 py-2 font-semibold text-left text-gray-700 dark:text-gray-200">Code</th>
                    <th class="px-4 py-2 font-semibold text-left text-gray-700 dark:text-gray-200">Name</th>
                    <th class="px-4 py-2 font-semibold text-left text-gray-700 dark:text-gray-200">Type</th>
                    <th class="px-4 py-2 font-semibold text-center text-gray-700 dark:text-gray-200">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($accounts as $acc)
                <tr class="transition border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900">
                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100">{{ $acc->code }}</td>
                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100">{{ $acc->name }}</td>
                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100">{{ ucfirst($acc->type) }}</td>
                    <td class="flex justify-center gap-2 px-4 py-2">
                        <!-- Edit Button -->
                        <a href="{{ route('accounts.edit',$acc->id) }}" 
                           class="px-3 py-1 text-sm font-medium text-white transition bg-yellow-500 rounded-lg shadow hover:bg-yellow-600">
                            Edit
                        </a>
                        <!-- Delete Button -->
                        <form action="{{ route('accounts.destroy',$acc->id) }}" method="POST" onsubmit="return confirm('Delete account?')">
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
@endsection
