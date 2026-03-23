{{-- @extends('layouts.app')

@section('content')
    <div class="min-h-screen px-4 py-8 transition-colors duration-300 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-6xl p-6 mx-auto transition-colors duration-300 bg-white shadow-lg dark:bg-gray-800 rounded-2xl">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Payroll List</h2>
                <a href="{{ route('payrolls.create') }}"
                    class="px-4 py-2 text-white transition duration-200 bg-indigo-600 rounded-lg shadow hover:bg-indigo-700">
                    + Add Payroll
                </a>
            </div>

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
                    <form action="{{ route('payrolls.index') }}" method="GET" class="flex items-center">
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
                    <form action="{{ route('payrolls.index') }}" method="GET" class="flex items-center">
                        <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                        <input type="text" name="search" id="search"
                            class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ $search }}" placeholder="Search...">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">
                    </form>
                </div>
            </div>
            <!-- End Fitur -->

            <div class="overflow-x-auto">
                <table class="w-full overflow-hidden border-collapse rounded-lg">
                    <thead>
                        <tr class="text-white bg-indigo-600">
                            <th class="px-4 py-3 text-sm font-semibold text-left">ID</th>
                            <th class="px-4 py-3 text-sm font-semibold text-left">Employee</th>
                            <th class="px-4 py-3 text-sm font-semibold text-left">Basic Salary</th>
                            <th class="px-4 py-3 text-sm font-semibold text-left">Bonus</th>
                            <th class="px-4 py-3 text-sm font-semibold text-left">Deduction</th>
                            <th class="px-4 py-3 text-sm font-semibold text-left">Net Salary</th>
                            <th class="px-4 py-3 text-sm font-semibold text-left">Date</th>
                            <th class="px-4 py-3 text-sm font-semibold text-center">Status</th>
                            <th class="px-4 py-3 text-sm font-semibold text-center">Toggle</th>
                            <th class="px-4 py-3 text-sm font-semibold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($payrolls as $p)
                            <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $p->id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $p->employee->name }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ number_format($p->basic_salary, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ number_format($p->bonus ?? 0, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ number_format($p->deduction ?? 0, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 font-semibold text-green-600 dark:text-green-400">
                                    {{ number_format($p->net_salary, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $p->payment_date }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if ($p->status === 'paid')
                                        <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">
                                            PAID
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold text-gray-700 bg-gray-200 rounded">
                                            DRAFT
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-center">
                                    @if ($p->status === 'draft')
                                        <form action="{{ route('payrolls.markPaid', $p->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                class="px-3 py-1 text-xs font-semibold text-white bg-green-600 rounded hover:bg-green-700">
                                                Paid
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('payrolls.markDraft', $p->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                class="px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-300 rounded hover:bg-gray-400">
                                                Draft
                                            </button>
                                        </form>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('payrolls.show', $p->id) }}"
                                            class="px-3 py-1 text-xs font-medium text-white transition bg-blue-500 rounded hover:bg-blue-600">
                                            Detail
                                        </a>
                                        @if ($p->status === 'paid')
                                            <button
                                                class="px-3 py-1 text-xs font-medium text-gray-400 bg-gray-200 rounded cursor-not-allowed">
                                                Edit
                                            </button>
                                            <button
                                                class="px-3 py-1 text-xs font-medium text-gray-400 bg-gray-200 rounded cursor-not-allowed">
                                                Del
                                            </button>
                                        @else
                                            <a href="{{ route('payrolls.edit', $p->id) }}"
                                                class="px-3 py-1 text-xs font-medium text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                                Edit
                                            </a>
                                            <form action="{{ route('payrolls.destroy', $p->id) }}" method="POST"
                                                onsubmit="return confirm('Delete payroll?')">
                                                @csrf @method('DELETE')
                                                <button
                                                    class="px-3 py-1 text-xs font-medium text-white bg-red-500 rounded hover:bg-red-600">
                                                    Del
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Fitur Pagination -->
            <div class="flex items-center justify-between mt-4">
                <div>
                    @if ($payrolls->total() > 0)
                        <p class="text-sm text-gray-700 dark:text-white">
                            Showing {{ $payrolls->firstItem() }} to {{ $payrolls->lastItem() }} of
                            {{ $payrolls->total() }}
                            entries
                        </p>
                    @endif
                </div>
                <div>
                    @if ($payrolls->hasPages())
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                            @if ($payrolls->onFirstPage())
                                <span
                                    class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                            @else
                                <a href="{{ $payrolls->previousPageUrl() }}" rel="prev"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                            @endif

                            @php
                                $currentPage = $payrolls->currentPage();
                                $lastPage = $payrolls->lastPage();
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
                                    <a href="{{ $payrolls->url($link) }}"
                                        class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                                @endif
                            @endforeach

                            @if ($payrolls->hasMorePages())
                                <a href="{{ $payrolls->nextPageUrl() }}" rel="next"
                                    class="px-3 py-1 ml-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Next</a>
                            @else
                                <span
                                    class="px-3 py-1 ml-1 text-gray-400 bg-white border rounded cursor-not-allowed">Next</span>
                            @endif
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="min-h-screen px-4 py-8 transition-colors duration-300 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-6xl p-6 mx-auto transition-colors duration-300 bg-white shadow-lg dark:bg-gray-800 rounded-2xl">

            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Payroll List</h2>
                <a href="{{ route('payrolls.create') }}"
                    class="px-4 py-2 text-white transition duration-200 bg-indigo-600 rounded-lg shadow hover:bg-indigo-700">
                    + Add Payroll
                </a>
            </div>

            @if (session('success'))
                <div id="success-alert"
                    class="px-4 py-3 mb-6 text-green-700 transition-opacity duration-500 bg-green-100 border border-green-400 rounded"
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
                    class="px-4 py-3 mb-6 text-red-700 transition-opacity duration-500 bg-red-100 border border-red-400 rounded"
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

            <div class="flex flex-col items-center justify-between gap-4 mb-4 sm:flex-row">
                <div class="flex items-center w-full sm:w-auto">
                    <label for="per_page" class="mr-2 text-sm text-gray-600 dark:text-white">Show:</label>
                    <select id="per_page" onchange="fetchData()"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:w-auto">
                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
                <div class="flex items-center w-full sm:w-auto">
                    <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                    <input type="text" id="search" oninput="handleSearch()"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:w-64"
                        value="{{ $search }}" placeholder="Search employee...">
                </div>
            </div>
            <div id="dynamic-content">
                <div class="overflow-x-auto">
                    <table class="w-full overflow-hidden border-collapse rounded-lg shadow-sm">
                        <thead>
                            <tr class="text-white bg-indigo-600">
                                <th class="px-4 py-3 text-sm font-semibold text-left">ID</th>
                                <th class="px-4 py-3 text-sm font-semibold text-left">Employee</th>
                                <th class="px-4 py-3 text-sm font-semibold text-left">Basic Salary</th>
                                <th class="px-4 py-3 text-sm font-semibold text-left">Bonus</th>
                                <th class="px-4 py-3 text-sm font-semibold text-left">Deduction</th>
                                <th class="px-4 py-3 text-sm font-semibold text-left">Net Salary</th>
                                <th class="px-4 py-3 text-sm font-semibold text-left">Date</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center">Status</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center">Toggle</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($payrolls as $p)
                                <tr class="transition-colors bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $p->id }}</td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $p->employee->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ number_format($p->basic_salary, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ number_format($p->bonus ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-sm text-red-500 dark:text-red-400">{{ number_format($p->deduction ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 font-semibold text-green-600 dark:text-green-400">{{ number_format($p->net_salary, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $p->payment_date }}</td>

                                    {{-- STATUS --}}
                                    <td class="px-4 py-3 text-center">
                                        @if ($p->status === 'paid')
                                            <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">PAID</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold text-gray-700 bg-gray-200 rounded">DRAFT</span>
                                        @endif
                                    </td>

                                    {{-- TOGGLE BUTTON --}}
                                    <td class="px-4 py-3 text-center">
                                        @if ($p->status === 'draft')
                                            <form action="{{ route('payrolls.markPaid', $p->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="px-3 py-1 text-xs font-semibold text-white transition bg-green-600 rounded hover:bg-green-700 shadow-sm">Paid</button>
                                            </form>
                                        @else
                                            <form action="{{ route('payrolls.markDraft', $p->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="px-3 py-1 text-xs font-semibold text-gray-600 transition bg-gray-300 rounded hover:bg-gray-400 shadow-sm">Draft</button>
                                            </form>
                                        @endif
                                    </td>

                                    {{-- ACTIONS --}}
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('payrolls.show', $p->id) }}"
                                                class="px-3 py-1 text-xs font-medium text-white transition bg-blue-500 rounded hover:bg-blue-600 shadow-sm">
                                                Detail
                                            </a>

                                            @if ($p->status === 'paid')
                                                <button class="px-3 py-1 text-xs font-medium text-gray-400 bg-gray-200 rounded cursor-not-allowed dark:bg-gray-700 dark:text-gray-500">Edit</button>
                                                <button class="px-3 py-1 text-xs font-medium text-gray-400 bg-gray-200 rounded cursor-not-allowed dark:bg-gray-700 dark:text-gray-500">Del</button>
                                            @else
                                                <a href="{{ route('payrolls.edit', $p->id) }}"
                                                    class="px-3 py-1 text-xs font-medium text-white transition bg-yellow-500 rounded hover:bg-yellow-600 shadow-sm">
                                                    Edit
                                                </a>
                                                <button type="button" onclick="openDeleteModal({{ $p->id }})"
                                                    class="px-3 py-1 text-xs font-medium text-white transition bg-red-500 rounded hover:bg-red-600 shadow-sm">
                                                    Del
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada data penggajian.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div id="pagination-links" class="flex flex-col items-center justify-between mt-6 sm:flex-row">
                    <div class="mb-4 sm:mb-0">
                        @if ($payrolls->total() > 0)
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                Showing {{ $payrolls->firstItem() }} to {{ $payrolls->lastItem() }} of {{ $payrolls->total() }} entries
                            </p>
                        @endif
                    </div>
                    <div>
                        @if ($payrolls->hasPages())
                            <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                                @if ($payrolls->onFirstPage())
                                    <span class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed dark:bg-gray-700 dark:border-gray-600">Prev</span>
                                @else
                                    <a href="{{ $payrolls->previousPageUrl() }}" rel="prev" class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">Prev</a>
                                @endif

                                @php
                                    $currentPage = $payrolls->currentPage();
                                    $lastPage = $payrolls->lastPage();
                                    $start = max(1, $currentPage - 2);
                                    $end = min($lastPage, $currentPage + 2);
                                @endphp

                                @for ($i = $start; $i <= $end; $i++)
                                    @if ($i == $currentPage)
                                        <span class="px-3 py-1 mr-1 text-white bg-indigo-600 border border-indigo-600 rounded">{{ $i }}</span>
                                    @else
                                        <a href="{{ $payrolls->url($i) }}" class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">{{ $i }}</a>
                                    @endif
                                @endfor

                                @if ($payrolls->hasMorePages())
                                    <a href="{{ $payrolls->nextPageUrl() }}" rel="next" class="px-3 py-1 ml-1 text-gray-700 bg-white border rounded hover:bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">Next</a>
                                @else
                                    <span class="px-3 py-1 ml-1 text-gray-400 bg-white border rounded cursor-not-allowed dark:bg-gray-700 dark:border-gray-600">Next</span>
                                @endif
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
            </div>
    </div>

    <form id="globalDeleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('scripts')
    <script>
        // =========================================================
        // 1. ENGINE SPA (PREFETCH, CACHE, & REAL-TIME SEARCH)
        // =========================================================
        const pageCache = {};
        let currentAbortController = null;
        let debounceTimer;

        // Fungsi Debounce agar search terasa ringan
        function handleSearch() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetchData();
            }, 100); // 100ms delay untuk real-time murni
        }

        function fetchData(targetUrl = null) {
            if (typeof targetUrl !== 'string') targetUrl = null;

            const search = document.getElementById('search').value;
            const perPage = document.getElementById('per_page').value;

            let urlString = targetUrl || `{{ route('payrolls.index') }}`;
            const urlObj = new URL(urlString, window.location.origin);

            // Fix Vercel HTTPS Protocol
            if (window.location.protocol === 'https:') {
                urlObj.protocol = 'https:';
            }

            urlObj.searchParams.set('search', search);
            urlObj.searchParams.set('per_page', perPage);

            const finalUrl = urlObj.toString();

            // Sihir Cache 0ms
            if (pageCache[finalUrl]) {
                renderDOM(pageCache[finalUrl]);
                window.history.pushState({ path: finalUrl }, '', finalUrl);
                return;
            }

            if (currentAbortController) {
                currentAbortController.abort();
            }
            currentAbortController = new AbortController();

            document.getElementById('dynamic-content').style.opacity = '0.5';

            fetch(finalUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                signal: currentAbortController.signal
            })
            .then(response => {
                if (!response.ok) throw new Error("Gagal memuat server");
                return response.text();
            })
            .then(html => {
                pageCache[finalUrl] = html;
                renderDOM(html);
                window.history.pushState({ path: finalUrl }, '', finalUrl);
            })
            .catch(error => {
                if (error.name !== 'AbortError') {
                    console.error('Fetch Error:', error);
                    document.getElementById('dynamic-content').style.opacity = '1';
                }
            });
        }

        function renderDOM(html) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const dynamicElement = doc.getElementById('dynamic-content');

            if (dynamicElement) {
                document.getElementById('dynamic-content').innerHTML = dynamicElement.innerHTML;
            }
            document.getElementById('dynamic-content').style.opacity = '1';
        }

        // INTENT PREDICTION
        document.addEventListener('mouseover', function (e) {
            const link = e.target.closest('#pagination-links a');
            if (link) {
                const hoverUrlObj = new URL(link.href, window.location.origin);
                if (window.location.protocol === 'https:') hoverUrlObj.protocol = 'https:';
                const safeHoverUrl = hoverUrlObj.toString();

                if (!pageCache[safeHoverUrl]) {
                    fetch(safeHoverUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(res => res.text())
                        .then(html => pageCache[safeHoverUrl] = html)
                        .catch(() => { });
                }
            }
        });

        // EVENT DELEGATION UNTUK PAGINASI
        document.addEventListener('click', function(e) {
            const link = e.target.closest('#pagination-links a');
            if (link) {
                e.preventDefault();
                fetchData(link.href);
            }
        });

        // SPA Navigation Back/Forward
        window.addEventListener('popstate', function(e) {
            if (e.state && e.state.path) {
                fetchData(e.state.path);
            } else {
                fetchData(window.location.href);
            }
        });


        // =========================================================
        // 2. SWEETALERT LOGIC (Hanya untuk Delete)
        // =========================================================
        const isDark = () => document.documentElement.classList.contains('dark');
        const swalBg = () => isDark() ? '#1f2937' : '#ffffff';
        const swalText = () => isDark() ? '#ffffff' : '#374151';

        function openDeleteModal(payrollId) {
            Swal.fire({
                title: 'Hapus Data Penggajian?',
                text: "Apakah Anda yakin ingin menghapus data payroll ini? Tindakan ini tidak dapat dibatalkan.",
                icon: 'warning',
                background: swalBg(),
                color: swalText(),
                showCancelButton: true,
                confirmButtonColor: '#dc2626', // Red-600
                cancelButtonColor: '#6b7280',  // Gray-500
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('globalDeleteForm');
                    // Arahkan action URL ke route destroy
                    form.action = `/admin/payrolls/${payrollId}`;
                    form.submit();
                }
            });
        }
    </script>
@endsection
