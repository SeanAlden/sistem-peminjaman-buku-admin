@extends('layouts.app')

@section('content')
<div class="max-w-xl p-6 mx-auto mt-6 bg-white rounded shadow-md">
    <h2 class="mb-4 text-2xl font-bold text-gray-800">Student Detail</h2>

    <ul class="divide-y divide-gray-200">
        <li class="py-3">
            <span class="font-semibold text-gray-700">Name:</span>
            <span class="ml-2 text-gray-900">{{ $student->name }}</span>
        </li>
        <li class="py-3">
            <span class="font-semibold text-gray-700">Major:</span>
            <span class="ml-2 text-gray-900">{{ $student->major }}</span>
        </li>
        <li class="py-3">
            <span class="font-semibold text-gray-700">Email:</span>
            <span class="ml-2 text-gray-900">{{ $student->email }}</span>
        </li>
        <li class="py-3">
            <span class="font-semibold text-gray-700">Phone:</span>
            <span class="ml-2 text-gray-900">{{ $student->phone }}</span>
        </li>
    </ul>

    <a href="{{ route('students.index') }}"
       class="inline-block px-4 py-2 mt-6 font-medium text-white bg-gray-500 rounded hover:bg-gray-600">
        ← Back
    </a>
</div>
@endsection
