{{--
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

</html> --}}

{{--
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sistem Peminjaman Buku</title>
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100">
    <div x-data="{ sidebarOpen: false, sidebarExpanded: true, showLogoutConfirm: false }"
        :class="{ 'overflow-hidden': sidebarOpen }" class="flex min-h-screen">

        <!-- Sidebar -->
        <aside :class="sidebarExpanded ? 'w-64' : 'w-16'"
            class="fixed z-30 flex flex-col h-full text-white transition-all duration-300 bg-green-800">
            <div class="flex items-center justify-between px-4 py-4 border-b border-green-700">
                <span x-show="sidebarExpanded" class="text-lg font-semibold">Sistem Peminjaman Buku</span>
                <button @click="sidebarExpanded = !sidebarExpanded" class="text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 mt-4 space-y-1">
                <a href="{{ route('students.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A4 4 0 019 16h6a4 4 0 013.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Student List</span>
                </a>

                <a href="{{ route('categories.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M4 4l8.293 8.293a1 1 0 001.414 0L20 6a2 2 0 00-2-2l-6.707 6.707a1 1 0 01-1.414 0L4 4z" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Categories</span>
                </a>

                <a href="{{ route('books.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4a2 2 0 00-2-2H6a2 2 0 00-2 2v16a2 2 0 002 2h4a2 2 0 002-2v-2m0-12h6a2 2 0 012 2v12a2 2 0 01-2 2h-6" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Books</span>
                </a>

                <a href="{{ route('loans.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Loan List</span>
                </a>
            </nav>

            <!-- Logout button at the bottom -->
            <div class="mt-auto px-4 py-3 border-t border-green-700">
                <button @click="showLogoutConfirm = true"
                    class="flex items-center w-full px-2 py-2 text-left transition-colors hover:bg-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Logout</span>
                </button>
            </div>
        </aside>

        <!-- Logout confirmation modal -->
        <div x-show="showLogoutConfirm"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
                <h2 class="text-lg font-semibold mb-4">Konfirmasi Logout</h2>
                <p class="mb-6">Apakah Anda ingin melakukan logout?</p>
                <div class="flex justify-end space-x-4">
                    <button @click="showLogoutConfirm = false"
                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300">No</button>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">Yes</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content Wrapper -->
        <div :class="sidebarExpanded ? 'ml-64' : 'ml-16'" class="flex-1 transition-all duration-300">

            <!-- Topbar -->
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b shadow-sm">
                <div class="flex items-center space-x-4">
                    <!-- FAQ -->
                    <a href="#" class="text-sm font-bold text-gray-700 hover:underline">FAQ</a>
                </div>

                <div class="flex items-center space-x-6">


                    <!-- Bell icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 7.165 6 9.388 6 12v2.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>

                    <!-- Profile -->
                    <img src="{{ asset('assets/images/profile.png') }}" alt="Profile"
                        class="w-8 h-8 rounded-full border border-gray-300">
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                @yield('content')
            </main>

        </div>

    </div>
</body>

</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sistem Peminjaman Buku</title>
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100">
    <div x-data="{ sidebarOpen: false, sidebarExpanded: true, showLogoutConfirm: false }">

        <aside :class="sidebarExpanded ? 'w-64' : 'w-16'"
            class="fixed z-30 flex flex-col h-full text-white transition-all duration-300 bg-green-800">
            <div class="flex items-center justify-between px-4 py-4 border-b border-green-700">
                <span x-show="sidebarExpanded" class="text-lg font-semibold">Sistem Peminjaman Buku</span>
                <button @click="sidebarExpanded = !sidebarExpanded" class="text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 mt-4 space-y-1">
                <!-- Dashboard Menu -->
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3v18h18M9 17V9M15 17V5" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Dashboard</span>
                </a>
                <a href="{{ route('students.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A4 4 0 019 16h6a4 4 0 013.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Student List</span>
                </a>
                <a href="{{ route('categories.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M4 4l8.293 8.293a1 1 0 001.414 0L20 6a2 2 0 00-2-2l-6.707 6.707a1 1 0 01-1.414 0L4 4z" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Categories</span>
                </a>
                <a href="{{ route('books.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4a2 2 0 00-2-2H6a2 2 0 00-2 2v16a2 2 0 002 2h4a2 2 0 002-2v-2m0-12h6a2 2 0 012 2v12a2 2 0 01-2 2h-6" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Books</span>
                </a>
                <a href="{{ route('loans.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Loan List</span>
                </a>
            </nav>

            <div class="mt-auto px-4 py-3 border-t border-green-700">
                <button @click="showLogoutConfirm = true"
                    class="flex items-center w-full px-2 py-2 text-left transition-colors hover:bg-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Logout</span>
                </button>
            </div>
        </aside>

        <div :class="sidebarExpanded ? 'ml-64' : 'ml-16'" class="transition-all duration-300 min-h-screen">
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b shadow-sm">
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-lg font-bold text-gray-700 hover:underline">FAQ</a>
                </div>
                <div class="flex items-center space-x-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 7.165 6 9.388 6 12v2.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <img src="{{ asset('assets/images/profile.png') }}" alt="Profile"
                        class="w-8 h-8 rounded-full border border-gray-300">
                </div>
            </header>
            <main class="p-6">
                @yield('content')
                @yield('scripts')
            </main>
        </div>

        {{-- <div x-show="showLogoutConfirm"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" style="display: none;">
            --}}
            <div x-show="showLogoutConfirm" class="fixed inset-0 flex items-center justify-center z-50"
                style="display: none; background-color: rgba(0, 0, 0, 0.5);">
                <div @click.away="showLogoutConfirm = false" class="bg-white p-6 rounded shadow-md w-full max-w-md">
                    <h2 class="text-lg font-semibold mb-4">Konfirmasi Logout</h2>
                    <p class="mb-6">Apakah Anda ingin melakukan logout?</p>
                    <div class="flex justify-end space-x-4">
                        <button @click="showLogoutConfirm = false"
                            class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300">No</button>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">Yes</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
</body>

</html>