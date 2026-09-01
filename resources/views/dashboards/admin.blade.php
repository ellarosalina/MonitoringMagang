<x-layouts.admin title="Dashboard Admin" subtitle="Control panel">

    {{-- Ringkasan Statistik Kartu Utama --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase">Mahasiswa</span>
                <span class="p-1.5 bg-blue-50 text-blue-600 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path></svg>
                </span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $totalMahasiswa }}</h3>
            <p class="text-xs text-gray-400 mt-1">Mahasiswa Magang</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase">Sekolah Mitra</span>
                <span class="p-1.5 bg-emerald-50 text-emerald-600 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V5m0 16V5m0 0h4"></path></svg>
                </span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $totalSekolah }}</h3>
            <p class="text-xs text-gray-400 mt-1">Instansi Penempatan</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase">Guru Pamong</span>
                <span class="p-1.5 bg-purple-50 text-purple-600 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $totalGuruPamong }}</h3>
            <p class="text-xs text-gray-400 mt-1">Pembimbing Lapangan</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 uppercase">Total Penempatan</span>
                <span class="p-1.5 bg-amber-50 text-amber-600 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $totalPenempatan }}</h3>
            <p class="text-xs text-gray-400 mt-1">Plotting Berjalan</p>
        </div>
    </div>

    {{-- Grid Grafik Utama + Tabel Ringkas --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Grafik 1: Bar Chart (Status Penempatan) --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4 border-b pb-2">
                <div>
                    <h3 class="font-bold text-gray-800 text-sm">Status Penempatan</h3>
                    <p class="text-xs text-gray-400">Progres alokasi magang</p>
                </div>
            </div>
            <div class="relative h-52">
                <canvas id="chartPenempatan"></canvas>
            </div>
        </div>

        {{-- Grafik 2: Donut Chart (Verifikasi Logbook) --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4 border-b pb-2">
                <div>
                    <h3 class="font-bold text-gray-800 text-sm">Status Logbook</h3>
                    <p class="text-xs text-gray-400">Verifikasi laporan harian</p>
                </div>
            </div>
            <div class="relative h-52 flex items-center justify-center">
                <canvas id="chartLogbook"></canvas>
            </div>
        </div>

        {{-- Ringkasan Status Cepat (Gantikan Grafik Rumit) --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3 border-b pb-2">
                <h3 class="font-bold text-gray-800 text-sm">Ringkasan Sistem</h3>
                <span class="text-xs text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded font-medium">Real-time</span>
            </div>

            <div class="space-y-3">
                <div class="flex items-center justify-between p-2.5 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <span class="w-2.5 h-2.5 bg-amber-500 rounded-full"></span>
                        <span class="text-xs font-medium text-gray-700">Penempatan Menunggu</span>
                    </div>
                    <span class="text-xs font-bold text-gray-800">{{ $penempatanPerStatus['menunggu'] ?? 0 }}</span>
                </div>

                <div class="flex items-center justify-between p-2.5 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <span class="w-2.5 h-2.5 bg-blue-500 rounded-full"></span>
                        <span class="text-xs font-medium text-gray-700">Magang Berjalan</span>
                    </div>
                    <span class="text-xs font-bold text-gray-800">{{ $penempatanPerStatus['berjalan'] ?? 0 }}</span>
                </div>

                <div class="flex items-center justify-between p-2.5 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full"></span>
                        <span class="text-xs font-medium text-gray-700">Logbook Disetujui</span>
                    </div>
                    <span class="text-xs font-bold text-gray-800">{{ $logbookDisetujui ?? 0 }}</span>
                </div>

                <div class="flex items-center justify-between p-2.5 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <span class="w-2.5 h-2.5 bg-red-500 rounded-full"></span>
                        <span class="text-xs font-medium text-gray-700">Perlu Revisi Logbook</span>
                    </div>
                    <span class="text-xs font-bold text-gray-800">{{ $logbookRevisi ?? 0 }}</span>
                </div>
            </div>

            <div class="mt-3 pt-2 border-t text-center">
                <p class="text-xs text-gray-400">Data diperbarui secara otomatis dari database</p>
            </div>
        </div>

    </div>

    {{-- Script Chart.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script>
        // 1. Chart Bar Status Penempatan (Sederhana & Jelas)
        new Chart(document.getElementById('chartPenempatan'), {
            type: 'bar',
            data: {
                labels: ['Menunggu', 'Berjalan', 'Selesai', 'Dibatalkan'],
                datasets: [{
                    label: 'Jumlah',
                    data: [
                        {{ $penempatanPerStatus['menunggu'] ?? 0 }},
                        {{ $penempatanPerStatus['berjalan'] ?? 0 }},
                        {{ $penempatanPerStatus['selesai'] ?? 0 }},
                        {{ $penempatanPerStatus['dibatalkan'] ?? 0 }}
                    ],
                    backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#ef4444'],
                    borderRadius: 6,
                    barThickness: 28
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 11 } } },
                    y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } } }
                }
            }
        });

        // 2. Chart Doughnut Logbook (Persentase Verifikasi)
        new Chart(document.getElementById('chartLogbook'), {
            type: 'doughnut',
            data: {
                labels: ['Menunggu', 'Disetujui', 'Revisi'],
                datasets: [{
                    data: [
                        {{ $logbookMenunggu ?? 0 }},
                        {{ $logbookDisetujui ?? 0 }},
                        {{ $logbookRevisi ?? 0 }}
                    ],
                    backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, padding: 15, font: { size: 11 } }
                    }
                }
            }
        });
    </script>

</x-layouts.admin>