<!DOCTYPE html>
{{-- <html lang="en"> --}}
{{-- <html lang="en" x-data="{ darkMode: JSON.parse(localStorage.getItem('darkMode') || 'false') }"
    x-init="$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :data-theme="darkMode ? 'dark' : 'light'"> --}}

<html lang="en" x-data="{ darkMode: JSON.parse(localStorage.getItem('darkMode') || 'false') }"
    x-init="$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <title>Sistem Peminjaman Buku</title>
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900">
    <div x-data="{ sidebarOpen: false, sidebarExpanded: true, showLogoutConfirm: false }">
        <aside :class="sidebarExpanded ? 'w-64' : 'w-16'"
            class="fixed top-0 z-50 flex flex-col h-full text-white transition-all duration-300 bg-orange-800">
            <div class="flex items-center justify-between px-4 py-4 border-b border-orange-700">
                <span x-show="sidebarExpanded" class="text-lg font-semibold">Sistem Peminjaman Buku</span>
                <button @click="sidebarExpanded = !sidebarExpanded"
                    class="text-white cursor-pointer focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            {{-- <nav class="flex-1 mt-4 space-y-1">
                <!-- Dashboard Menu -->
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3v18h18M9 17V9M15 17V5" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Dashboard</span>
                </a>
                <a href="{{ route('students.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A4 4 0 019 16h6a4 4 0 013.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Student List</span>
                </a>
                <a href="{{ route('categories.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M4 4l8.293 8.293a1 1 0 001.414 0L20 6a2 2 0 00-2-2l-6.707 6.707a1 1 0 01-1.414 0L4 4z" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Categories</span>
                </a>
                <a href="{{ route('books.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4a2 2 0 00-2-2H6a2 2 0 00-2 2v16a2 2 0 002 2h4a2 2 0 002-2v-2m0-12h6a2 2 0 012 2v12a2 2 0 01-2 2h-6" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Books</span>
                </a>
                <a href="{{ route('loans.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Loan List</span>
                </a>
                <!-- Prediction Menu -->
                <a href="{{ route('predictions.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 11V3H5a2 2 0 00-2 2v6h8zm2 0h8V5a2 2 0 00-2-2h-6v8zm0 2v8h6a2 2 0 002-2v-6h-8zm-2 0H3v6a2 2 0 002 2h6v-8z" />
                    </svg>
                    <span x-show="sidebarExpanded" class="ml-3">Prediction</span>
                </a>
            </nav> --}}

            {{-- <nav class="flex-1 mt-4 space-y-1">
                <!-- Dashboard Menu -->
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <img src="{{ asset('assets/icons/dashboard.png') }}" class="w-5 h-5" alt="Dashboard Icon">
                    <span x-show="sidebarExpanded" class="ml-3">Dashboard</span>
                </a>

                <!-- Student List Menu -->
                <a href="{{ route('students.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <img src="{{ asset('assets/icons/student.png') }}" class="w-5 h-5" alt="Student Icon">
                    <span x-show="sidebarExpanded" class="ml-3">Student List</span>
                </a>

                <!-- Categories Menu -->
                <a href="{{ route('categories.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <img src="{{ asset('assets/icons/category.png') }}" class="w-5 h-5" alt="Category Icon">
                    <span x-show="sidebarExpanded" class="ml-3">Categories</span>
                </a>

                <!-- Books Menu -->
                <a href="{{ route('books.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <img src="{{ asset('assets/icons/book.png') }}" class="w-5 h-5" alt="Book Icon">
                    <span x-show="sidebarExpanded" class="ml-3">Books</span>
                </a>

                <!-- Purchases Menu -->
                <a href="{{ route('purchases.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <img src="{{ asset('assets/icons/purchase.png') }}" class="w-5 h-5" alt="Book Icon">
                    <span x-show="sidebarExpanded" class="ml-3">Purchases</span>
                </a>

                <!-- Suppliers Menu -->
                <a href="{{ route('suppliers.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <img src="{{ asset('assets/icons/supplier.png') }}" class="w-5 h-5" alt="Book Icon">
                    <span x-show="sidebarExpanded" class="ml-3">Suppliers</span>
                </a>

                <!-- Loan List Menu -->
                <a href="{{ route('loans.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <img src="{{ asset('assets/icons/loan.png') }}" class="w-5 h-5" alt="Loan Icon">
                    <span x-show="sidebarExpanded" class="ml-3">Loan List</span>
                </a>

                <!-- Prediction Menu -->
                <a href="{{ route('predictions.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <img src="{{ asset('assets/icons/prediction.png') }}" class="w-5 h-5" alt="Prediction Icon">
                    <span x-show="sidebarExpanded" class="ml-3">Prediction</span>
                </a>
            </nav> --}}

            <nav class="flex-1 mt-4 space-y-1">
                <!-- Dashboard Menu -->
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <img src="{{ asset('assets/icons/dashboard.png') }}" class="w-5 h-5" alt="Dashboard Icon">
                    <span x-show="sidebarExpanded" class="ml-3">Dashboard</span>
                </a>

                <!-- Student List Menu -->
                <a href="{{ route('students.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <img src="{{ asset('assets/icons/student.png') }}" class="w-5 h-5" alt="Student Icon">
                    <span x-show="sidebarExpanded" class="ml-3">Student List</span>
                </a>

                <!-- Categories Menu -->
                <a href="{{ route('categories.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <img src="{{ asset('assets/icons/category.png') }}" class="w-5 h-5" alt="Category Icon">
                    <span x-show="sidebarExpanded" class="ml-3">Categories</span>
                </a>

                <!-- Books Menu with Submenu -->
                <div x-data="{ open: false }">
                    <!-- Parent Book Menu -->
                    <button @click="open = !open"
                        class="flex items-center w-full px-4 py-3 transition-colors hover:bg-orange-700 focus:outline-none">
                        <img src="{{ asset('assets/icons/book.png') }}" class="w-5 h-5" alt="Book Icon">
                        <span x-show="sidebarExpanded" class="flex-1 ml-3 text-left">Books</span>
                        <svg x-show="sidebarExpanded" :class="{ 'rotate-90': open }"
                            class="w-4 h-4 ml-auto transition-transform transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <!-- Submenus -->
                    <div x-show="open" x-collapse class="ml-8 space-y-1">
                        <a href="{{ route('books.index') }}"
                            class="flex items-center px-4 py-2 text-sm transition-colors rounded hover:bg-orange-700">
                            <span>All Books</span>
                        </a>
                        <a href="{{ route('purchases.index') }}"
                            class="flex items-center px-4 py-2 text-sm transition-colors rounded hover:bg-orange-700">
                            <span>Purchases</span>
                        </a>
                        <a href="{{ route('entry_books.index') }}"
                            class="flex items-center px-4 py-2 text-sm transition-colors rounded hover:bg-orange-700">
                            <span>Entry Books</span>
                        </a>
                        <a href="{{ route('exit_books.index') }}"
                            class="flex items-center px-4 py-2 text-sm transition-colors rounded hover:bg-orange-700">
                            <span>Exit Books</span>
                        </a>
                        <a href="{{ route('stock.management') }}"
                            class="flex items-center px-4 py-2 text-sm transition-colors rounded hover:bg-orange-700">
                            <span>Stock Management Report</span>
                        </a>
                        <a href="{{ route('reservations.index') }}"
                            class="flex items-center px-4 py-2 text-sm transition-colors rounded hover:bg-orange-700">
                            <span>Reservations</span>
                        </a>
                    </div>
                </div>

                <!-- Suppliers Menu -->
                <a href="{{ route('suppliers.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <img src="{{ asset('assets/icons/supplier.png') }}" class="w-5 h-5" alt="Supplier Icon">
                    <span x-show="sidebarExpanded" class="ml-3">Suppliers</span>
                </a>

                <!-- Loan List Menu -->
                <a href="{{ route('loans.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <img src="{{ asset('assets/icons/loan.png') }}" class="w-5 h-5" alt="Loan Icon">
                    <span x-show="sidebarExpanded" class="ml-3">Loan List</span>
                </a>

                <!-- Prediction Menu -->
                <a href="{{ route('predictions.index') }}"
                    class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                    <img src="{{ asset('assets/icons/prediction.png') }}" class="w-5 h-5" alt="Prediction Icon">
                    <span x-show="sidebarExpanded" class="ml-3">Prediction</span>
                </a>
            </nav>

            <div class="px-4 py-3 mt-auto border-t border-orange-700">
                <button @click="showLogoutConfirm = true"
                    class="flex items-center w-full px-2 py-2 text-left transition-colors cursor-pointer hover:bg-orange-700">
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg> --}}
                    <img src="{{ asset('assets/icons/logout.png') }}" class="w-5 h-5" alt="LogOut Icon">
                    <span x-show="sidebarExpanded" class="ml-3">Logout</span>
                </button>
            </div>
        </aside>

        <div :class="sidebarExpanded ? 'ml-64' : 'ml-16'" class="min-h-screen transition-all duration-300">
            {{-- <header class="flex items-center justify-between px-6 py-4 bg-white border-b shadow-sm">
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-lg font-bold text-gray-700 hover:underline">FAQ</a>
                </div>
                <div class="flex items-center space-x-6">
                    <div class="relative" x-data="{ openDropdown: false }">
                        <!-- Trigger: Profile Image -->
                        <img @click="openDropdown = !openDropdown"
                            src="{{ Auth::user()->profile_image ? asset('storage/profile_images/' . Auth::user()->profile_image) : asset('assets/images/profile.png') }}"
                            alt="Profile"
                            class="w-10 h-10 transition duration-200 border-2 border-gray-300 rounded-full cursor-pointer hover:scale-105">

                        <!-- Dropdown -->
                        <div x-show="openDropdown" @click.away="openDropdown = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute right-0 z-50 w-64 mt-2 overflow-hidden bg-white rounded-lg shadow-xl">
                            <!-- Profile Section -->
                            <div class="px-5 py-4 text-center border-b bg-gray-50">
                                <img src="{{ Auth::user()->profile_image ? asset('storage/profile_images/' . Auth::user()->profile_image) : asset('assets/images/profile.png') }}"
                                    alt="Profile Image" class="mx-auto mb-2 border rounded-full w-14 h-14">
                                <p class="text-base font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                            </div>

                            <!-- Menu Items -->
                            <a href="{{ route('admin.profile') }}"
                                class="flex items-center px-4 py-3 text-sm text-gray-700 transition hover:bg-gray-100">
                                <img src="{{ asset('assets/icons/user-edit.png') }}" class="w-4 h-4 mr-2"
                                    alt="Edit Icon">
                                Edit Profil
                            </a>
                            <a href="{{ route('admin.password') }}"
                                class="flex items-center px-4 py-3 text-sm text-gray-700 transition hover:bg-gray-100">
                                <img src="{{ asset('assets/icons/lock.png') }}" class="w-4 h-4 mr-2"
                                    alt="Password Icon">
                                Ubah Password
                            </a>
                        </div>
                    </div>
                </div>
            </header>
            <main class="p-6">
                @yield('content')
                @yield('scripts')
            </main> --}}

            <!-- HEADER -->
            <header
                class="fixed top-0 left-0 right-0 z-40 flex items-center justify-between px-6 py-4 text-white bg-gray-300 border-b border-gray-700 shadow-sm dark:bg-gray-600">
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-lg font-bold hover:underline">FAQ</a>
                </div>
                <div class="flex items-center space-x-6">
                    <!-- Dark Mode Toggle -->
                    {{-- <button @click="darkMode = !darkMode"
                        class="flex items-center justify-center w-8 h-8 transition rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
                        <template x-if="!darkMode">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-800" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M12 2a1 1 0 01.993.883L13 3v2a1 1 0 01-1.993.117L11 5V3a1 1 0 011-1zm6.364 3.636a1 1 0 011.32-.083l.094.083 1.414 1.414a1 1 0 01-1.32 1.497l-.094-.083-1.414-1.414a1 1 0 010-1.414zM21 11a1 1 0 01.117 1.993L21 13h-2a1 1 0 01-.117-1.993L19 11h2zM12 17a1 1 0 01.993.883L13 18v2a1 1 0 01-1.993.117L11 20v-2a1 1 0 011-1zm-7.364-2.364a1 1 0 011.32.083l.094.083 1.414 1.414a1 1 0 01-1.32 1.497l-.094-.083-1.414-1.414a1 1 0 010-1.414zM4 11a1 1 0 01.117 1.993L4 13H2a1 1 0 01-.117-1.993L2 11h2zm1.636-7.364a1 1 0 01.083 1.32l-.083.094L4.222 6.464a1 1 0 01-1.497-1.32l.083-.094L5.05 3.636a1 1 0 011.414 0z" />
                            </svg>
                        </template>
                        <template x-if="darkMode">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-300" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M17.293 14.95a8 8 0 11-8.243-12.9 9 9 0 008.243 12.9zM12 22a9.99 9.99 0 01-8.485-4.686 10.002 10.002 0 0016.97-5.372A9.969 9.969 0 0122 12a10 10 0 01-10 10z"
                                    clip-rule="evenodd" />
                            </svg>
                        </template>
                    </button> --}}

                    <button @click="darkMode = !darkMode; window.darkMode = darkMode"
                        class="flex items-center justify-center w-8 h-8 transition rounded-full cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700">

                        <template x-if="!darkMode">
                            <img src="/assets/icons/moon.png" alt="Moon Icon" class="w-5 h-5">
                        </template>

                        <template x-if="darkMode">
                            <img src="/assets/icons/sun.png" alt="Sun Icon" class="w-5 h-5">
                        </template>

                    </button>

                    <!-- Notification Icon -->
                    {{-- <div class="relative">
                        <img src="{{ asset('assets/icons/notification.png') }}" alt="Notification"
                            class="w-6 h-6 transition cursor-pointer hover:scale-110">
                        <!-- You can add badge here later -->
                    </div> --}}

                    <!-- Notification Icon -->
                    <div class="relative">
                        <img :src="darkMode 
            ? '{{ asset('assets/icons/notification_white.png') }}' 
            : '{{ asset('assets/icons/notification.png') }}'" alt="Notification"
                            class="w-6 h-6 transition cursor-pointer hover:scale-110">
                        <!-- You can add badge here later -->
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ openDropdown: false }">
                        <img @click="openDropdown = !openDropdown"
                            src="{{ Auth::user()->profile_image ? asset('storage/profile_images/' . Auth::user()->profile_image) : asset('assets/images/profile.png') }}"
                            alt="Profile"
                            class="w-10 h-10 transition duration-200 border-2 border-white rounded-full cursor-pointer hover:scale-105">

                        <!-- Dropdown -->
                        <div x-show="openDropdown" @click.away="openDropdown = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute right-0 z-50 w-64 mt-2 overflow-hidden bg-white rounded-lg shadow-xl">
                            <!-- Profile Section -->
                            <div class="px-5 py-4 text-center border-b bg-gray-50">
                                <img src="{{ Auth::user()->profile_image ? asset('storage/profile_images/' . Auth::user()->profile_image) : asset('assets/images/profile.png') }}"
                                    alt="Profile Image" class="mx-auto mb-2 border rounded-full w-14 h-14">
                                <p class="text-base font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                            </div>

                            <!-- Menu Items -->
                            <a href="{{ route('admin.profile') }}"
                                class="flex items-center px-4 py-3 text-sm text-gray-700 transition hover:bg-gray-100">
                                <img src="{{ asset('assets/icons/user-edit.png') }}" class="w-4 h-4 mr-2"
                                    alt="Edit Icon">
                                Edit Profil
                            </a>
                            <a href="{{ route('admin.password') }}"
                                class="flex items-center px-4 py-3 text-sm text-gray-700 transition hover:bg-gray-100">
                                <img src="{{ asset('assets/icons/lock.png') }}" class="w-4 h-4 mr-2"
                                    alt="Password Icon">
                                Ubah Password
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- MAIN CONTENT -->
            <main class="p-6 pt-20">
                @yield('content')
                @yield('scripts')
            </main>
        </div>

        {{-- <div x-show="showLogoutConfirm"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
            --}}
            <div x-show="showLogoutConfirm" class="fixed inset-0 z-50 flex items-center justify-center"
                style="display: none; background-color: rgba(0, 0, 0, 0.5);">
                <div @click.away="showLogoutConfirm = false" class="w-full max-w-md p-6 bg-white rounded shadow-md">
                    <h2 class="mb-4 text-lg font-semibold">Konfirmasi Logout</h2>
                    <p class="mb-6">Apakah Anda ingin melakukan logout?</p>
                    <div class="flex justify-end space-x-4">
                        <button @click="showLogoutConfirm = false"
                            class="px-4 py-2 text-gray-700 bg-gray-200 rounded cursor-pointer hover:bg-gray-300">No</button>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 text-white bg-red-600 rounded cursor-pointer hover:bg-red-700">Yes</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
</body>
<script>
    // Inject Alpine darkMode value ke window agar bisa digunakan di chart script
    document.addEventListener('alpine:init', () => {
        Alpine.data('app', () => ({
            darkMode: JSON.parse(localStorage.getItem('darkMode') || 'false'),
        }));

        // Set window.darkMode agar bisa digunakan di luar Alpine
        window.darkMode = JSON.parse(localStorage.getItem('darkMode') || 'false');

        // Update value jika toggle darkMode berubah
        Alpine.effect(() => {
            window.darkMode = Alpine.store('darkMode');
        });
    });
</script>

</html>