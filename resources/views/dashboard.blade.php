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

            {{-- Total Pengguna --}}
            <div
                class="flex items-center justify-between p-6 shadow-md bg-gradient-to-br from-green-400 to-green-500 rounded-xl">
                <div>
                    <h2 class="mb-1 text-lg font-semibold text-gray-100">Total Pengguna</h2>
                    <p class="text-3xl font-extrabold text-gray-100">{{ $totalUsers }}</p>
                </div>
                <img src="{{ asset('assets/icons/user.png') }}" alt="User Icon" class="object-contain h-14 w-14">
            </div>

            {{-- Total Buku Dipinjam --}}
            <div
                class="flex items-center justify-between p-6 shadow-md bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl">
                <div>
                    <h2 class="mb-1 text-lg font-semibold text-gray-100">Total Buku Dipinjam</h2>
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
                {{-- <canvas id="categoryChart"></canvas> --}}
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
                    @foreach ($mostBorrowedBooks as $book)
                        <li class="flex items-center justify-between text-gray-700 dark:text-gray-200">
                            <span>{{ $book->title }}</span>
                            <span class="font-semibold">{{ $book->loan_count }}x</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Peminjam Paling Aktif --}}
            <div class="p-6 bg-white shadow-md dark:bg-gray-700 rounded-xl">
                <h2 class="mb-4 text-xl font-bold text-gray-800 dark:text-gray-100">👤 Peminjam Paling Aktif</h2>
                <ul class="space-y-3">
                    @foreach ($mostActiveUsers as $user)
                        <li class="flex items-center justify-between text-gray-700 dark:text-gray-200">
                            <div class="flex items-center space-x-3">
                                <img src="{{ asset('public/storage/' . $user->profile_image) }}" alt="User Photo"
                                    class="object-cover w-10 h-10 rounded-full"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/images/profile.png') }}';">
                                <span>{{ $user->name }}</span>
                            </div>
                            <span class="font-semibold">{{ $user->loan_count }}x</span>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <script>
        // function getChartColors(darkMode) {
        //     return {
        //         text: darkMode ? '#E5E7EB' : '#374151',
        //         grid: darkMode ? '#4B5563' : '#E5E7EB',
        //         tooltipBg: darkMode ? '#1F2937' : '#F9FAFB',
        //         tooltipText: '#F3F4F6',
        //     };
        // }

        function getChartColors(darkMode) {
            return {
                text: darkMode ? '#E5E7EB' : '#374151',
                grid: darkMode ? '#4B5563' : '#E5E7EB',
                tooltipBg: darkMode ? '#1F2937' : '#F9FAFB',
                tooltipText: '#F3F4F6',
                datalabelText: darkMode ? '#F9FAFB' : '#111827',
            };
        }

        // const darkMode = window.darkMode ?? false;
        const darkMode = document.documentElement.classList.contains('dark');

        const colors = getChartColors(darkMode);

        const ctx = document.getElementById('loanChart').getContext('2d');
        const loanChart = new Chart(ctx, {
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
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: colors.text
                        }
                    },
                    tooltip: {
                        backgroundColor: colors.tooltipBg,
                        titleColor: colors.tooltipText,
                        bodyColor: colors.tooltipText,
                        borderColor: colors.grid,
                        borderWidth: 1,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            color: colors.text,
                            font: { size: 12 }
                        },
                        grid: {
                            color: colors.grid
                        }
                    },
                    x: {
                        ticks: {
                            color: colors.text,
                            font: { size: 12 }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        const ctx2 = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(ctx2, {
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
                maintainAspectRatio: false, // penting biar bisa kontrol tinggi manual
                aspectRatio: 1, // 1 = persegi, bisa ubah jadi 0.8 / 1.2 sesuai kebutuhan
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { color: colors.text }
                    },
                    tooltip: {
                        backgroundColor: colors.tooltipBg,
                        titleColor: colors.tooltipText,
                        bodyColor: colors.tooltipText,
                    },
                    datalabels: {
                        // color: '#fff',
                        color: colors.datalabelText,
                        formatter: (value, context) => {
                            const percentage = {!! json_encode($categoryPercentages) !!}[context.dataIndex];
                            return percentage + '%';
                        },
                        font: {
                            weight: 'bold',
                            size: 14
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        document.addEventListener('alpine:init', () => {
            Alpine.effect(() => {
                // const newDarkMode = Alpine.store('darkMode');
                const newDarkMode = Alpine.store?.('darkMode') ?? document.documentElement.classList.contains('dark');

                const newColors = getChartColors(newDarkMode);

                [loanChart, categoryChart].forEach(chart => {
                    if (chart.options.plugins.legend.labels)
                        chart.options.plugins.legend.labels.color = newColors.text;
                    if (chart.options.plugins.tooltip) {
                        chart.options.plugins.tooltip.backgroundColor = newColors.tooltipBg;
                        chart.options.plugins.tooltip.titleColor = newColors.tooltipText;
                        chart.options.plugins.tooltip.bodyColor = newColors.tooltipText;
                        chart.options.plugins.tooltip.borderColor = newColors.grid;
                    }
                    if (chart.options.scales) {
                        Object.values(chart.options.scales).forEach(scale => {
                            if (scale.ticks) scale.ticks.color = newColors.text;
                            if (scale.grid) scale.grid.color = newColors.grid;
                        });
                    }
                    chart.update();
                });
            });
        });
    </script>
@endsection