@extends('layouts.app')

@section('content')
<div class="mx-auto mt-6 max-w-xl rounded bg-white p-6 shadow">
    <h2 class="mb-4 text-2xl font-bold text-gray-800">Add New Student</h2>

    <form action="{{ route('students.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name"
                   class="w-full rounded border border-gray-300 px-4 py-2 focus:border-blue-400 focus:outline-none focus:ring"
                   value="{{ old('name') }}">
            @error('name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Major -->
        <div>
            <label for="major" class="block font-medium text-gray-700">Major</label>
            <input type="text" name="Major" id="major"
                   class="w-full rounded border border-gray-300 px-4 py-2 focus:border-blue-400 focus:outline-none focus:ring"
                   value="{{ old('major') }}">
            @error('major')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email"
                   class="w-full rounded border border-gray-300 px-4 py-2 focus:border-blue-400 focus:outline-none focus:ring"
                   value="{{ old('email') }}">
            @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block font-medium text-gray-700">Phone</label>
            <input type="text" name="phone" id="phone"
                   class="w-full rounded border border-gray-300 px-4 py-2 focus:border-blue-400 focus:outline-none focus:ring"
                   value="{{ old('phone') }}">
            @error('phone')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="rounded bg-blue-600 px-5 py-2 font-semibold text-white hover:bg-blue-700">
            Submit
        </button>
    </form>
</div>
@endsection
