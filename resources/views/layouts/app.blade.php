<!DOCTYPE html>

{{-- <html lang="en" x-data="{ darkMode: JSON.parse(localStorage.getItem('darkMode') || 'false') }"
    x-init="$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{ 'dark': darkMode }"> --}}

<html lang="en" x-data="{}" :class="{ 'dark': $store.theme.dark }">

<head>
    <meta charset="UTF-8">
    <title>Sistem Peminjaman Buku</title>
    @vite('resources/css/app.css')
    @vite(['resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900">
    <div x-data="{ sidebarOpen: false, sidebarExpanded: true, showLogoutConfirm: false }">
        {{-- <aside :class="sidebarExpanded ? 'w-64' : 'w-16'"
            class="fixed top-0 z-50 flex flex-col h-full text-white transition-all duration-300 bg-orange-800"> --}}
            <aside :class="sidebarExpanded ? 'w-64' : 'w-16'"
                class="fixed top-0 z-50 flex flex-col h-full text-white transition-all duration-300 shadow-lg bg-gradient-to-b from-orange-700 to-orange-900">
                <div class="flex items-center justify-between px-4 py-4 border-b border-orange-700">
                    <div class="flex items-center space-x-4">
                        <img x-show="sidebarExpanded" src="{{ asset('assets/icons/book_logo.png') }}" class="w-14 h-14"
                            alt="Library Icon">
                        <span x-show="sidebarExpanded" class="text-lg font-semibold text-yellow-300">ᒪIᗷᖇᗩᖇY</span>
                    </div>
                    <button @click="sidebarExpanded = !sidebarExpanded"
                        class="text-white cursor-pointer focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                {{-- <div class="flex-1 overflow-y-auto"> --}}
                    <div
                        class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-orange-600 scrollbar-track-orange-900/30">
                        <nav class="mt-4 space-y-1">
                            <!-- Dashboard Menu -->
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                                <img src="{{ asset('assets/icons/dashboard.png') }}" class="w-5 h-5"
                                    alt="Dashboard Icon">
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
                                        class="w-4 h-4 ml-auto transition-transform transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
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

                            <!-- Employees Menu -->
                            <a href="{{ route('employees.index') }}"
                                class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                                <img src="{{ asset('assets/icons/employee.png') }}" class="w-5 h-5" alt="Supplier Icon">
                                <span x-show="sidebarExpanded" class="ml-3">Employees</span>
                            </a>

                            <!-- Payroll Menu -->
                            <a href="{{ route('payrolls.index') }}"
                                class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                                <img src="{{ asset('assets/icons/payroll.png') }}" class="w-5 h-5" alt="Supplier Icon">
                                <span x-show="sidebarExpanded" class="ml-3">Payrolls</span>
                            </a>

                            <!-- Loan List Menu -->
                            <a href="{{ route('loans.index') }}"
                                class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                                <img src="{{ asset('assets/icons/loan.png') }}" class="w-5 h-5" alt="Loan Icon">
                                <span x-show="sidebarExpanded" class="ml-3">Loan List</span>
                            </a>

                            <!-- Account List Menu -->
                            <a href="{{ route('accounts.index') }}"
                                class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                                <img src="{{ asset('assets/icons/account.png') }}" class="w-5 h-5" alt="Loan Icon">
                                <span x-show="sidebarExpanded" class="ml-3">Account List</span>
                            </a>

                            <!-- Transaction List Menu -->
                            <a href="{{ route('transactions.index') }}"
                                class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                                <img src="{{ asset('assets/icons/transaction.png') }}" class="w-5 h-5" alt="Loan Icon">
                                <span x-show="sidebarExpanded" class="ml-3">Transaction List</span>
                            </a>

                            <!-- Payment List Menu -->
                            <a href="{{ route('payments.index') }}"
                                class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                                <img src="{{ asset('assets/icons/payment.png') }}" class="w-5 h-5" alt="Loan Icon">
                                <span x-show="sidebarExpanded" class="ml-3">Payment List</span>
                            </a>

                            <!-- Prediction Menu -->
                            <a href="{{ route('predictions.index') }}"
                                class="flex items-center px-4 py-3 transition-colors hover:bg-orange-700">
                                <img src="{{ asset('assets/icons/prediction.png') }}" class="w-5 h-5"
                                    alt="Prediction Icon">
                                <span x-show="sidebarExpanded" class="ml-3">Prediction</span>
                            </a>
                        </nav>
                    </div>

                    <div class="px-4 py-3 mt-auto border-t border-orange-700">
                        <button @click="showLogoutConfirm = true"
                            class="flex items-center w-full px-2 py-2 text-left transition-colors cursor-pointer hover:bg-orange-700">
                            <img src="{{ asset('assets/icons/logout.png') }}" class="w-5 h-5" alt="LogOut Icon">
                            <span x-show="sidebarExpanded" class="ml-3">Logout</span>
                        </button>
                    </div>
            </aside>

            <div :class="sidebarExpanded ? 'ml-64' : 'ml-16'" class="min-h-screen transition-all duration-300">
                <!-- HEADER -->
                <header
                    class="fixed top-0 left-0 right-0 z-40 flex items-center justify-between px-6 py-4 text-gray-800 shadow-md dark:text-white bg-gradient-to-r from-gray-300 to-gray-400 dark:from-gray-300 dark:to-gray-400">
                    <div class="flex items-center space-x-4">
                        <a href="#" class="text-lg font-bold hover:underline">FAQ</a>
                    </div>
                    <div class="flex items-center space-x-6">
                        <!-- Dark Mode Toggle -->
                        <button @click="$store.theme.toggle()"
                            class="flex items-center justify-center w-8 h-8 transition rounded-full cursor-pointer hover:bg-blue-200 dark:hover:bg-blue-700">

                            {{-- Ganti x-if menjadi x-show dan baca dari store --}}
                            <img x-show="!$store.theme.dark" src="/assets/icons/moon.png" alt="Moon Icon"
                                class="w-5 h-5">
                            <img x-show="$store.theme.dark" src="/assets/icons/sun.png" alt="Sun Icon" class="w-5 h-5"
                                style="display: none;">
                        </button>

                        <!-- Notification Icon -->
                        {{-- <div class="relative">
                            <img :src="darkMode ? '{{ asset('assets/icons/notification_white.png') }}' : '{{ asset('assets/icons/notification.png') }}'"
                                alt="Notification" class="w-6 h-6 transition cursor-pointer hover:scale-110">
                            <!-- You can add badge here later -->
                        </div> --}}

                        {{-- <div class="relative">
                            <img src="{{ asset('assets/icons/notification.png') }}" alt="Notification"
                                class="w-6 h-6 transition cursor-pointer hover:scale-110">
                            <!-- You can add badge here later -->
                        </div> --}}

                        <!-- Notification Icon -->
                        {{-- <div class="relative" x-data="{ openNotif: false, notifications: [], count: 0 }" x-init="
                                    Echo.channel('notifications')
                                        .listen('.new-notification', (e) => {
                                            fetch('{{ route('notifications.fetch') }}')
                                                .then(res => res.json())
                                                .then(data => {
                                                    notifications = data.notifications;
                                                    count = data.count;
                                                });
                                        });

                                    fetch('{{ route('notifications.fetch') }}')
                                        .then(res => res.json())
                                        .then(data => {
                                            notifications = data.notifications;
                                            count = data.count;
                                        });
                                ">
                            <button @click="openNotif = !openNotif" class="relative">
                                <img src="{{ asset('assets/icons/notification.png') }}" alt="Notification"
                                    class="transition cursor-pointer h-7 w-7 hover:scale-110">
                                <!-- Badge -->
                                <span x-show="count > 0"
                                    class="absolute -top-2 -right-2 text-xs font-bold text-white bg-red-600 rounded-full px-1.5">
                                    <span x-text="count > 10 ? '10+' : count"></span>
                                </span>
                            </button>

                            <!-- Popup -->
                            <div x-show="openNotif" @click.away="openNotif = false"
                                class="absolute right-0 mt-2 bg-white rounded-lg shadow-lg w-80">
                                <div class="p-3 border-b">
                                    <h3 class="text-sm font-semibold">Notifications</h3>
                                </div>
                                <ul>
                                    <template x-for="notif in notifications" :key="notif.id">
                                        <li class="px-4 py-2 border-b">
                                            <p class="text-sm font-medium" x-text="notif.title"></p>
                                            <p class="text-xs text-gray-600" x-text="notif.message"></p>
                                        </li>
                                    </template>
                                </ul>
                                <div class="p-2 text-center">
                                    <a href="{{ route('notifications.index') }}"
                                        class="text-sm text-blue-600 hover:underline">See All</a>
                                </div>
                            </div>
                        </div> --}}

                        <!-- Notification Icon -->
                        <div class="relative" x-data="{
                        openNotif: false,
                        notifications: [],
                        count: 0,
                        fetchData() {
                            fetch('{{ route('notifications.fetch') }}')
                                .then(res => res.json())
                                .then(data => {
                                    this.notifications = data.notifications;
                                    this.count = data.count;
                                });
                        }
                     }" x-init="
                        fetchData();
                        window.Echo.channel('notifications')
                                .listen('.new-notification', (e) => {
                                    console.log('Notif Event Received:', e);
                                    fetchData();
                                });
                        ">
                            <button @click="openNotif = !openNotif" class="relative">
                                {{-- <img src="{{ asset('assets/icons/notification.png') }}" alt="Notification"
                                    class="w-6 h-6 transition cursor-pointer hover:scale-110"> --}}
                                <img :src="$store.theme.dark ? '{{ asset('assets/icons/notification_white.png') }}' : '{{ asset('assets/icons/notification.png') }}'"
                                    alt="Notification" class="w-6 h-6 transition cursor-pointer hover:scale-110">
                                <!-- Badge -->
                                <span x-show="count > 0" class="absolute -top-3 -right-3 min-w-[20px] h-[20px] flex items-center justify-center
       text-sm font-bold text-white bg-red-600 rounded-full px-2 shadow-xl shadow-red-500/50 border border-white">
                                    <span x-text="count > 10 ? '10+' : count"></span>
                                </span>
                            </button>

                            <!-- Popup -->
                            <div x-show="openNotif" @click.away="openNotif = false"
                                class="absolute right-0 mt-2 bg-white rounded-lg shadow-lg w-80">
                                <div class="p-3 border-b dark:border-black">
                                    <h3 class="text-sm font-semibold dark:text-black">Notifications</h3>
                                </div>
                                <ul>
                                    <template x-for="notif in notifications" :key="notif.id">
                                        <li class="px-4 py-2 border-b dark:border-black">
                                            <p class="text-sm font-medium dark:text-black" x-text="notif.title"></p>
                                            <p class="text-xs text-gray-600 dark:text-black" x-text="notif.message"></p>
                                        </li>
                                    </template>
                                </ul>
                                <div class="p-2 text-center">
                                    <a href="{{ route('notifications.index') }}"
                                        class="text-sm text-blue-600 hover:underline">See All</a>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Dropdown -->
                        <div class="relative" x-data="{ openDropdown: false }">
                            {{-- <img @click="openDropdown = !openDropdown"
                                src="{{ Auth::user()->profile_image ? asset('storage/profile_images/' . Auth::user()->profile_image) : asset('assets/images/profile.png') }}"
                                alt="Profile"
                                class="w-10 h-10 transition duration-200 border-2 border-white rounded-full cursor-pointer hover:scale-105"> --}}

                                <img @click="openDropdown = !openDropdown"
                                src="{{ Auth::user()->profile_image ? Storage::disk('s3')->url(Auth::user()->profile_image) : asset('assets/images/profile.png') }}"
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
                                    <img src="{{ Auth::user()->profile_image ? Storage::disk('s3')->url(Auth::user()->profile_image) : asset('assets/images/profile.png') }}"
                                        alt="Profile Image" class="mx-auto mb-2 border rounded-full w-14 h-14">
                                    <p class="text-base font-semibold text-gray-800">{{ Auth::user()->name }}
                                    </p>
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
                </main>
            </div>
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
    {{-- 1. Definisikan Alpine Store di sini --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                // Ambil state awal dari localStorage
                dark: JSON.parse(localStorage.getItem('darkMode') || 'false'),

                // Buat method untuk toggle
                toggle() {
                    this.dark = !this.dark;
                }
            });

            // Gunakan Alpine.effect untuk mengawasi perubahan dan menyimpannya ke localStorage
            Alpine.effect(() => {
                localStorage.setItem('darkMode', JSON.stringify(Alpine.store('theme').dark));
            });
        });
    </script>
    {{-- Section scripts dipindah ke sini agar bisa mengakses store --}}
    @yield(section: 'scripts')
</body>

</html>
