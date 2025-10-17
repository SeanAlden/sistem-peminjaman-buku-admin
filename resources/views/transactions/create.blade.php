{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Transaction</h2>
    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Reference</label>
            <input type="text" name="reference" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <input type="text" name="description" class="form-control">
        </div>
        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="transaction_date" class="form-control" required>
        </div>

        <h5>Journal Entries</h5>
        <div id="journal-entries">
            <div class="mb-2 row">
                <div class="col">
                    <select name="journal[0][coa_id]" class="form-control" required>
                        <option value="">-- Select Account --</option>
                        @foreach($accounts as $acc)
                        <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <input type="number" step="0.01" name="journal[0][debit]" class="form-control" placeholder="Debit">
                </div>
                <div class="col">
                    <input type="number" step="0.01" name="journal[0][credit]" class="form-control"
                        placeholder="Credit">
                </div>
            </div>
        </div>

        <button type="button" id="add-line" class="mb-3 btn btn-secondary">+ Add Line</button>
        <br>
        <button class="btn btn-success">Save Transaction</button>
    </form>
</div>

<script>
    document.getElementById('add-line').addEventListener('click', function () {
        let count = document.querySelectorAll('#journal-entries .row').length;
        let div = document.createElement('div');
        div.classList.add('row', 'mb-2');
        div.innerHTML = `
        <div class="col">
            <select name="journal[${count}][coa_id]" class="form-control" required>
                <option value="">-- Select Account --</option>
                @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col"><input type="number" step="0.01" name="journal[${count}][debit]" class="form-control" placeholder="Debit"></div>
        <div class="col"><input type="number" step="0.01" name="journal[${count}][credit]" class="form-control" placeholder="Credit"></div>
    `;
        document.getElementById('journal-entries').appendChild(div);
    });
</script>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
<div class="container px-6 mx-auto mt-10">
    <h2 class="mb-6 text-2xl font-bold text-gray-800 dark:text-gray-100">Create Transaction</h2>

    <form action="{{ route('transactions.store') }}" method="POST"
        class="p-6 space-y-6 bg-white shadow-lg dark:bg-gray-800 rounded-xl">
        @csrf

        <!-- Reference -->
        <div>
            <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200">Reference</label>
            <input type="text" name="reference" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
        </div>

        <!-- Description -->
        <div>
            <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200">Description</label>
            <input type="text" name="description"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
        </div>

        <!-- Date -->
        <div>
            <label class="block mb-2 font-medium text-gray-700 dark:text-gray-200">Date</label>
            <input type="date" name="transaction_date" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
        </div>

        <!-- Journal Entries -->
        <div>
            <h3 class="mb-3 text-lg font-semibold text-gray-800 dark:text-gray-100">Journal Entries</h3>
            <div id="journal-entries" class="space-y-3">
                <div class="flex gap-3">
                    <!-- Account -->
                    <select name="journal[0][coa_id]" required
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="">-- Select Account --</option>
                        @foreach($accounts as $acc)
                        <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                        @endforeach
                    </select>
                    <!-- Debit -->
                    <input type="number" step="0.01" name="journal[0][debit]" placeholder="Debit"
                        class="w-32 px-3 py-2 border border-gray-300 rounded-lg shadow-sm dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                    <!-- Credit -->
                    <input type="number" step="0.01" name="journal[0][credit]" placeholder="Credit"
                        class="w-32 px-3 py-2 border border-gray-300 rounded-lg shadow-sm dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
            </div>
        </div>

        <!-- Add Line Button -->
        <button type="button" id="add-line"
            class="px-4 py-2 font-medium text-white transition bg-gray-600 rounded-lg shadow-md hover:bg-gray-700">
            + Add Line
        </button>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit"
                class="px-5 py-2 font-semibold text-white transition bg-green-600 rounded-lg shadow-md hover:bg-green-700">
                Save Transaction
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('add-line').addEventListener('click', function () {
        let count = document.querySelectorAll('#journal-entries .flex').length;
        let div = document.createElement('div');
        div.classList.add('flex', 'gap-3');
        div.innerHTML = `
        <select name="journal[${count}][coa_id]" required
            class="flex-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
            <option value="">-- Select Account --</option>
            @foreach($accounts as $acc)
                <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
            @endforeach
        </select>
        <input type="number" step="0.01" name="journal[${count}][debit]" placeholder="Debit"
            class="w-32 px-3 py-2 border border-gray-300 rounded-lg shadow-sm dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
        <input type="number" step="0.01" name="journal[${count}][credit]" placeholder="Credit"
            class="w-32 px-3 py-2 border border-gray-300 rounded-lg shadow-sm dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
    `;
        document.getElementById('journal-entries').appendChild(div);
    });
</script>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
            <strong>There were some problems with your input:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container px-6 mx-auto mt-8">
        <h2 class="mb-4 text-2xl font-semibold">Create Transaction</h2>

        <form action="{{ route('transactions.store') }}" method="POST" id="trx-form" class="p-6 bg-white rounded shadow">
            @csrf

            <div class="mb-3">
                <label class="block mb-1 font-medium">Reference</label>
                <input name="reference" required class="w-full px-3 py-2 border rounded" value="{{ old('reference') }}" />
            </div>

            <div class="mb-3">
                <label class="block mb-1 font-medium">Date</label>
                <input type="date" name="transaction_date" required class="w-full px-3 py-2 border rounded"
                    value="{{ old('transaction_date', now()->format('Y-m-d')) }}" />
            </div>

            <div class="mb-3">
                <label class="block mb-1 font-medium">Description</label>
                <input name="description" class="w-full px-3 py-2 border rounded" value="{{ old('description') }}" />
            </div>

            <h3 class="mb-2 font-semibold">Journal Entries</h3>

            <div id="journal-entries" class="space-y-2">
                <div class="flex items-center gap-2 journal-line">
                    <select name="journal[0][coa_id]" required class="flex-1 px-3 py-2 border rounded">
                        <option value="">-- Select Account --</option>
                        @foreach($accounts as $acc)
                            <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                        @endforeach
                    </select>
                    <input type="number" step="0.01" name="journal[0][debit]" placeholder="Debit"
                        class="px-2 py-2 border rounded w-36 debit-input" />
                    <input type="number" step="0.01" name="journal[0][credit]" placeholder="Credit"
                        class="px-2 py-2 border rounded w-36 credit-input" />
                    <button type="button" class="text-red-600 remove-line">✕</button>
                </div>

                <div class="flex items-center gap-2 journal-line">
                    <select name="journal[1][coa_id]" required class="flex-1 px-3 py-2 border rounded">
                        <option value="">-- Select Account --</option>
                        @foreach($accounts as $acc)
                            <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                        @endforeach
                    </select>
                    <input type="number" step="0.01" name="journal[1][debit]" placeholder="Debit"
                        class="px-2 py-2 border rounded w-36 debit-input" />
                    <input type="number" step="0.01" name="journal[1][credit]" placeholder="Credit"
                        class="px-2 py-2 border rounded w-36 credit-input" />
                    <button type="button" class="text-red-600 remove-line">✕</button>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" id="add-line" class="px-3 py-2 text-white bg-gray-700 rounded">+ Add Line</button>
            </div>

            <div class="flex items-center gap-6 mt-4">
                <div>Total Debit: <span id="total-debit">0.00</span></div>
                <div>Total Credit: <span id="total-credit">0.00</span></div>
                <div id="balance-badge" class="px-3 py-1 text-white bg-red-500 rounded">Unbalanced</div>
            </div>

            <div class="mt-4">
                <button id="submit-btn" type="submit" class="px-4 py-2 text-white bg-green-600 rounded" disabled>Save
                    Transaction</button>
            </div>
        </form>
    </div>

    <template id="journal-line-template">
        <div class="flex items-center gap-2 journal-line">
            <select name="__COA__" required class="flex-1 px-3 py-2 border rounded">
                <option value="">-- Select Account --</option>
                @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                @endforeach
            </select>
            <input type="number" step="0.01" name="__DEBIT__" placeholder="Debit"
                class="px-2 py-2 border rounded w-36 debit-input" />
            <input type="number" step="0.01" name="__CREDIT__" placeholder="Credit"
                class="px-2 py-2 border rounded w-36 credit-input" />
            <button type="button" class="text-red-600 remove-line">✕</button>
        </div>
    </template>

    <script>
        (function () {
            const container = document.getElementById('journal-entries');
            const template = document.getElementById('journal-line-template').innerHTML;
            const addBtn = document.getElementById('add-line');
            const totalDebitEl = document.getElementById('total-debit');
            const totalCreditEl = document.getElementById('total-credit');
            const badge = document.getElementById('balance-badge');
            const submitBtn = document.getElementById('submit-btn');

            function updateTotals() {
                let deb = 0, cred = 0;
                container.querySelectorAll('.journal-line').forEach(line => {
                    const d = parseFloat((line.querySelector('.debit-input')?.value || 0)) || 0;
                    const c = parseFloat((line.querySelector('.credit-input')?.value || 0)) || 0;
                    deb += d;
                    cred += c;
                });
                totalDebitEl.textContent = deb.toFixed(2);
                totalCreditEl.textContent = cred.toFixed(2);
                if (Math.abs(deb - cred) < 0.001 && deb > 0) {
                    badge.textContent = 'Balanced';
                    badge.classList.remove('bg-red-500');
                    badge.classList.add('bg-green-600');
                    submitBtn.disabled = false;
                } else {
                    badge.textContent = 'Unbalanced';
                    badge.classList.remove('bg-green-600');
                    badge.classList.add('bg-red-500');
                    submitBtn.disabled = true;
                }
            }

            function reindexNames() {
                container.querySelectorAll('.journal-line').forEach((line, idx) => {
                    const select = line.querySelector('select');
                    select.name = `journal[${idx}][coa_id]`;
                    const debit = line.querySelector('.debit-input');
                    debit.name = `journal[${idx}][debit]`;
                    const credit = line.querySelector('.credit-input');
                    credit.name = `journal[${idx}][credit]`;
                });
            }

            addBtn.addEventListener('click', function () {
                const idx = container.querySelectorAll('.journal-line').length;
                let html = template.replace(/__COA__/g, `journal[${idx}][coa_id]`)
                    .replace(/__DEBIT__/g, `journal[${idx}][debit]`)
                    .replace(/__CREDIT__/g, `journal[${idx}][credit]`);
                const div = document.createElement('div');
                div.innerHTML = html;
                container.appendChild(div.firstElementChild);
                bindLineEvents();
                reindexNames();
            });

            function bindLineEvents() {
                container.querySelectorAll('.journal-line').forEach(line => {
                    const d = line.querySelector('.debit-input');
                    const c = line.querySelector('.credit-input');
                    const remove = line.querySelector('.remove-line');

                    [d, c].forEach(inp => {
                        if (!inp) return;
                        inp.removeEventListener('input', updateTotals);
                        inp.addEventListener('input', updateTotals);
                    });

                    if (remove) {
                        remove.removeEventListener('click', onRemoveLine);
                        remove.addEventListener('click', onRemoveLine);
                    }
                });
                updateTotals();
            }

            function onRemoveLine(e) {
                const line = e.target.closest('.journal-line');
                if (!line) return;
                line.remove();
                reindexNames();
                bindLineEvents();
            }

            // initial bind
            bindLineEvents();
        })();
    </script>
@endsection --}}

@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900 dark:text-red-200">
            <strong>There were some problems with your input:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container px-6 mx-auto mt-8">
        <h2 class="mb-4 text-2xl font-semibold dark:text-gray-100">Create Transaction</h2>

        <form action="{{ route('transactions.store') }}" method="POST" id="trx-form"
              class="p-6 bg-white rounded shadow dark:bg-gray-900 dark:text-gray-100">
            @csrf

            <div class="mb-3">
                <label class="block mb-1 font-medium dark:text-gray-200">Reference</label>
                <input name="reference" required
                       class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('reference') }}" />
            </div>

            <div class="mb-3">
                <label class="block mb-1 font-medium dark:text-gray-200">Date</label>
                <input type="date" name="transaction_date" required
                       class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 dark:[color-scheme:dark] dark:invert-[0.9] focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('transaction_date', now()->format('Y-m-d')) }}" />
            </div>

            <div class="mb-3">
                <label class="block mb-1 font-medium dark:text-gray-200">Description</label>
                <input name="description"
                       class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('description') }}" />
            </div>

            <h3 class="mb-2 font-semibold dark:text-gray-100">Journal Entries</h3>

            <div id="journal-entries" class="space-y-2">
                <div class="flex items-center gap-2 journal-line">
                    <select name="journal[0][coa_id]" required
                            class="flex-1 px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                        <option value="">-- Select Account --</option>
                        @foreach($accounts as $acc)
                            <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                        @endforeach
                    </select>
                    <input type="number" step="0.01" name="journal[0][debit]" placeholder="Debit"
                           class="px-2 py-2 border rounded w-36 debit-input dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100" />
                    <input type="number" step="0.01" name="journal[0][credit]" placeholder="Credit"
                           class="px-2 py-2 border rounded w-36 credit-input dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100" />
                    <button type="button" class="text-red-600 remove-line dark:text-red-400">✕</button>
                </div>

                <div class="flex items-center gap-2 journal-line">
                    <select name="journal[1][coa_id]" required
                            class="flex-1 px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                        <option value="">-- Select Account --</option>
                        @foreach($accounts as $acc)
                            <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                        @endforeach
                    </select>
                    <input type="number" step="0.01" name="journal[1][debit]" placeholder="Debit"
                           class="px-2 py-2 border rounded w-36 debit-input dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100" />
                    <input type="number" step="0.01" name="journal[1][credit]" placeholder="Credit"
                           class="px-2 py-2 border rounded w-36 credit-input dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100" />
                    <button type="button" class="text-red-600 remove-line dark:text-red-400">✕</button>
                </div>
            </div>

            <div class="mt-3">
                <button type="button" id="add-line"
                        class="px-3 py-2 text-white bg-gray-700 rounded hover:bg-gray-800 dark:bg-gray-600 dark:hover:bg-gray-700">
                    + Add Line
                </button>
            </div>

            <div class="flex items-center gap-6 mt-4 dark:text-gray-200">
                <div>Total Debit: <span id="total-debit">0.00</span></div>
                <div>Total Credit: <span id="total-credit">0.00</span></div>
                <div id="balance-badge" class="px-3 py-1 text-white bg-red-500 rounded dark:bg-red-600">Unbalanced</div>
            </div>

            <div class="mt-4">
                <button id="submit-btn" type="submit"
                        class="px-4 py-2 text-white transition bg-green-600 rounded hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600"
                        disabled>
                    Save Transaction
                </button>
            </div>
        </form>
    </div>

    <template id="journal-line-template">
        <div class="flex items-center gap-2 journal-line">
            <select name="__COA__" required
                    class="flex-1 px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                <option value="">-- Select Account --</option>
                @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }}</option>
                @endforeach
            </select>
            <input type="number" step="0.01" name="__DEBIT__" placeholder="Debit"
                   class="px-2 py-2 border rounded w-36 debit-input dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100" />
            <input type="number" step="0.01" name="__CREDIT__" placeholder="Credit"
                   class="px-2 py-2 border rounded w-36 credit-input dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100" />
            <button type="button" class="text-red-600 remove-line dark:text-red-400">✕</button>
        </div>
    </template>

    {{-- JS tidak diubah --}}
    <script>
        (function () {
            const container = document.getElementById('journal-entries');
            const template = document.getElementById('journal-line-template').innerHTML;
            const addBtn = document.getElementById('add-line');
            const totalDebitEl = document.getElementById('total-debit');
            const totalCreditEl = document.getElementById('total-credit');
            const badge = document.getElementById('balance-badge');
            const submitBtn = document.getElementById('submit-btn');

            function updateTotals() {
                let deb = 0, cred = 0;
                container.querySelectorAll('.journal-line').forEach(line => {
                    const d = parseFloat((line.querySelector('.debit-input')?.value || 0)) || 0;
                    const c = parseFloat((line.querySelector('.credit-input')?.value || 0)) || 0;
                    deb += d;
                    cred += c;
                });
                totalDebitEl.textContent = deb.toFixed(2);
                totalCreditEl.textContent = cred.toFixed(2);
                if (Math.abs(deb - cred) < 0.001 && deb > 0) {
                    badge.textContent = 'Balanced';
                    badge.classList.remove('bg-red-500', 'dark:bg-red-600');
                    badge.classList.add('bg-green-600', 'dark:bg-green-500');
                    submitBtn.disabled = false;
                } else {
                    badge.textContent = 'Unbalanced';
                    badge.classList.remove('bg-green-600', 'dark:bg-green-500');
                    badge.classList.add('bg-red-500', 'dark:bg-red-600');
                    submitBtn.disabled = true;
                }
            }

            function reindexNames() {
                container.querySelectorAll('.journal-line').forEach((line, idx) => {
                    const select = line.querySelector('select');
                    select.name = `journal[${idx}][coa_id]`;
                    const debit = line.querySelector('.debit-input');
                    debit.name = `journal[${idx}][debit]`;
                    const credit = line.querySelector('.credit-input');
                    credit.name = `journal[${idx}][credit]`;
                });
            }

            addBtn.addEventListener('click', function () {
                const idx = container.querySelectorAll('.journal-line').length;
                let html = template.replace(/__COA__/g, `journal[${idx}][coa_id]`)
                    .replace(/__DEBIT__/g, `journal[${idx}][debit]`)
                    .replace(/__CREDIT__/g, `journal[${idx}][credit]`);
                const div = document.createElement('div');
                div.innerHTML = html;
                container.appendChild(div.firstElementChild);
                bindLineEvents();
                reindexNames();
            });

            function bindLineEvents() {
                container.querySelectorAll('.journal-line').forEach(line => {
                    const d = line.querySelector('.debit-input');
                    const c = line.querySelector('.credit-input');
                    const remove = line.querySelector('.remove-line');

                    [d, c].forEach(inp => {
                        if (!inp) return;
                        inp.removeEventListener('input', updateTotals);
                        inp.addEventListener('input', updateTotals);
                    });

                    if (remove) {
                        remove.removeEventListener('click', onRemoveLine);
                        remove.addEventListener('click', onRemoveLine);
                    }
                });
                updateTotals();
            }

            function onRemoveLine(e) {
                const line = e.target.closest('.journal-line');
                if (!line) return;
                line.remove();
                reindexNames();
                bindLineEvents();
            }

            bindLineEvents();
        })();
    </script>
@endsection
