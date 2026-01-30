@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-6">
        <h2 class="mb-4 text-2xl font-bold text-gray-800 dark:text-white">Student List</h2>

        {{-- @if (session('success'))
            <div class="px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
                {{ session('success') }}
            </div>
        @endif --}}

        @if (session('success'))
            <div id="success-alert"
                class="px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded transition-opacity duration-500">
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


        <div class="mb-4">
            <button onclick="openModal('createModal')"
                class="inline-block px-4 py-2 font-semibold text-white bg-blue-600 rounded shadow cursor-pointer hover:bg-blue-700">
                + Add Student
            </button>

            <!-- NEW: tombol Registered Students -->
            <button onclick="window.location='{{ route('admin.registered_students') }}'"
                class="inline-block px-4 py-2 ml-2 font-semibold text-white bg-green-600 rounded shadow cursor-pointer hover:bg-green-700">
                Registered Students
            </button>
        </div>

        <!-- Fitur Search dan Items per Page -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <form action="{{ route('students.index') }}" method="GET" class="flex items-center">
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
                <form action="{{ route('students.index') }}" method="GET" class="flex items-center">
                    <label for="search" class="mr-2 text-sm text-gray-600 dark:text-white">Search:</label>
                    <input type="text" name="search" id="search"
                        class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ $search }}" placeholder="Search...">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                </form>
            </div>
        </div>
        <!-- End Fitur -->

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full bg-white dark:bg-gray-600">
                <thead class="bg-gray-200">
                    <tr class="text-sm leading-normal text-gray-700 uppercase">
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Major</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Phone</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    @forelse($students as $student)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 dark:hover:bg-gray-500">
                            <td class="px-6 py-4 dark:text-white">{{ $student->name }}</td>
                            <td class="px-6 py-4 dark:text-white">{{ $student->major }}</td>
                            <td class="px-6 py-4 dark:text-white">{{ $student->email }}</td>
                            <td class="px-6 py-4 dark:text-white">{{ $student->phone }}</td>
                            <td class="flex px-6 py-4 space-x-2">
                                {{-- <a href="{{ route('students.show', $student->id) }}"
                                    class="px-3 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">View</a>
                                <a href="{{ route('students.edit', $student->id) }}"
                                    class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">Edit</a>
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this student?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600">
                                        Delete
                                    </button>
                                </form> --}}
                                <button onclick='fillViewModal(@json($student))'
                                    class="px-3 py-1 text-sm text-white bg-blue-500 rounded cursor-pointer hover:bg-blue-600">View</button>

                                <button onclick='fillEditModal(@json($student))'
                                    class="px-3 py-1 text-sm text-white bg-yellow-500 rounded cursor-pointer hover:bg-yellow-600">Edit</button>
                                {{-- <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this student?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600">
                                        Delete
                                    </button>
                                </form> --}}
                                <form id="deleteForm-{{ $student->id }}"
                                    action="{{ route('students.destroy', $student->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="openDeleteModal({{ $student->id }})"
                                        class="px-3 py-1 text-sm text-white bg-red-500 rounded cursor-pointer hover:bg-red-600">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No students found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Fitur Pagination -->
        <div class="flex items-center justify-between mt-4">
            <div>
                @if ($students->total() > 0)
                    <p class="text-sm text-gray-700 dark:text-white">
                        Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }}
                        entries
                    </p>
                @endif
            </div>
            <div>
                @if ($students->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                        {{-- Previous Page Link --}}
                        @if ($students->onFirstPage())
                            <span
                                class="px-3 py-1 mr-1 text-gray-400 bg-white border rounded cursor-not-allowed">Prev</span>
                        @else
                            <a href="{{ $students->previousPageUrl() }}" rel="prev"
                                class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">Prev</a>
                        @endif

                        @php
                            $currentPage = $students->currentPage();
                            $lastPage = $students->lastPage();
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
                                <a href="{{ $students->url($link) }}"
                                    class="px-3 py-1 mr-1 text-gray-700 bg-white border rounded hover:bg-gray-50">{{ $link }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($students->hasMorePages())
                            <a href="{{ $students->nextPageUrl() }}" rel="next"
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
        <!-- Create Modal -->
        <div id="createModal" class="fixed inset-0 z-50 hidden overflow-y-auto"
            style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="relative w-full max-w-lg p-6 mx-auto mt-20 bg-white rounded shadow-lg">
                <h2 class="mb-4 text-xl font-semibold text-gray-700">Add Student</h2>
                <form action="{{ route('students.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-700">Name</label>
                        <input name="name" required class="w-full px-3 py-2 border rounded" />
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-700">Major</label>
                        <input name="major" required class="w-full px-3 py-2 border rounded" />
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                        <input name="email" type="email" required class="w-full px-3 py-2 border rounded" />
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-700">Phone</label>
                        <input name="phone" type="text" required maxlength="12"
                            class="w-full px-3 py-2 border rounded" />
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeModal('createModal')"
                            class="px-4 py-2 text-gray-600 bg-gray-200 rounded">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto"
            style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="relative w-full max-w-lg p-6 mx-auto mt-20 bg-white rounded shadow-lg">
                <h2 class="mb-4 text-xl font-semibold text-gray-700">Edit Student</h2>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-700">Name</label>
                        <input name="name" id="editName" required class="w-full px-3 py-2 border rounded" />
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-700">Major</label>
                        <input name="major" id="editMajor" required class="w-full px-3 py-2 border rounded" />
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                        <input name="email" id="editEmail" type="email" required
                            class="w-full px-3 py-2 border rounded" />
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-700">Phone</label>
                        <input name="phone" id="editPhone" type="text" maxlength="12" required
                            class="w-full px-3 py-2 border rounded" />
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="editDescription" rows="3" class="w-full px-3 py-2 border rounded"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeModal('editModal')"
                            class="px-4 py-2 text-gray-600 bg-gray-200 rounded">Cancel</button>
                        <button type="submit" class="px-4 py-2 text-white bg-yellow-600 rounded">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- View Modal -->
        <div id="viewModal" class="fixed inset-0 z-50 flex items-center justify-center hidden"
            style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="relative w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">
                <h2 class="mb-4 text-xl font-semibold text-gray-700">Student Details</h2>
                <div class="space-y-2 max-h-[70vh] overflow-y-auto pr-2">
                    <div><strong>Name:</strong> <span id="viewName"></span></div>
                    <div><strong>Major:</strong> <span id="viewMajor"></span></div>
                    <div><strong>Email:</strong> <span id="viewEmail"></span></div>
                    <div><strong>Phone:</strong> <span id="viewPhone"></span></div>
                    <div>
                        <strong>Description:</strong>
                        <div id="viewDescription"
                            class="p-2 mt-1 overflow-y-auto text-sm text-gray-700 border rounded bg-gray-50 max-h-40">
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <button onclick="closeModal('viewModal')"
                        class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Close</button>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto"
            style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="relative w-full max-w-md p-6 mx-auto mt-40 bg-white rounded shadow-lg">
                <h2 class="mb-4 text-lg font-semibold text-gray-800">Confirm Delete</h2>
                <p class="mb-6 text-gray-600">Are you sure you want to delete this student?</p>
                <div class="flex justify-end space-x-2">
                    <button onclick="closeModal('deleteModal')"
                        class="px-4 py-2 text-gray-600 bg-gray-200 rounded">Cancel</button>
                    <button id="confirmDeleteBtn" class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">Yes,
                        Delete</button>
                </div>
            </div>
        </div>

    @endsection
    @section('scripts')
        <script>
            let deleteStudentId = null;

            function openDeleteModal(studentId) {
                deleteStudentId = studentId;
                document.getElementById('deleteModal').classList.remove('hidden');
            }

            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                if (deleteStudentId) {
                    document.getElementById(`deleteForm-${deleteStudentId}`).submit();
                }
            });

            function openModal(id) {
                document.getElementById(id).classList.remove('hidden');
            }

            function closeModal(id) {
                document.getElementById(id).classList.add('hidden');
            }

            function fillEditModal(student) {
                const form = document.getElementById('editForm');
                form.action = `/admin/students/${student.id}`;
                document.getElementById('editName').value = student.name;
                document.getElementById('editMajor').value = student.major;
                document.getElementById('editEmail').value = student.email;
                document.getElementById('editPhone').value = student.phone;
                document.getElementById('editDescription').value = student.description || '';
                openModal('editModal');
            }

            function fillViewModal(student) {
                document.getElementById('viewName').textContent = student.name;
                document.getElementById('viewMajor').textContent = student.major;
                document.getElementById('viewEmail').textContent = student.email;
                document.getElementById('viewPhone').textContent = student.phone;
                document.getElementById('viewDescription').textContent = student.description || '-';
                openModal('viewModal');
            }
        </script>
    @endsection
