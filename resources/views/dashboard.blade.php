@extends('layouts.app')

@section('content')
    <div class="min-h-screen p-6 bg-gray-50 dark:bg-gray-800">
        <h1 class="mb-6 text-3xl font-bold text-gray-800 dark:text-gray-200">Selamat Datang, {{ $userName }} 👋</h1>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-4">
            {{-- Total Buku --}}
            <div
                class="flex items-center justify-between p-6 shadow-md bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl">
                <div>
                    <h2 class="mb-1 text-lg font-semibold text-gray-100">Total Buku</h2>
                    <p class="text-3xl font-extrabold text-gray-100">{{ $totalBooks }}</p>
                </div>
                <img src="{{ asset('assets/icons/book.png') }}" alt="Book Icon" class="object-contain h-14 w-14">
            </div>

            {{-- Total Denda --}}
            <div
                class="flex items-center justify-between p-6 shadow-md bg-gradient-to-br from-red-400 to-red-500 rounded-xl">
                <div>
                    <h2 class="mb-1 text-lg font-semibold text-gray-100">Total Denda</h2>
                    <p class="text-3xl font-extrabold text-gray-100">Rp {{ number_format($totalFine, 0, ',', '.') }}</p>
                </div>
                <img src="{{ asset('assets/icons/fine.png') }}" alt="Fine Icon" class="object-contain h-14 w-14">
            </div>

            {{-- Total Anggota --}}
            <div
                class="flex items-center justify-between p-6 shadow-md bg-gradient-to-br from-green-400 to-green-500 rounded-xl">
                <div>
                    <h2 class="mb-1 text-lg font-semibold text-gray-100">Total Anggota</h2>
                    <p class="text-3xl font-extrabold text-gray-100">{{ $totalUsers }}</p>
                </div>
                <img src="{{ asset('assets/icons/user.png') }}" alt="User Icon" class="object-contain h-14 w-14">
            </div>

            {{-- Total Buku Dipinjam --}}
            <div
                class="flex items-center justify-between p-6 shadow-md bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl">
                <div>
                    <h2 class="mb-1 text-lg font-semibold text-gray-100">Total Buku Sedang Dipinjam</h2>
                    <p class="text-3xl font-extrabold text-gray-100">{{ $totalBorrowedBooks }}</p>
                </div>
                <img src="{{ asset('assets/icons/borrowed_book.png') }}" alt="Borrowed Icon"
                    class="object-contain h-14 w-14">
            </div>
        </div>

        {{-- Buku Telat dan Stok Menipis --}}
        <div class="grid grid-cols-1 gap-6 mb-10 md:grid-cols-2">
            {{-- Buku Telat Dikembalikan --}}
            <div
                class="flex items-center justify-between p-6 shadow-md bg-gradient-to-br from-purple-400 to-purple-500 rounded-xl">
                <div>
                    <h2 class="mb-1 text-lg font-semibold text-gray-100">Buku Telat Dikembalikan</h2>
                    <p class="text-3xl font-extrabold text-gray-100">{{ $overdueBooksCount }}</p>
                </div>
                <img src="{{ asset('assets/icons/overdue.png') }}" alt="Overdue Icon" class="object-contain h-14 w-14">
            </div>

            {{-- Buku Stok Menipis --}}
            <div
                class="flex items-center justify-between p-6 shadow-md bg-gradient-to-br from-pink-400 to-pink-500 rounded-xl">
                <div>
                    <h2 class="mb-1 text-lg font-semibold text-gray-100">Buku Stok Menipis (&lt; 5)</h2>
                    <p class="text-3xl font-extrabold text-gray-100">{{ $lowStockBooksCount }}</p>
                </div>
                <img src="{{ asset('assets/icons/low-stock.png') }}" alt="Low Stock Icon" class="object-contain h-14 w-14">
            </div>
        </div>

        {{-- Grafik --}}
        <div class="grid grid-cols-1 gap-6 mb-10 md:grid-cols-2">
            {{-- Grafik Peminjaman --}}
            <div class="p-6 bg-white shadow-md dark:bg-gray-700 rounded-xl">
                <h2 class="mb-4 text-xl font-bold text-gray-800 dark:text-gray-100">📈 Grafik Peminjaman per Bulan</h2>
                <canvas id="loanChart"></canvas>
            </div>

            {{-- Grafik Kategori --}}
            <div class="p-6 bg-white shadow-md dark:bg-gray-700 rounded-xl">
                <h2 class="mb-4 text-xl font-bold text-gray-800 dark:text-gray-100">📊 Top 5 Kategori Buku</h2>
                <div class="flex justify-center">
                    <canvas id="categoryChart" class="w-64 h-64"></canvas>
                </div>
            </div>
        </div>

        {{-- Daftar Buku dan Pengguna --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            {{-- Buku Paling Sering Dipinjam --}}
            <div class="p-6 bg-white shadow-md dark:bg-gray-700 rounded-xl">
                <h2 class="mb-4 text-xl font-bold text-gray-800 dark:text-gray-100">📚 Buku Paling Sering Dipinjam</h2>
                <ul class="space-y-2">
                    @forelse ($mostBorrowedBooks as $book)
                        <li class="flex items-center justify-between text-gray-700 dark:text-gray-200">
                            <span>{{ $book->title }}</span>
                            <span class="font-semibold">{{ $book->loan_count }}x</span>
                        </li>
                    @empty
                        <li class="text-gray-500 dark:text-gray-400">Tidak ada data.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Peminjam Paling Aktif --}}
            <div class="p-6 bg-white shadow-md dark:bg-gray-700 rounded-xl">
                <h2 class="mb-4 text-xl font-bold text-gray-800 dark:text-gray-100">👤 Peminjam Paling Aktif</h2>
                <ul class="space-y-3">
                    @forelse ($mostActiveUsers as $user)
                        <li class="flex items-center justify-between text-gray-700 dark:text-gray-200">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $user->profile_image ? Storage::disk('s3')->url('profile_images/' . $user->profile_image) : asset('assets/images/profile.png') }}"
                                    alt="User Photo" class="object-cover w-10 h-10 rounded-full">
                                <span>{{ $user->name }}</span>
                            </div>
                            <span class="font-semibold">{{ $user->loan_count }}x</span>
                        </li>
                    @empty
                        <li class="text-gray-500 dark:text-gray-400">Tidak ada data.</li>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>
@endsection

{{-- @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            function getChartColors(darkMode) {
                return {
                    text: darkMode ? '#E5E7EB' : '#374151',
                    grid: darkMode ? '#4B5563' : '#E5E7EB',
                    tooltipBg: darkMode ? '#1F2937' : '#FFFFFF',
                    tooltipText: darkMode ? '#F3F4F6' : '#111827',
                    datalabelText: darkMode ? '#F9FAFB' : '#111827',
                };
            }

            // Kita definisikan variabel di luar agar bisa diakses oleh Alpine effect
            let loanChart, categoryChart;
            const isDark = document.documentElement.classList.contains('dark');
            const colors = getChartColors(isDark);

            // --- FUNGSI UNTUK MEMBUAT CHART ---
            // Dibungkus fungsi agar bisa kita panggil dengan sedikit delay
            const initCharts = () => {
                // 1. Loan Chart
                const ctxLoan = document.getElementById('loanChart');
                if (ctxLoan) {
                    loanChart = new Chart(ctxLoan.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: {!! json_encode($chartLabels) !!},
                            datasets: [{
                                label: 'Jumlah Peminjaman',
                                data: {!! json_encode($chartData) !!},
                                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                                borderColor: 'rgba(59, 130, 246, 1)',
                                pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.3,
                            }]
                        },
                        options: {
                            responsive: true,
                            animation: {
                                duration: 1500,
                                easing: 'easeInOutQuart'
                            },
                            plugins: {
                                legend: {
                                    labels: {
                                        color: colors.text
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        color: colors.text
                                    },
                                    grid: {
                                        color: colors.grid
                                    }
                                },
                                x: {
                                    ticks: {
                                        color: colors.text
                                    },
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }

                // 2. Category Chart
                const ctxCategory = document.getElementById('categoryChart');
                if (ctxCategory) {
                    categoryChart = new Chart(ctxCategory.getContext('2d'), {
                        type: 'pie',
                        data: {
                            labels: {!! json_encode($categoryLabels) !!},
                            datasets: [{
                                data: {!! json_encode($categoryData) !!},
                                backgroundColor: {!! json_encode($categoryBgColors) !!},
                                borderColor: {!! json_encode($categoryBorderColors) !!},
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: {
                                animateRotate: true,
                                animateScale: true,
                                duration: 1500,
                                easing: 'easeOutBack'
                            },
                            plugins: {
                                legend: {
                                    position: 'right',
                                    labels: {
                                        color: colors.text
                                    }
                                },
                                datalabels: {
                                    color: colors.datalabelText,
                                    formatter: (val, ctx) => {
                                        return {!! json_encode($categoryPercentages) !!}[ctx.dataIndex] + '%';
                                    },
                                    font: {
                                        weight: 'bold',
                                        size: 12
                                    }
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                }
            };

            // --- EKSEKUSI DENGAN DELAY ---
            // Delay 100ms memberikan waktu bagi browser untuk merender Canvas sepenuhnya
            setTimeout(initCharts, 100);

            // --- LOGIKA UPDATE TEMA ---
            Alpine.effect(() => {
                const darkModeActive = Alpine.store('theme').dark;
                const newColors = getChartColors(darkModeActive);

                // Pastikan chart sudah terinisialisasi sebelum diupdate
                if (loanChart && categoryChart) {
                    [loanChart, categoryChart].forEach(chart => {
                        chart.options.plugins.legend.labels.color = newColors.text;
                        if (chart.options.plugins.datalabels) chart.options.plugins.datalabels
                            .color = newColors.datalabelText;
                        if (chart.options.scales) {
                            Object.values(chart.options.scales).forEach(s => {
                                if (s.ticks) s.ticks.color = newColors.text;
                                if (s.grid) s.grid.color = newColors.grid;
                            });
                        }
                        chart.update('none'); // Update instan tanpa trigger animasi ulang
                    });
                }
            });
        });
    </script>
@endsection --}}

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <script>
        // Gunakan let agar bisa diakses antar scope
        let loanChart, categoryChart;

        function getChartColors(darkMode) {
            return {
                text: darkMode ? '#E5E7EB' : '#374151',
                grid: darkMode ? '#4B5563' : '#E5E7EB',
                tooltipBg: darkMode ? '#1F2937' : '#FFFFFF',
                tooltipText: darkMode ? '#F3F4F6' : '#111827',
                datalabelText: darkMode ? '#F9FAFB' : '#111827',
            };
        }

        // FUNGSI RENDER UTAMA
        function renderCharts() {
            const isDark = document.documentElement.classList.contains('dark');
            const colors = getChartColors(isDark);

            // 1. Loan Chart
            const ctxLoan = document.getElementById('loanChart');
            if (ctxLoan && !loanChart) {
                loanChart = new Chart(ctxLoan.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($chartLabels) !!},
                        datasets: [{
                            label: 'Jumlah Peminjaman',
                            data: {!! json_encode($chartData) !!},
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.3,
                        }]
                    },
                    options: {
                        responsive: true,
                        animation: { duration: 1500, easing: 'easeInOutQuart' },
                        plugins: { legend: { labels: { color: colors.text } } },
                        scales: {
                            y: { beginAtZero: true, ticks: { color: colors.text }, grid: { color: colors.grid } },
                            x: { ticks: { color: colors.text }, grid: { display: false } }
                        }
                    }
                });
            }

            // 2. Category Chart
            const ctxCategory = document.getElementById('categoryChart');
            if (ctxCategory && !categoryChart) {
                categoryChart = new Chart(ctxCategory.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: {!! json_encode($categoryLabels) !!},
                        datasets: [{
                            data: {!! json_encode($categoryData) !!},
                            backgroundColor: {!! json_encode($categoryBgColors) !!},
                            borderColor: {!! json_encode($categoryBorderColors) !!},
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            animateRotate: true,
                            animateScale: true,
                            duration: 1500,
                            easing: 'easeOutBack'
                        },
                        plugins: {
                            legend: { position: 'right', labels: { color: colors.text } },
                            datalabels: {
                                color: colors.datalabelText,
                                formatter: (val, ctx) => {
                                    return {!! json_encode($categoryPercentages) !!}[ctx.dataIndex] + '%';
                                },
                                font: { weight: 'bold', size: 12 }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
            }
        }

        // Jalankan saat DOM siap
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', renderCharts);
        } else {
            renderCharts();
        }

        // Integrasi dengan Alpine Store untuk toggle tema
        document.addEventListener('alpine:init', () => {
            Alpine.effect(() => {
                // Pastikan Alpine Store tema sudah ada
                if (Alpine.store('theme')) {
                    const darkModeActive = Alpine.store('theme').dark;
                    const newColors = getChartColors(darkModeActive);

                    if (loanChart && categoryChart) {
                        [loanChart, categoryChart].forEach(chart => {
                            chart.options.plugins.legend.labels.color = newColors.text;
                            if (chart.options.plugins.datalabels) chart.options.plugins.datalabels.color = newColors.datalabelText;
                            if (chart.options.scales) {
                                Object.values(chart.options.scales).forEach(s => {
                                    if (s.ticks) s.ticks.color = newColors.text;
                                    if (s.grid) s.grid.color = newColors.grid;
                                });
                            }
                            chart.update('none'); // Update instan saat toggle tema
                        });
                    }
                }
            });
        });
    </script>
@endsection
