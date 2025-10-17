{{-- @extends('layouts.app')

@section('content')
<h2 class="mb-3">Employee List</h2>
<a href="{{ route('employees.create') }}" class="mb-3 btn btn-primary">+ Add Employee</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th><th>Name</th><th>Position</th><th>Base Salary</th><th>Email</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employees as $emp)
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
                @foreach($employees as $emp)
                <tr class="hover:bg-gray-50 hover:dark:bg-gray-600">
                    <td class="px-6 py-4 text-gray-800 dark:text-white">{{ $emp->id }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-white">{{ $emp->name }}</td>
                    <td class="px-6 py-4 text-gray-800 dark:text-white">{{ $emp->position }}</td>
                    <td class="px-6 py-4 text-gray-800 dark:text-white">Rp {{ number_format($emp->base_salary,0,',','.') }}</td>
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

@extends('layouts.app')

@section('content')
<div x-data="employeeApp()" class="container px-6 py-8 mx-auto transition-colors duration-300 bg-gray-100 dark:bg-gray-900">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Employee List</h2>

        <button @click="openCreate()" 
            class="px-5 py-2 text-white transition bg-blue-600 rounded-lg shadow hover:bg-blue-700">
            + Add Employee
        </button>
    </div>

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
                @foreach($employees as $emp)
                <tr class="hover:bg-gray-50 hover:dark:bg-gray-700">
                    <td class="px-6 py-4">{{ $emp->id }}</td>
                    <td class="px-6 py-4 font-medium">{{ $emp->name }}</td>
                    <td class="px-6 py-4">{{ $emp->position }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($emp->base_salary,0,',','.') }}</td>
                    <td class="px-6 py-4">{{ $emp->email }}</td>
                    <td class="px-6 py-4 space-x-2 text-center">
                        <button @click="openShow({{ $emp }})"
                            class="px-3 py-1 text-white transition bg-blue-500 rounded hover:bg-blue-600">
                            Detail
                        </button>
                        <button @click="openEdit({{ $emp }})"
                            class="px-3 py-1 text-white transition bg-yellow-500 rounded hover:bg-yellow-600">
                            Edit
                        </button>
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

    {{-- ====== MODAL POPUPS ====== --}}
    <!-- Overlay -->
    <div x-show="showModal" 
         class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-50"
         x-transition.opacity>
        <div @click.outside="closeModal()" 
             class="w-full max-w-lg p-6 bg-white shadow-lg rounded-2xl dark:bg-gray-800"
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
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Position</label>
                        <input type="text" name="position" x-model="employee.position" required
                            class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Base Salary</label>
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
                    <h2 class="mb-4 text-2xl font-bold text-center text-gray-800 dark:text-gray-100">Employee Detail</h2>
                    <ul class="space-y-3 text-gray-700 dark:text-gray-200">
                        <li><span class="font-semibold">ID:</span> <span x-text="employee.id"></span></li>
                        <li><span class="font-semibold">Name:</span> <span x-text="employee.name"></span></li>
                        <li><span class="font-semibold">Position:</span> <span x-text="employee.position"></span></li>
                        <li><span class="font-semibold">Base Salary:</span> Rp <span x-text="formatSalary(employee.base_salary)"></span></li>
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

{{-- Alpine.js --}}
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
            this.formAction = '{{ route("employees.store") }}';
            this.showModal = true;
        },
        openEdit(emp) {
            this.modalType = 'edit';
            this.employee = { ...emp };
            this.formAction = `/employees/${emp.id}`;
            this.showModal = true;
        },
        openShow(emp) {
            this.modalType = 'show';
            this.employee = { ...emp };
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
@endsection

