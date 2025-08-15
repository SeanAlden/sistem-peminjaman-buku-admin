@extends('layouts.app')

@section('content')
    <div class="p-6 bg-gray-50 min-h-screen dark:bg-gray-800">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-200">Selamat Datang, {{ $userName }} 👋</h1>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            {{-- Total Buku --}}
            <div
                class="bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl shadow-md p-6 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold text-gray-100 mb-1">Total Buku</h2>
                    <p class="text-3xl font-extrabold text-gray-100">{{ $totalBooks }}</p>
                </div>
                <img src="{{ asset('assets/icons/book.png') }}" alt="Book Icon" class="h-14 w-14 object-contain">
            </div>

            {{-- Total Denda --}}
            <div
                class="bg-gradient-to-br from-red-400 to-red-500 rounded-xl shadow-md p-6 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold text-gray-100 mb-1">Total Denda</h2>
                    <p class="text-3xl font-extrabold text-gray-100">Rp {{ number_format($totalFine, 0, ',', '.') }}</p>
                </div>
                <img src="{{ asset('assets/icons/fine.png') }}" alt="Fine Icon" class="h-14 w-14 object-contain">
            </div>

            {{-- Total Pengguna --}}
            <div
                class="bg-gradient-to-br from-green-400 to-green-500 rounded-xl shadow-md p-6 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold text-gray-100 mb-1">Total Pengguna</h2>
                    <p class="text-3xl font-extrabold text-gray-100">{{ $totalUsers }}</p>
                </div>
                <img src="{{ asset('assets/icons/user.png') }}" alt="User Icon" class="h-14 w-14 object-contain">
            </div>

            {{-- Total Buku Dipinjam --}}
            <div
                class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl shadow-md p-6 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold text-gray-100 mb-1">Total Buku Dipinjam</h2>
                    <p class="text-3xl font-extrabold text-gray-100">{{ $totalBorrowedBooks }}</p>
                </div>
                <img src="{{ asset('assets/icons/borrowed_book.png') }}" alt="Borrowed Icon"
                    class="h-14 w-14 object-contain">
            </div>
        </div>

        {{-- Line Chart --}}
        {{-- <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">📈 Grafik Peminjaman per Bulan</h2>
            <canvas id="loanChart" height="100"></canvas>
        </div> --}}

        {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6"> --}}
            {{-- Line Chart --}}
            {{-- <div class="bg-white rounded-xl shadow p-6"> --}}
                {{-- <h2 class="text-lg font-semibold text-gray-800 mb-4">📈 Grafik Peminjaman per Bulan</h2> --}}
                {{-- <canvas id="loanChart" height="100"></canvas> --}}
                {{-- </div> --}}

            {{-- Pie Chart Kategori Terbanyak --}}
            {{-- <div class="bg-white rounded-xl shadow p-6"> --}}
                {{-- <h2 class="text-lg font-semibold text-gray-800 mb-4">📊 5 Kategori Terpopuler</h2> --}}
                {{-- <canvas id="categoryChart" height="100"></canvas> --}}
                {{-- </div> --}}
            {{-- </div> --}}

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            {{-- Line Chart - diperbesar col-span 2 --}}
            <div class="md:col-span-2 bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">📈 Grafik Peminjaman per Bulan</h2>
                <canvas id="loanChart" height="140"></canvas>
            </div>

            {{-- Pie Chart - diperkecil --}}
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center justify-center">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 text-center">📊 5 Kategori Terpopuler</h2>
                {{-- <div class="w-48 h-48 relative"> --}}
                    <canvas id="categoryChart"></canvas>
                    {{--
                </div> --}}
            </div>
        </div>

    </div>
@endsection

{{-- @section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
    const ctx = document.getElementById('loanChart').getContext('2d');
    const loanChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!
    },
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
                    },
            tooltip: {
                backgroundColor: '#f9fafb',
                    titleColor: '#1f2937',
                        bodyColor: '#1f2937',
                            borderColor: '#e5e7eb',
                                borderWidth: 1,
                    }
        },
        scales: {
            y: {
                beginAtZero: true,
                    ticks: {
                    stepSize: 1,
                        color: '#374151',
                            font: {
                        size: 12
                    }
                },
                grid: {
                    color: '#e5e7eb'
                }
            },
            x: {
                ticks: {
                    color: '#374151',
                        font: {
                        size: 12
                    }
                },
                grid: {
                    display: false
                }
            }
        }
    }
        });

    // const ctx2 = document.getElementById('categoryChart').getContext('2d');
    // const categoryChart = new Chart(ctx2, {
    //     type: 'pie',
    //     data: {
    //         labels: {!! json_encode($categoryLabels) !!},
    //         datasets: [{
    //             data: {!! json_encode($categoryData) !!},
    //             backgroundColor: [
    //                 'rgba(255, 99, 132, 0.6)',
    //                 'rgba(54, 162, 235, 0.6)',
    //                 'rgba(255, 206, 86, 0.6)',
    //                 'rgba(75, 192, 192, 0.6)',
    //                 'rgba(153, 102, 255, 0.6)'
    //             ],
    //             borderColor: [
    //                 'rgba(255, 99, 132, 1)',
    //                 'rgba(54, 162, 235, 1)',
    //                 'rgba(255, 206, 86, 1)',
    //                 'rgba(75, 192, 192, 1)',
    //                 'rgba(153, 102, 255, 1)'
    //             ],
    //             borderWidth: 1
    //         }]
    //     },
    //     options: {
    //         responsive: true,
    //         plugins: {
    //             legend: {
    //                 position: 'right',
    //                 labels: {
    //                     color: '#374151'
    //                 }
    //             },
    //             tooltip: {
    //                 callbacks: {
    //                     label: function (context) {
    //                         let label = context.label || '';
    //                         let value = context.parsed || 0;
    //                         return `${label}: ${value}x dipinjam`;
    //                     }
    //                 }
    //             }
    //         }
    //     }
    // });

    const ctx2 = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: {!! json_encode($categoryLabels) !!
    },
        datasets: [{
            data: {!! json_encode($categoryData) !!},
    backgroundColor: { !!json_encode($categoryBgColors)!! },
    borderColor: { !!json_encode($categoryBorderColors)!! },
    borderWidth: 1
                }]
            },
    options: {
        responsive: true,
            plugins: {
            legend: {
                position: 'right',
                    labels: {
                    color: '#374151'
                }
            },
            tooltip: {
                callbacks: {
                    label: function (context) {
                        const percentage = {!! json_encode($categoryPercentages)!!
                    } [context.dataIndex];
                    const value = context.parsed;
                    return `${context.label}: ${value}x (${percentage}%)`;
                }
            }
        },
        // 🟢 Tambahkan plugin datalabels untuk menampilkan persentase di atas slice
        datalabels: {
            color: '#fff',
                formatter: function (value, context) {
                    const percentage = {!! json_encode($categoryPercentages)!!
                } [context.dataIndex];
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

</script>
@endsection --}}

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <script>
        // Fungsi untuk dapatkan warna berdasarkan darkMode
        function getChartColors(darkMode) {
            return {
                text: darkMode ? '#E5E7EB' : '#374151',
                grid: darkMode ? '#4B5563' : '#E5E7EB',
                tooltipBg: darkMode ? '#1F2937' : '#F9FAFB',
                tooltipText: '#F3F4F6',
            };
        }

        const darkMode = window.darkMode ?? false;
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
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: colors.grid
                        }
                    },
                    x: {
                        ticks: {
                            color: colors.text,
                            font: {
                                size: 12
                            }
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
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: colors.text
                        }
                    },
                    tooltip: {
                        backgroundColor: colors.tooltipBg,
                        titleColor: colors.tooltipText,
                        bodyColor: colors.tooltipText,
                    },
                    datalabels: {
                        color: '#fff',
                        formatter: function (value, context) {
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
                const newDarkMode = Alpine.store('darkMode');
                const newColors = getChartColors(newDarkMode);

                // Update chart config warna
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