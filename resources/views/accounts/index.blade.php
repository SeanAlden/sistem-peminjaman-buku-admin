{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Chart of Accounts</h2>
    <a href="{{ route('accounts.create') }}" class="mb-3 btn btn-primary">+ Add Account</a>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accounts as $acc)
            <tr>
                <td>{{ $acc->code }}</td>
                <td>{{ $acc->name }}</td>
                <td>{{ ucfirst($acc->type) }}</td>
                <td>
                    <a href="{{ route('accounts.edit',$acc->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('accounts.destroy',$acc->id) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Delete account?')">Delete</button>
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
        {{-- @if (session('success'))
            <div
                class="px-4 py-3 mb-4 text-green-800 bg-green-100 border border-green-300 rounded-lg dark:bg-green-800 dark:text-green-100">
                {{ session('success') }}
            </div>
        @endif --}}

        @if (session('success'))
            <div id="success-alert"
                class="px-4 py-3 mb-6 text-green-700 bg-green-100 border border-green-400 rounded transition-opacity duration-500"
                role="alert">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => {
                    const alert = document.getElementById('success-alert');
                    if (alert) {
                        alert.classList.add('opacity-0');
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 2000);
            </script>
        @endif
        @if (session('error'))
            <div id="error-alert"
                class="px-4 py-3 mb-6 text-red-700 bg-red-100 border border-red-400 rounded transition-opacity duration-500"
                role="alert">
                {{ session('error') }}
            </div>
            <script>
                setTimeout(() => {
                    const alert = document.getElementById('error-alert');
                    if (alert) {
                        alert.classList.add('opacity-0');
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 2000);
            </script>
        @endif

        <!-- Fitur Search dan Items per Page -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <form action="{{ route('accounts.index') }}" method="GET" class="flex items-center">
                    <label for="per_page" class="mr-2 text-sm text-gray-600 dark:text-white">Show:</label>
                    <select name="per_page" id="per_page"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        onchange="this.form.submit()">
                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <input type="hidden" name="search" value="{{ $search }}">
                </form>
            </div>
            <div class="flex items-center">
                <form action="{{ route('accounts.index') }}" method="GET" class="flex items-center">
                    <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>
        <!-- End Fitur -->

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
                    @foreach ($accounts as $acc)
                        <tr
                            class="transition border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="px-4 py-2 text-gray-800 dark:text-gray-100">{{ $acc->code }}</td>
                            <td class="px-4 py-2 text-gray-800 dark:text-gray-100">{{ $acc->name }}</td>
                            <td class="px-4 py-2 text-gray-800 dark:text-gray-100">{{ ucfirst($acc->type) }}</td>
                            <td class="flex justify-center gap-2 px-4 py-2">
                                <!-- Edit Button -->
                                <a href="{{ route('accounts.edit', $acc->id) }}"
                                    class="px-3 py-1 text-sm font-medium text-white transition bg-yellow-500 rounded-lg shadow hover:bg-yellow-600">
                                    Edit
                                </a>
                                <!-- Delete Button -->
                                <form action="{{ route('accounts.destroy', $acc->id) }}" method="POST"
                                    onsubmit="return confirm('Delete account?')">
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
        <!-- Fitur Pagination -->
        <div class="flex items-center justify-between mt-4">
            <div>
                @if ($accounts->total() > 0)
                    <p class="text-sm text-gray-700 dark:text-white">
                        Showing {{ $accounts->firstItem() }} to {{ $accounts->lastItem() }} of {{ $accounts->total() }}
                        entries
                    </p>
                @endif
            </div>
            <div>
                @if ($accounts->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                        {{-- Previous Page Link --}}
                        @if ($accounts->onFirstPage())
                            <span
                                class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                        @else
                            <a href="{{ $accounts->previousPageUrl() }}" rel="prev"
                                class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                        @endif

                        @php
                            $currentPage = $accounts->currentPage();
                            $lastPage = $accounts->lastPage();
                            $links = [];

                            // Logic untuk menampilkan link pagination
                            if ($lastPage <= 7) {
                                for ($i = 1; $i <= $lastPage; $i++) {
                                    $links[] = $i;
                                }
                            } else {
                                $links[] = 1;
                                if ($currentPage > 4) {
                                    $links[] = '...';
                                }

                                $start = max(2, $currentPage - 1);
                                $end = min($lastPage - 1, $currentPage + 1);

                                if ($currentPage <= 4) {
                                    $start = 2;
                                    $end = 5;
                                }

                                if ($currentPage >= $lastPage - 3) {
                                    $start = $lastPage - 4;
                                    $end = $lastPage - 1;
                                }

                                for ($i = $start; $i <= $end; $i++) {
                                    $links[] = $i;
                                }

                                if ($currentPage < $lastPage - 3) {
                                    $links[] = '...';
                                }
                                $links[] = $lastPage;
                            }
                        @endphp

                        @foreach ($links as $link)
                            @if ($link === '...')
                                <span
                                    class="px-3 py-1 mr-1 text-gray-500 bg-white border rounded">{{ $link }}</span>
                            @elseif ($link == $currentPage)
                                <span
                                    class="px-3 py-1 mr-1 text-white bg-blue-500 border border-blue-500 rounded">{{ $link }}</span>
                            @else
                                <a href="{{ $accounts->url($link) }}"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($accounts->hasMorePages())
                            <a href="{{ $accounts->nextPageUrl() }}" rel="next"
                                class="px-3 py-1 ml-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Next</a>
                        @else
                            <span
                                class="px-3 py-1 ml-1 text-gray-400 bg-white border rounded cursor-not-allowed">Next</span>
                        @endif
                    </nav>
                @endif
            </div>
        </div>
        <!-- End Fitur Pagination -->
    </div>
@endsection
