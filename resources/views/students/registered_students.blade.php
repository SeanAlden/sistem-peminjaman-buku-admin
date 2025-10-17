@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-6">
        <h2 class="mb-4 text-2xl font-bold text-gray-800 dark:text-white">Registered Students</h2>

        <div class="mb-4">
            <a href="{{ route('students.index') }}"
                class="inline-block px-4 py-2 font-semibold text-white bg-gray-600 rounded shadow hover:bg-gray-700">
                Back to Students
            </a>
        </div>

        <!-- Fitur Search dan Items per Page -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <form action="{{ route('admin.registered_students') }}" method="GET" class="flex items-center">
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
                <form action="{{ route('admin.registered_students') }}" method="GET" class="flex items-center">
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
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Phone</th>
                        <th class="px-6 py-3 text-left">Registered At</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    @forelse($users as $u)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 dark:hover:bg-gray-500">
                            <td class="px-6 py-4 dark:text-white">{{ $u->name }}</td>
                            <td class="px-6 py-4 dark:text-white">{{ $u->email }}</td>
                            <td class="px-6 py-4 dark:text-white">{{ $u->phone }}</td>
                            <td class="px-6 py-4 dark:text-white">
                                {{ $u->created_at ? $u->created_at->format('Y-m-d H:i') : '-' }}</td>
                            <td class="flex px-6 py-4 space-x-2">
                                <button onclick='fillViewModal(@json($u))'
                                    class="px-3 py-1 text-sm text-white bg-blue-500 rounded cursor-pointer hover:bg-blue-600">View</button>
                                <a href="{{ route('chat.show', $u->id) }}"
                                    class="px-3 py-1 text-sm text-white bg-green-500 rounded cursor-pointer hover:bg-green-600">Chat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No registered students found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-4">
            <div>
                @if ($users->total() > 0)
                    <p class="text-sm text-gray-700 dark:text-white">
                        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                    </p>
                @endif
            </div>
            <div>
                @if ($users->hasPages())
                    {{ $users->links() }} {{-- atau Anda bisa menggunakan custom pagination seperti di student.blade --}}
                @endif
            </div>
        </div>

        <!-- View Modal (simple) -->
        <div id="viewModal" class="fixed inset-0 z-50 flex items-center justify-center hidden"
            style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="relative w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">
                <h2 class="mb-4 text-xl font-semibold text-gray-700">User Details</h2>
                <div class="space-y-2 max-h-[70vh] overflow-y-auto pr-2">
                    <div><strong>Name:</strong> <span id="viewName"></span></div>
                    <div><strong>Email:</strong> <span id="viewEmail"></span></div>
                    <div><strong>Phone:</strong> <span id="viewPhone"></span></div>
                    <div><strong>Registered At:</strong> <span id="viewRegisteredAt"></span></div>
                </div>
                <div class="flex justify-end mt-6">
                    <button onclick="closeModal('viewModal')"
                        class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Close</button>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
        function fillViewModal(user) {
            document.getElementById('viewName').textContent = user.name;
            document.getElementById('viewEmail').textContent = user.email;
            document.getElementById('viewPhone').textContent = user.phone || '-';
            document.getElementById('viewRegisteredAt').textContent = user.created_at || '-';
            openModal('viewModal');
        }
    </script>
@endsection