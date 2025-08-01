@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Selamat Datang, {{ $userName }} 👋</h1>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        {{-- Total Buku --}}
        <div class="bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl shadow-md p-6 flex items-center">
            <div class="p-3 bg-blue-500 text-white rounded-full mr-4">
                <!-- Book Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20H5a2 2 0 01-2-2V6a2 2 0 012-2h7m7 0a2 2 0 012 2v12a2 2 0 01-2 2h-7m7 0V4m0 0H12" />
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-700">Total Buku</h2>
                <p class="text-2xl font-bold text-blue-800">{{ $totalBooks }}</p>
            </div>
        </div>

        {{-- Total Denda --}}
        <div class="bg-gradient-to-br from-red-100 to-red-200 rounded-xl shadow-md p-6 flex items-center">
            <div class="p-3 bg-red-500 text-white rounded-full mr-4">
                <!-- Money Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3 0 1.306.835 2.418 2 2.83V16h2v-2.17c1.165-.412 2-1.524 2-2.83 0-1.657-1.343-3-3-3z" />
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-700">Total Denda</h2>
                <p class="text-2xl font-bold text-red-700">Rp {{ number_format($totalFine, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Total Pengguna --}}
        <div class="bg-gradient-to-br from-green-100 to-green-200 rounded-xl shadow-md p-6 flex items-center">
            <div class="p-3 bg-green-500 text-white rounded-full mr-4">
                <!-- Users Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m4-2a4 4 0 100-8 4 4 0 000 8z" />
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-700">Total Pengguna</h2>
                <p class="text-2xl font-bold text-green-700">{{ $totalUsers }}</p>
            </div>
        </div>
    </div>

    {{-- Line Chart --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">📈 Grafik Peminjaman per Bulan</h2>
        <canvas id="loanChart" height="100"></canvas>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
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
</script>
@endsection