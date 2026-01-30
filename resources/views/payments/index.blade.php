{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Payments</h2>
    <a href="{{ route('payments.create') }}" class="mb-3 btn btn-primary">+ Add Payment</a>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee</th>
                <th>Supplier</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Method</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->employee?->name }}</td>
                <td>{{ $p->supplier?->name }}</td>
                <td>{{ $p->amount }}</td>
                <td>{{ $p->payment_date }}</td>
                <td>{{ ucfirst($p->method) }}</td>
                <td>
                    <form action="{{ route('payments.destroy',$p->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Delete payment?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
<div class="container px-6 py-8 mx-auto">
    <h2 class="mb-6 text-2xl font-bold text-gray-800">Payments</h2>

    <a href="{{ route('payments.create') }}"
        class="inline-block px-4 py-2 mb-4 text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700">
        + Add Payment
    </a>

    @if (session('success'))
    <div class="px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
        {{ session('success') }}
    </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full border border-gray-200">
            <thead class="text-white bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Employee</th>
                    <th class="px-4 py-2 text-left">Supplier</th>
                    <th class="px-4 py-2 text-left">Amount</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Method</th>
                    <th class="px-4 py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($payments as $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $p->id }}</td>
                    <td class="px-4 py-2">{{ $p->employee?->name }}</td>
                    <td class="px-4 py-2">{{ $p->supplier?->name }}</td>
                    <td class="px-4 py-2">{{ number_format($p->amount, 2) }}</td>
                    <td class="px-4 py-2">{{ $p->payment_date }}</td>
                    <td class="px-4 py-2">{{ ucfirst($p->method) }}</td>
                    <td class="px-4 py-2">
                        <form action="{{ route('payments.destroy',$p->id) }}" method="POST"
                            onsubmit="return confirm('Delete payment?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach

                @if ($payments->isEmpty())
                <tr>
                    <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                        No payments found.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4 text-xl font-bold text-gray-800 dark:text-gray-200">Payments</h2>

        {{-- <a href="{{ route('payments.create') }}"
            class="inline-block px-4 py-2 mb-3 text-white bg-blue-600 rounded-md hover:bg-blue-700">
            + New Payment
        </a> --}}

        <button onclick="openCreateModal()"
            class="inline-block px-4 py-2 mb-3 text-white bg-blue-600 rounded-md hover:bg-blue-700">
            + New Payment
        </button>

        {{-- @if (session('success'))
            <div class="p-3 mb-4 text-green-800 bg-green-100 rounded">{{ session('success') }}</div>
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
                <form action="{{ route('payments.index') }}" method="GET" class="flex items-center">
                    <label for="per_page" class="mr-2 text-sm text-gray-600 dark:text-white">Show:</label>
                    <select name="per_page" id="per_page"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
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
                <form action="{{ route('payments.index') }}" method="GET" class="flex items-center">
                    <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>

        <table class="w-full border dark:border-white">
            <thead>
                <tr class="text-left bg-gray-200">
                    <th class="px-3 py-2">ID</th>
                    <th class="px-3 py-2">Employee</th>
                    <th class="px-3 py-2">Supplier</th>
                    <th class="px-3 py-2">Amount</th>
                    <th class="px-3 py-2">Date</th>
                    <th class="px-3 py-2">Method</th>
                    <th class="px-3 py-2">Notes</th>
                    <th class="px-3 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $pay)
                    <tr class="bg-gray-200 border-t dark:bg-gray-700">
                        <td class="px-3 py-2 text-gray-900 dark:text-gray-100">{{ $pay->id }}</td>
                        <td class="px-3 py-2 text-gray-900 dark:text-gray-100">{{ $pay->employee?->name ?? '-' }}</td>
                        <td class="px-3 py-2 text-gray-900 dark:text-gray-100">{{ $pay->supplier?->name ?? '-' }}</td>
                        <td class="px-3 py-2 text-gray-900 dark:text-gray-100">{{ number_format($pay->amount, 2) }}</td>
                        <td class="px-3 py-2 text-gray-900 dark:text-gray-100">{{ $pay->payment_date }}</td>
                        <td class="px-3 py-2 text-gray-900 dark:text-gray-100">{{ ucfirst($pay->method) }}</td>
                        <td class="px-3 py-2 text-gray-900 dark:text-gray-100">{{ $pay->notes ?? '-' }}</td>
                        <td class="px-3 py-2">
                            {{-- <a href="{{ route('payments.edit', $pay) }}"
                                class="px-2 py-1 text-white bg-yellow-500 rounded">Edit</a> --}}
                            <button type="button" onclick='openEditModal(@json($pay))'
                                class="px-2 py-1 text-white bg-yellow-500 rounded">
                                Edit
                            </button>
                            <form action="{{ route('payments.destroy', $pay) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete this payment?')">
                                @csrf @method('DELETE')
                                <button class="px-2 py-1 text-white bg-red-600 rounded">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-4 text-center">No payments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Fitur Pagination -->
    <div class="flex items-center justify-between mt-4">
        <div>
            @if ($payments->total() > 0)
                <p class="text-sm text-gray-700 dark:text-white">
                    Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }}
                    entries
                </p>
            @endif
        </div>
        <div>
            @if ($payments->hasPages())
                <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                    @if ($payments->onFirstPage())
                        <span class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                    @else
                        <a href="{{ $payments->previousPageUrl() }}" rel="prev"
                            class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                    @endif

                    @php
                        $currentPage = $payments->currentPage();
                        $lastPage = $payments->lastPage();
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
                            <span class="px-3 py-1 mr-1 text-gray-500 bg-white border rounded">
                                {{ $link }}
                            </span>
                        @elseif ($link == $currentPage)
                            <span
                                class="px-3 py-1 mr-1 text-white bg-blue-500 border border-blue-500 rounded">{{ $link }}</span>
                        @else
                            <a href="{{ $payments->url($link) }}"
                                class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                        @endif
                    @endforeach

                    @if ($payments->hasMorePages())
                        <a href="{{ $payments->nextPageUrl() }}" rel="next"
                            class="px-3 py-1 ml-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Next</a>
                    @else
                        <span class="px-3 py-1 ml-1 text-gray-400 bg-white border rounded cursor-not-allowed">Next</span>
                    @endif
                </nav>
            @endif
        </div>
    </div>
    <!-- End Fitur Pagination -->

    <!-- Modal Background -->
    <div id="paymentModal" class="fixed inset-0 z-50 flex items-center justify-center hidden backdrop-blur-sm"
        style="background-color: rgba(0, 0, 0, 0.5);">

        <!-- Modal Box -->
        <div class="w-full max-w-lg p-5 bg-white rounded shadow-lg dark:bg-gray-900 dark:text-gray-100">

            <h2 id="modalTitle" class="mb-4 text-xl font-bold">Create Payment</h2>

            <form id="paymentForm" method="POST" class="space-y-3">
                @csrf

                <!-- Tempat inject PUT ketika edit -->
                <div id="methodField"></div>

                <div>
                    <label class="block dark:text-gray-200">Employee</label>
                    <select id="employee_id" name="employee_id"
                        class="w-full px-2 py-1 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                        <option value="">-- Optional --</option>
                        @foreach ($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block dark:text-gray-200">Supplier</label>
                    <select id="supplier_id" name="supplier_id"
                        class="w-full px-2 py-1 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                        <option value="">-- Optional --</option>
                        @foreach ($suppliers as $sup)
                            <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block dark:text-gray-200">Amount</label>
                    <input id="amount" type="number" step="0.01" name="amount"
                        class="w-full px-2 py-1 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                </div>

                <div>
                    <label class="block dark:text-gray-200">Payment Date</label>
                    <input id="payment_date" type="date" name="payment_date"
                        class="w-full px-2 py-1 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:[color-scheme:dark] dark:invert-[0.9]">
                </div>

                <div>
                    <label class="block dark:text-gray-200">Method</label>
                    <select id="method" name="method"
                        class="w-full px-2 py-1 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <label class="block dark:text-gray-200">Notes</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="w-full px-2 py-1 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100"></textarea>
                </div>

                <div class="flex justify-end mt-4 space-x-2">
                    <button type="button" onclick="closePaymentModal()"
                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                        Cancel
                    </button>

                    <button id="submitBtn" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                        Save
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function openCreateModal() {
            document.getElementById('modalTitle').innerText = "Create Payment";
            document.getElementById('submitBtn').innerText = "Save";

            document.getElementById('paymentForm').action = "{{ route('payments.store') }}";
            document.getElementById('methodField').innerHTML = "";

            // Clear fields
            document.getElementById('employee_id').value = "";
            document.getElementById('supplier_id').value = "";
            document.getElementById('amount').value = "";
            document.getElementById('payment_date').value = "";
            document.getElementById('method').value = "cash";
            document.getElementById('notes').value = "";

            document.getElementById('paymentModal').classList.remove('hidden');
        }

        function openEditModal(payment) {
            document.getElementById('modalTitle').innerText = "Edit Payment #" + payment.id;
            document.getElementById('submitBtn').innerText = "Update";

            document.getElementById('paymentForm').action = "/payments/" + payment.id;

            document.getElementById('methodField').innerHTML = `
                        @method('PUT')
                    `;

            // Fill form
            document.getElementById('employee_id').value = payment.employee_id ?? "";
            document.getElementById('supplier_id').value = payment.supplier_id ?? "";
            document.getElementById('amount').value = payment.amount;
            document.getElementById('payment_date').value = payment.payment_date;
            document.getElementById('method').value = payment.method;
            document.getElementById('notes').value = payment.notes ?? "";

            document.getElementById('paymentModal').classList.remove('hidden');
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }
    </script>
@endsection
