{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Account</h2>
    <form action="{{ route('accounts.update',$account->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Code</label>
            <input type="text" name="code" class="form-control" value="{{ $account->code }}" required>
        </div>
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $account->name }}" required>
        </div>
        <div class="mb-3">
            <label>Type</label>
            <select name="type" class="form-control" required>
                @foreach(['asset','liability','equity','revenue','expense'] as $t)
                    <option value="{{ $t }}" @if($account->type==$t) selected @endif>{{ ucfirst($t) }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="container px-6 mx-auto mt-10">
    <h2 class="mb-6 text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Account</h2>

    <form action="{{ route('accounts.update',$account->id) }}" method="POST" 
          class="p-6 space-y-5 bg-white shadow-lg dark:bg-gray-800 rounded-xl">
        @csrf 
        @method('PUT')

        <!-- Code -->
        <div>
            <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200">Code</label>
            <input 
                type="text" 
                name="code" 
                value="{{ $account->code }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                required>
        </div>

        <!-- Name -->
        <div>
            <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200">Name</label>
            <input 
                type="text" 
                name="name" 
                value="{{ $account->name }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                required>
        </div>

        <!-- Type -->
        <div>
            <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200">Type</label>
            <select 
                name="type" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                required>
                @foreach(['asset','liability','equity','revenue','expense'] as $t)
                    <option value="{{ $t }}" @if($account->type==$t) selected @endif>
                        {{ ucfirst($t) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button 
                type="submit" 
                class="px-5 py-2 font-semibold text-white transition bg-green-600 rounded-lg shadow-md hover:bg-green-700">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
