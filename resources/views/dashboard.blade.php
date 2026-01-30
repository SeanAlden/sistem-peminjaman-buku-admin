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

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        // document.addEventListener('alpine:init', () => {
        //     // --- PERBAIKAN UTAMA: Seluruh logika grafik dimasukkan ke dalam event listener Alpine ---

        //     function getChartColors(darkMode) {
        //         return {
        //             text: darkMode ? '#E5E7EB' : '#374151',
        //             grid: darkMode ? '#4B5563' : '#E5E7EB',
        //             tooltipBg: darkMode ? '#1F2937' : '#FFFFFF',
        //             // --- PERBAIKAN 1: Membuat warna tooltip dinamis ---
        //             tooltipText: darkMode ? '#F3F4F6' : '#111827', // Terang saat dark, Gelap saat light
        //             datalabelText: darkMode ? '#F9FAFB' : '#111827',
        //         };
        //     }

        //     const initialDarkMode = document.documentElement.classList.contains('dark');
        //     let colors = getChartColors(initialDarkMode);

        //     // --- Chart Peminjaman (Loan Chart) ---
        //     const ctxLoan = document.getElementById('loanChart').getContext('2d');
        //     const loanChart = new Chart(ctxLoan, {
        //         type: 'line',
        //         data: {
        //             labels: {!! json_encode($chartLabels) !!},
        //             datasets: [{
        //                 label: 'Jumlah Peminjaman',
        //                 data: {!! json_encode($chartData) !!},
        //                 backgroundColor: 'rgba(59, 130, 246, 0.2)',
        //                 borderColor: 'rgba(59, 130, 246, 1)',
        //                 pointBackgroundColor: 'rgba(59, 130, 246, 1)',
        //                 borderWidth: 2,
        //                 fill: true,
        //                 tension: 0.3,
        //                 pointRadius: 5,
        //                 pointHoverRadius: 7
        //             }]
        //         },
        //         options: {
        //             responsive: true,
        //             animation: {
        //                 duration: 2000, // Durasi 2 detik
        //                 easing: 'easeInOutQuart', // Efek halus saat mulai dan selesai
        //             },
        //             plugins: {
        //                 legend: {
        //                     labels: {
        //                         color: colors.text
        //                     }
        //                 },
        //                 tooltip: {
        //                     backgroundColor: colors.tooltipBg,
        //                     titleColor: colors.tooltipText,
        //                     bodyColor: colors.tooltipText,
        //                     borderColor: colors.grid,
        //                     borderWidth: 1,
        //                 }
        //             },
        //             scales: {
        //                 y: {
        //                     beginAtZero: true,
        //                     ticks: {
        //                         stepSize: 1,
        //                         color: colors.text
        //                     },
        //                     grid: {
        //                         color: colors.grid
        //                     }
        //                 },
        //                 x: {
        //                     ticks: {
        //                         color: colors.text
        //                     },
        //                     grid: {
        //                         display: false
        //                     }
        //                 }
        //             }
        //         }
        //     });

        //     // --- Chart Kategori (Category Chart) ---
        //     const ctxCategory = document.getElementById('categoryChart').getContext('2d');
        //     const categoryChart = new Chart(ctxCategory, {
        //         type: 'pie',
        //         data: {
        //             labels: {!! json_encode($categoryLabels) !!},
        //             datasets: [{
        //                 data: {!! json_encode($categoryData) !!},
        //                 backgroundColor: {!! json_encode($categoryBgColors) !!},
        //                 borderColor: {!! json_encode($categoryBorderColors) !!},
        //                 borderWidth: 1
        //             }]
        //         },
        //         options: {
        //             responsive: true,
        //             maintainAspectRatio: false,
        //             animation: {
        //                 animateRotate: true, // Animasi berputar saat muncul
        //                 animateScale: true, // Animasi mengembang dari tengah
        //                 duration: 2000,
        //                 easing: 'easeOutBounce' // Memberikan sedikit efek "membal" di akhir
        //             },
        //             plugins: {
        //                 legend: {
        //                     position: 'right',
        //                     labels: {
        //                         color: colors.text
        //                     }
        //                 },
        //                 tooltip: {
        //                     backgroundColor: colors.tooltipBg,
        //                     titleColor: colors.tooltipText,
        //                     bodyColor: colors.tooltipText,
        //                 },
        //                 datalabels: {
        //                     color: colors.datalabelText,
        //                     formatter: (value, context) => {
        //                         const percentage = {!! json_encode($categoryPercentages) !!}[context.dataIndex];
        //                         return percentage + '%';
        //                     },
        //                     font: {
        //                         weight: 'bold',
        //                         size: 14
        //                     }
        //                 }
        //             }
        //         },
        //         plugins: [ChartDataLabels]
        //     });

        //     // --- Event Listener untuk Dark Mode Toggle ---
        //     // document.addEventListener('alpine:init', () => {
        //     //     Alpine.effect(() => {
        //     //         const newDarkMode = document.documentElement.classList.contains('dark');
        //     //         const newColors = getChartColors(newDarkMode);

        //     //         [loanChart, categoryChart].forEach(chart => {
        //     //             // Update warna umum
        //     //             chart.options.plugins.legend.labels.color = newColors.text;
        //     //             chart.options.plugins.tooltip.backgroundColor = newColors.tooltipBg;
        //     //             chart.options.plugins.tooltip.titleColor = newColors.tooltipText;
        //     //             chart.options.plugins.tooltip.bodyColor = newColors.tooltipText;

        //     //             // --- PERBAIKAN 2: Tambahkan update untuk Datalabels ---
        //     //             if (chart.options.plugins.datalabels) {
        //     //                 chart.options.plugins.datalabels.color = newColors.datalabelText;
        //     //             }

        //     //             // Update warna sumbu (hanya untuk line chart)
        //     //             if (chart.options.scales) {
        //     //                 Object.values(chart.options.scales).forEach(scale => {
        //     //                     if (scale.ticks) scale.ticks.color = newColors.text;
        //     //                     if (scale.grid) scale.grid.color = newColors.grid;
        //     //                 });
        //     //             }

        //     //             chart.update();
        //     //         });
        //     //     });
        //     // });

        //     // Ini adalah bagian kuncinya:
        //     // Alpine.effect() akan secara otomatis berjalan setiap kali
        //     // state di dalam store ('theme.dark') berubah.
        //     Alpine.effect(() => {
        //         const newDarkMode = Alpine.store('theme').dark;
        //         const newColors = getChartColors(newDarkMode);

        //         console.log('Dark mode changed, updating charts...');

        //         [loanChart, categoryChart].forEach(chart => {
        //             // Update semua warna yang diperlukan
        //             chart.options.plugins.legend.labels.color = newColors.text;
        //             chart.options.plugins.tooltip.backgroundColor = newColors.tooltipBg;
        //             chart.options.plugins.tooltip.titleColor = newColors.tooltipText;
        //             chart.options.plugins.tooltip.bodyColor = newColors.tooltipText;

        //             if (chart.options.plugins.datalabels) {
        //                 chart.options.plugins.datalabels.color = newColors.datalabelText;
        //             }

        //             if (chart.options.scales) {
        //                 Object.values(chart.options.scales).forEach(scale => {
        //                     if (scale.ticks) scale.ticks.color = newColors.text;
        //                     if (scale.grid) scale.grid.color = newColors.grid;
        //                 });
        //             }

        //             chart.update('none');
        //         });
        //     });
        // });

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

            const initialDarkMode = document.documentElement.classList.contains('dark');
            let colors = getChartColors(initialDarkMode);

            // --- 1. Konfigurasi Loan Chart ---
            const ctxLoan = document.getElementById('loanChart').getContext('2d');
            const loanChart = new Chart(ctxLoan, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: {!! json_encode($chartData) !!},
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        fill: true,
                        tension: 0.3,
                    }]
                },
                options: {
                    responsive: true,
                    // Animasi masuk
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutQuart'
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: colors.text
                            }
                        },
                    },
                    scales: {
                        y: {
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

            // --- 2. Konfigurasi Category Chart ---
            const ctxCategory = document.getElementById('categoryChart').getContext('2d');
            const categoryChart = new Chart(ctxCategory, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($categoryLabels) !!},
                    datasets: [{
                        data: {!! json_encode($categoryData) !!},
                        backgroundColor: {!! json_encode($categoryBgColors) !!},
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    // Animasi masuk khusus Pie
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 2000,
                        easing: 'easeOutBounce'
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

            // --- 3. Logika Update Tema (Alpine Effect) ---
            let isInitialLoad = true;

            Alpine.effect(() => {
                const newDarkMode = Alpine.store('theme').dark;
                const newColors = getChartColors(newDarkMode);

                // Jangan update warna di milidetik pertama agar animasi initial tidak terputus
                const updateMode = isInitialLoad ? 'default' : 'none';

                [loanChart, categoryChart].forEach(chart => {
                    chart.options.plugins.legend.labels.color = newColors.text;
                    if (chart.options.plugins.datalabels) chart.options.plugins.datalabels.color =
                        newColors.datalabelText;

                    if (chart.options.scales) {
                        Object.values(chart.options.scales).forEach(scale => {
                            if (scale.ticks) scale.ticks.color = newColors.text;
                            if (scale.grid) scale.grid.color = newColors.grid;
                        });
                    }

                    // Tambahkan sedikit delay agar animasi render pertama selesai
                    setTimeout(() => {
                        chart.update(updateMode);
                        isInitialLoad = false;
                    }, 100);
                });
            });
        });
    </script>
@endsection
