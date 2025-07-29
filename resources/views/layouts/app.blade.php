<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Management</title>
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100">
    <div x-data="{ sidebarOpen: false, sidebarExpanded: true }" :class="{ 'overflow-hidden': sidebarOpen }"
        class="flex min-h-screen">

        <!-- Sidebar -->
        <aside :class="sidebarExpanded ? 'w-64' : 'w-16'"
            class="fixed z-30 flex flex-col h-full text-white transition-all duration-300 bg-green-800">
            <div class="flex items-center justify-between px-4 py-4 border-b border-green-700">
                <span x-show="sidebarExpanded" class="text-lg font-semibold">Sistem Peminjaman Buku</span>
                <button @click="sidebarExpanded = !sidebarExpanded" class="text-white focus:outline-none">
                    <!-- Menu Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 mt-4">
                <!-- Student List with User Icon -->
                <a href="{{ route('students.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-green-700">
                    <!-- Heroicon: User -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A4 4 0 019 16h6a4 4 0 013.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Student List</span>
                </a>

                <a href="{{ route('categories.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-green-700">
                    <!-- Heroicon: Tag -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M4 4l8.293 8.293a1 1 0 001.414 0L20 6a2 2 0 00-2-2l-6.707 6.707a1 1 0 01-1.414 0L4 4z" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Categories</span>
                </a>

                <!-- Books with Book Icon -->
                <a href="{{ route('books.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-green-700">
                    <!-- Heroicon: Book -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4a2 2 0 00-2-2H6a2 2 0 00-2 2v16a2 2 0 002 2h4a2 2 0 002-2v-2m0-12h6a2 2 0 012 2v12a2 2 0 01-2 2h-6" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Books</span>
                </a>

                <!-- Loan Menu with Calendar Icon -->
                <a href="{{ route('loans.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-green-700">
                    <!-- Heroicon: Calendar -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Loan List</span>
                </a>
            </nav>

        </aside>

        <!-- Overlay for mobile -->
        <div class="inset-0 z-20 bg-opacity-50 lg:hidden" x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition.opacity></div>

        <!-- Main Content -->
        <div :class="sidebarExpanded ? 'ml-64' : 'ml-16'" class="flex-1 p-6 transition-all duration-300">

            @yield('content')
        </div>
    </div>

</body>

</html>