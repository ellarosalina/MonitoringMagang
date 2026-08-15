<x-layouts.admin title="Dashboard Admin GTK" subtitle="Control panel">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <div class="bg-white rounded-lg shadow-sm p-5">
            <p class="text-sm text-gray-500">Total Mahasiswa</p>
            <p class="text-3xl font-bold text-blue-600 mt-1">{{ $totalMahasiswa }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-5">
            <p class="text-sm text-gray-500">Sekolah Mitra</p>
            <p class="text-3xl font-bold text-green-600 mt-1">{{ $totalSekolah }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-5">
            <p class="text-sm text-gray-500">Guru Pamong</p>
            <p class="text-3xl font-bold text-purple-600 mt-1">{{ $totalGuruPamong }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-5">
            <p class="text-sm text-gray-500">Total Penempatan</p>
            <p class="text-3xl font-bold text-orange-600 mt-1">{{ $totalPenempatan }}</p>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        <div class="bg-white rounded-lg shadow-sm p-5">
            <h3 class="font-semibold text-gray-700 mb-4">Status Penempatan</h3>
            <canvas id="chartPenempatan" height="200"></canvas>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-5">
            <h3 class="font-semibold text-gray-700 mb-4">Status Verifikasi Logbook</h3>
            <canvas id="chartLogbook" height="200"></canvas>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById('chartPenempatan'), {
            type: 'bar',
            data: {
                labels: ['Menunggu', 'Berjalan', 'Selesai', 'Dibatalkan'],
                datasets: [{
                    label: 'Jumlah Penempatan',
                    data: [
                        {{ $penempatanPerStatus['menunggu'] }},
                        {{ $penempatanPerStatus['berjalan'] }},
                        {{ $penempatanPerStatus['selesai'] }},
                        {{ $penempatanPerStatus['dibatalkan'] }}
                    ],
                    backgroundColor: ['#fbbf24', '#3b82f6', '#22c55e', '#ef4444']
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

        new Chart(document.getElementById('chartLogbook'), {
            type: 'doughnut',
            data: {
                labels: ['Menunggu', 'Disetujui', 'Revisi'],
                datasets: [{
                    data: [
                        {{ $logbookMenunggu }},
                        {{ $logbookDisetujui }},
                        {{ $logbookRevisi }}
                    ],
                    backgroundColor: ['#fbbf24', '#22c55e', '#ef4444']
                }]
            },
            options: {
                plugins: { legend: { position: 'bottom' } }
            }
        });
    </script>

</x-layouts.admin>