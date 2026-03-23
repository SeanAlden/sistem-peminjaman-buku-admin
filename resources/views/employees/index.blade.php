{{-- @extends('layouts.app')

@section('content')
<h2 class="mb-3">Employee List</h2>
<a href="{{ route('employees.create') }}" class="mb-3 btn btn-primary">+ Add Employee</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Position</th>
            <th>Base Salary</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $emp)
        <tr>
            <td>{{ $emp->id }}</td>
            <td>{{ $emp->name }}</td>
            <td>{{ $emp->position }}</td>
            <td>{{ number_format($emp->base_salary,0,',','.') }}</td>
            <td>{{ $emp->email }}</td>
            <td>
                <a href="{{ route('employees.show',$emp->id) }}" class="btn btn-info btn-sm">Detail</a>
                <a href="{{ route('employees.edit',$emp->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('employees.destroy',$emp->id) }}" method="POST" style="display:inline-block">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Delete employee?')" class="btn btn-danger btn-sm">Del</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
<div class="container px-6 py-8 mx-auto">
    <h2 class="mb-6 text-3xl font-bold text-gray-800 dark:text-gray-200">Employee List</h2>

    <a href="{{ route('employees.create') }}"
        class="inline-block px-5 py-2 mb-6 text-white transition bg-blue-600 rounded-lg shadow hover:bg-blue-700">
        + Add Employee
    </a>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-300 dark:bg-gray-600">
                <tr>
                    <th class="px-6 py-3 text-black dark:text-white">ID</th>
                    <th class="px-6 py-3 text-black dark:text-white">Name</th>
                    <th class="px-6 py-3 text-black dark:text-white">Position</th>
                    <th class="px-6 py-3 text-black dark:text-white">Base Salary</th>
                    <th class="px-6 py-3 text-black dark:text-white">Email</th>
                    <th class="px-6 py-3 text-center text-black dark:text-white">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-gray-200 divide-gray-200 dividbg-e-y dark:bg-gray-500 dark:divide-gray-800">
                @foreach ($employees as $emp)
                <tr class="hover:bg-gray-50 hover:dark:bg-gray-600">
                    <td class="px-6 py-4 text-gray-800 dark:text-white">{{ $emp->id }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-white">{{ $emp->name }}</td>
                    <td class="px-6 py-4 text-gray-800 dark:text-white">{{ $emp->position }}</td>
                    <td class="px-6 py-4 text-gray-800 dark:text-white">Rp {{ number_format($emp->base_salary,0,',','.')
                        }}</td>
                    <td class="px-6 py-4 text-gray-800 dark:text-white">{{ $emp->email }}</td>
                    <td class="px-6 py-4 space-x-2 text-center">
                        <a href="{{ route('employees.show',$emp->id) }}"
                            class="inline-block px-3 py-1 text-white transition bg-blue-500 rounded hover:bg-blue-600">
                            Detail
                        </a>
                        <a href="{{ route('employees.edit',$emp->id) }}"
                            class="inline-block px-3 py-1 text-white transition bg-yellow-500 rounded hover:bg-yellow-600">
                            Edit
                        </a>
                        <form action="{{ route('employees.destroy',$emp->id) }}" method="POST" class="inline-block">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete employee?')"
                                class="px-3 py-1 text-white transition bg-red-500 rounded hover:bg-red-600">
                                Del
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
    <div x-data="employeeApp()"
        class="container px-6 py-8 mx-auto transition-colors duration-300 bg-gray-100 dark:bg-gray-900">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Employee List</h2>

            <button @click="openCreate()"
                class="px-5 py-2 text-white transition bg-blue-600 rounded-lg shadow hover:bg-blue-700">
                + Add Employee
            </button>
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
                <form action="{{ route('employees.index') }}" method="GET" class="flex items-center">
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
                <form action="{{ route('employees.index') }}" method="GET" class="flex items-center">
                    <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>
        <!-- End Fitur -->

        <div class="overflow-x-auto bg-white rounded-lg shadow dark:bg-gray-800">
            <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
                <thead class="text-xs text-gray-800 uppercase bg-gray-300 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 dark:text-white">ID</th>
                        <th class="px-6 py-3 dark:text-white">Name</th>
                        <th class="px-6 py-3 dark:text-white">Position</th>
                        <th class="px-6 py-3 dark:text-white">Base Salary</th>
                        <th class="px-6 py-3 dark:text-white">Email</th>
                        <th class="px-6 py-3 text-center dark:text-white">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($employees as $emp)
                        <tr class="hover:bg-gray-50 hover:dark:bg-gray-700">
                            <td class="px-6 py-4">{{ $emp->id }}</td>
                            <td class="px-6 py-4 font-medium">{{ $emp->name }}</td>
                            <td class="px-6 py-4">{{ $emp->position }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($emp->base_salary, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">{{ $emp->email }}</td>
                            <td class="px-6 py-4 space-x-2 text-center">
                                <button @click="openEdit({{ $emp }})"
                                    class="px-3 py-1 text-white transition bg-yellow-500 rounded hover:bg-yellow-600">
                                    Edit
                                </button>
                                <form action="{{ route('employees.destroy', $emp->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Delete employee?')"
                                        class="px-3 py-1 text-white transition bg-red-500 rounded hover:bg-red-600">
                                        Del
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
                @if ($employees->total() > 0)
                    <p class="text-sm text-gray-700 dark:text-white">
                        Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }} of
                        {{ $employees->total() }}
                        entries
                    </p>
                @endif
            </div>
            <div>
                @if ($employees->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                        @if ($employees->onFirstPage())
                            <span
                                class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                        @else
                            <a href="{{ $employees->previousPageUrl() }}" rel="prev"
                                class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                        @endif

                        @php
                            $currentPage = $employees->currentPage();
                            $lastPage = $employees->lastPage();
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
                                <a href="{{ $employees->url($link) }}"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                            @endif
                        @endforeach

                        @if ($employees->hasMorePages())
                            <a href="{{ $employees->nextPageUrl() }}" rel="next"
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

        <!-- Overlay -->
        <div x-show="showModal" class="fixed inset-0 z-40 flex items-center justify-center"
            style="background-color: rgba(0, 0, 0, 0.5);" x-transition.opacity>
            <div @click.outside="closeModal()" class="w-full max-w-lg p-6 bg-white shadow-lg rounded-2xl dark:bg-gray-800"
                x-transition.scale>

                <!-- Create/Edit Form -->
                <template x-if="modalType === 'create' || modalType === 'edit'">
                    <form :action="formAction" method="POST" class="space-y-5">
                        @csrf
                        <template x-if="modalType === 'edit'">
                            <input type="hidden" name="_method" value="PUT">

                        </template>

                        <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-100"
                            x-text="modalType === 'create' ? 'Add Employee' : 'Edit Employee'"></h2>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Name</label>
                            <input type="text" name="name" x-model="employee.name" required
                                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                        </div>
                        <div>
                            <label
                                class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Position</label>
                            <input type="text" name="position" x-model="employee.position" required
                                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Base
                                Salary</label>
                            <input type="number" name="base_salary" x-model="employee.base_salary" required
                                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Email</label>
                            <input type="email" name="email" x-model="employee.email" required
                                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                        </div>

                        <div class="flex justify-between pt-4">
                            <button type="submit"
                                class="px-5 py-2 text-white transition bg-indigo-600 rounded-lg shadow hover:bg-indigo-700">
                                <span x-text="modalType === 'create' ? 'Save' : 'Update'"></span>
                            </button>
                            <button type="button" @click="closeModal()"
                                class="px-5 py-2 text-gray-700 transition bg-gray-200 rounded-lg shadow hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                Cancel
                            </button>
                        </div>
                    </form>
                </template>

                <!-- Show Detail -->
                <template x-if="modalType === 'show'">
                    <div>
                        <h2 class="mb-4 text-2xl font-bold text-center text-gray-800 dark:text-gray-100">Employee Detail
                        </h2>
                        <ul class="space-y-3 text-gray-700 dark:text-gray-200">
                            <li><span class="font-semibold">ID:</span> <span x-text="employee.id"></span></li>
                            <li><span class="font-semibold">Name:</span> <span x-text="employee.name"></span></li>
                            <li><span class="font-semibold">Position:</span> <span x-text="employee.position"></span></li>
                            <li><span class="font-semibold">Base Salary:</span> Rp <span
                                    x-text="formatSalary(employee.base_salary)"></span></li>
                            <li><span class="font-semibold">Email:</span> <span x-text="employee.email"></span></li>
                        </ul>
                        <div class="mt-6 text-center">
                            <button @click="closeModal()"
                                class="px-5 py-2 text-white transition bg-gray-600 rounded-lg shadow hover:bg-gray-700">
                                Close
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script>
        function employeeApp() {
            return {
                showModal: false,
                modalType: null,
                employee: {},
                formAction: '',

                openCreate() {
                    this.modalType = 'create';
                    this.employee = {};
                    this.formAction = '{{ route('employees.store') }}';
                    this.showModal = true;
                },
                openEdit(emp) {
                    this.modalType = 'edit';
                    this.employee = {
                        ...emp
                    };
                    this.formAction = `/employees/${emp.id}`;
                    this.showModal = true;
                },
                openShow(emp) {
                    this.modalType = 'show';
                    this.employee = {
                        ...emp
                    };
                    this.showModal = true;
                },
                closeModal() {
                    this.showModal = false;
                },
                formatSalary(value) {
                    return new Intl.NumberFormat('id-ID').format(value);
                }
            }
        }
    </script>
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="container px-6 py-8 mx-auto transition-colors duration-300 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Employee List</h2>

            <button onclick="openCreateModal()"
                class="px-5 py-2 text-white transition bg-blue-600 rounded-lg shadow hover:bg-blue-700">
                + Add Employee
            </button>
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

        <div class="flex flex-col gap-3 mb-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center">
                <label for="per_page" class="mr-2 text-sm text-gray-600 dark:text-white">Show:</label>
                <select id="per_page" onchange="fetchData()"
                    class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
            <div class="flex items-center">
                <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                <input type="text" id="search" oninput="handleSearch()"
                    class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    value="{{ $search }}" placeholder="Search name/email...">
            </div>
        </div>
        <div id="dynamic-content">
            <div class="overflow-x-auto bg-white rounded-lg shadow dark:bg-gray-800">
                <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
                    <thead class="text-xs text-gray-800 uppercase bg-gray-300 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 dark:text-white">ID</th>
                            <th class="px-6 py-3 dark:text-white">Name</th>
                            <th class="px-6 py-3 dark:text-white">Position</th>
                            <th class="px-6 py-3 dark:text-white">Base Salary</th>
                            <th class="px-6 py-3 dark:text-white">Email</th>
                            <th class="px-6 py-3 text-center dark:text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($employees as $emp)
                            <tr class="transition-colors duration-150 hover:bg-gray-50 hover:dark:bg-gray-700">
                                <td class="px-6 py-4">{{ $emp->id }}</td>
                                <td class="px-6 py-4 font-medium">{{ $emp->name }}</td>
                                <td class="px-6 py-4">{{ $emp->position }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($emp->base_salary, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">{{ $emp->email }}</td>
                                <td class="px-6 py-4 space-x-2 text-center">
                                    {{-- Data Employee dilempar langsung via @json ke fungsi JavaScript --}}
                                    <button onclick='openEditModal(@json($emp))'
                                        class="px-3 py-1 text-white transition bg-yellow-500 rounded hover:bg-yellow-600">
                                        Edit
                                    </button>

                                    <button type="button" onclick="openDeleteModal({{ $emp->id }})"
                                        class="px-3 py-1 text-white transition bg-red-500 rounded hover:bg-red-600">
                                        Del
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                    <p class="text-lg font-semibold">Belum ada data pegawai.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div id="pagination-links" class="flex flex-col items-center justify-between gap-4 mt-4 sm:flex-row">
                <div>
                    @if ($employees->total() > 0)
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }} of {{ $employees->total() }} entries
                        </p>
                    @endif
                </div>
                <div>
                    @if ($employees->hasPages())
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                            @if ($employees->onFirstPage())
                                <span class="px-3 py-1 mr-1 text-gray-400 bg-white border border-gray-300 rounded cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500">Prev</span>
                            @else
                                <a href="{{ $employees->previousPageUrl() }}" class="px-3 py-1 mr-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:bg-gray-600">Prev</a>
                            @endif

                            @php
                                $currentPage = $employees->currentPage();
                                $lastPage = $employees->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            @endphp

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $currentPage)
                                    <span class="px-3 py-1 mr-1 text-white bg-blue-500 border border-blue-500 rounded dark:bg-blue-600 dark:border-blue-600">{{ $i }}</span>
                                @else
                                    <a href="{{ $employees->url($i) }}" class="px-3 py-1 mr-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:bg-gray-600">{{ $i }}</a>
                                @endif
                            @endfor

                            @if ($employees->hasMorePages())
                                <a href="{{ $employees->nextPageUrl() }}" class="px-3 py-1 ml-1 text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:bg-gray-600">Next</a>
                            @else
                                <span class="px-3 py-1 ml-1 text-gray-400 bg-white border border-gray-300 rounded cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-500">Next</span>
                            @endif
                        </nav>
                    @endif
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

        // Debounce pencarian
        function handleSearch() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetchData();
            }, 100);
        }

        // Fetch Data Utama SPA
        function fetchData(targetUrl = null) {
            if (typeof targetUrl !== 'string') targetUrl = null;

            const search = document.getElementById('search').value;
            const perPage = document.getElementById('per_page').value;

            // Target rute disesuaikan dengan employees
            let urlString = targetUrl || `{{ route('employees.index') }}`;
            const urlObj = new URL(urlString, window.location.origin);

            // Fix Vercel Protocol Block (Mixed Content Error)
            if (window.location.protocol === 'https:') {
                urlObj.protocol = 'https:';
            }

            urlObj.searchParams.set('search', search);
            urlObj.searchParams.set('per_page', perPage);

            const finalUrl = urlObj.toString();

            // Cache Render (0ms Delay)
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

        // INTENT PREDICTION (Hover fetch)
        document.addEventListener('mouseover', function (e) {
            const link = e.target.closest('#pagination-links a');
            if (link) {
                const hoverUrlObj = new URL(link.href, window.location.origin);
                if (window.location.protocol === 'https:') {
                    hoverUrlObj.protocol = 'https:';
                }
                const safeHoverUrl = hoverUrlObj.toString();

                if (!pageCache[safeHoverUrl]) {
                    fetch(safeHoverUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(res => res.text())
                        .then(html => pageCache[safeHoverUrl] = html)
                        .catch(() => { });
                }
            }
        });

        // EVENT DELEGATION
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
        // 2. SWEETALERT MODALS LOGIC (EMPLOYEES)
        // =========================================================
        const isDark = () => document.documentElement.classList.contains('dark');
        const swalBg = () => isDark() ? '#1f2937' : '#ffffff';
        const swalText = () => isDark() ? '#ffffff' : '#374151';

        // MODAL TAMBAH PEGAWAI
        function openCreateModal() {
            Swal.fire({
                title: 'Add New Employee',
                background: swalBg(),
                color: swalText(),
                html: `
                    <form id="createForm" action="{{ route('employees.store') }}" method="POST" class="text-left text-sm space-y-4">
                        @csrf
                        <div>
                            <label class="block mb-1 font-medium">Name</label>
                            <input type="text" name="name" required class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Position</label>
                            <input type="text" name="position" required class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Base Salary (Rp)</label>
                            <input type="number" name="base_salary" required class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Email</label>
                            <input type="email" name="email" required class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" />
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#2563eb', // Blue-600
                cancelButtonColor: '#6b7280',
                preConfirm: () => {
                    const form = document.getElementById('createForm');
                    if (form.checkValidity()) {
                        form.submit();
                        return false;
                    } else {
                        form.reportValidity();
                        return false;
                    }
                }
            });
        }

        // MODAL EDIT PEGAWAI
        // Data di-_inject_ langsung ke modal via parameter (0ms loading API)
        function openEditModal(emp) {
            Swal.fire({
                title: 'Edit Employee',
                background: swalBg(),
                color: swalText(),
                html: `
                    <form id="editForm" action="/employees/${emp.id}" method="POST" class="text-left text-sm space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block mb-1 font-medium">Name</label>
                            <input type="text" name="name" value="${emp.name}" required class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Position</label>
                            <input type="text" name="position" value="${emp.position}" required class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Base Salary (Rp)</label>
                            <input type="number" name="base_salary" value="${emp.base_salary}" required class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Email</label>
                            <input type="email" name="email" value="${emp.email || ''}" required class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" />
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Update',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#eab308', // Yellow-500
                cancelButtonColor: '#6b7280',
                preConfirm: () => {
                    const form = document.getElementById('editForm');
                    if (form.checkValidity()) {
                        form.submit();
                        return false;
                    } else {
                        form.reportValidity();
                        return false;
                    }
                }
            });
        }

        // MODAL DELETE PEGAWAI
        function openDeleteModal(empId) {
            Swal.fire({
                title: 'Delete Employee?',
                text: "Are you sure you want to delete this employee? This action cannot be undone.",
                icon: 'warning',
                background: swalBg(),
                color: swalText(),
                showCancelButton: true,
                confirmButtonColor: '#ef4444', // Red-500
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('globalDeleteForm');
                    form.action = `/employees/${empId}`; // Menuju Route Destroy
                    form.submit();
                }
            });
        }
    </script>
@endsection
