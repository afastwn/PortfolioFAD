@extends('layouts.appDosen')

@section('title', 'Dashboard')

@section('content')
    {{-- Header --}}
    <header class="flex items-center justify-between border-b border-gray-200 pb-4">
        <h2 class="text-base sm:text-lg font-semibold tracking-wide">Dashboard</h2>
        <h1 class="text-5xl font-extrabold flex items-center gap-2">
            HELLO! <span class="text-6xl">👋</span>
        </h1>
    </header>

    {{-- Row 1: Charts --}}
    <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-0">
        {{-- Student Interests (Bar) --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow p-4 sm:p-6">
            <h3 class="text-xs sm:text-sm font-extrabold tracking-wide mb-4">STUDENT INTERESTS</h3>
            <div class="relative">
                <canvas id="interestsChart" height="360"></canvas>
            </div>
        </div>

        {{-- Active Students (Doughnut) --}}
        <div class="bg-white rounded-3xl border border-gray-200 shadow p-4 sm:p-6 w-full max-w-xs mx-auto">
            <h3 class="text-xs sm:text-sm font-extrabold tracking-wide mb-4">ACTIVE STUDENTS</h3>
            <div class="flex flex-col items-center">
                <canvas id="activeChart" width="180" height="180"></canvas>

                {{-- Legend dinamis --}}
                <div id="activeLegend" class="mt-4 flex flex-wrap justify-center gap-3 text-center text-xs"></div>
            </div>
        </div>

    </div>

    {{-- Row 2: Map --}}
    {{-- Row 2: Map (Static 2D) --}}
    <div class="mt-10">
        <div class="bg-white rounded-2xl border border-gray-200 shadow p-4 sm:p-6">
            <h3 class="text-xs sm:text-sm font-extrabold tracking-wide mb-4">SCHOOL ORIGIN</h3>

            {{-- Container peta statis --}}
            <div class="relative w-full overflow-hidden rounded-xl border border-gray-200">
                {{-- 1) Simpan gambar peta 2D-mu sebagai /img/indo-2d.png --}}
                <img src="/INDONESIA.png" alt="Indonesia 2D Map" class="w-full h-auto block select-none">


            </div>

            <p class="mt-3 text-xs text-gray-500">
                *Peta statis Indonesia
            </p>
        </div>
    </div>


    {{-- Leaflet JS & CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Init map, fokus ke Indonesia
            const map = L.map('indoMap').setView([-2.5, 118], 5);

            // Gunakan tile gratis
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            // Dummy data sekolah (id, nama, lat, lon)
            const schools = [{
                    name: "Jakarta School",
                    coords: [-6.2, 106.8]
                },
                {
                    name: "Yogyakarta School",
                    coords: [-7.8, 110.4]
                },
                {
                    name: "Bandung School",
                    coords: [-6.9, 107.6]
                },
                {
                    name: "Surabaya School",
                    coords: [-7.2, 112.7]
                },
                {
                    name: "Medan School",
                    coords: [3.6, 98.7]
                },
                {
                    name: "Makassar School",
                    coords: [-5.1, 119.4]
                },
            ];

            // Tampilkan marker
            schools.forEach(s => {
                L.marker(s.coords).addTo(map).bindPopup(`<b>${s.name}</b>`);
            });
        });
    </script>

    {{-- Chart.js (CDN) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        // ---------- Student Interests (Horizontal Bar) ----------
        const interestsCtx = document.getElementById('interestsChart').getContext('2d');
        const interestsChart = new Chart(interestsCtx, {
            type: 'bar',
            data: {
                labels: ['Tools', 'Urban Design', 'Jewellery', 'Watches', 'Eyewear', 'Tableware'],
                datasets: [{
                    label: 'Students',
                    data: [74779, 56635, 43887, 19027, 8142, 4918],
                    borderWidth: 1,
                    backgroundColor: '#22c55e', // green-500
                    borderRadius: 6,
                    barThickness: 14,
                }]
            },
            options: {
                indexAxis: 'y',
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        },
                        ticks: {
                            callback: (value) => Intl.NumberFormat('en-US', {
                                notation: 'compact',
                                maximumFractionDigits: 1
                            }).format(value)
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#4b5563'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => `${ctx.raw.toLocaleString()}`
                        }
                    }
                }
            }
        });

        // ---------- Active Students (Doughnut) ----------
        const activeCtx = document.getElementById('activeChart').getContext('2d');
        const activeLabels = @json($activeCohortLabels ?? []);
        const activeCounts = @json($activeCohortCounts ?? []);
        const basePalette = ['#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#8b5cf6', '#14b8a6', '#eab308', '#22c55e',
            '#06b6d4', '#a855f7'
        ];
        const activeColors = activeLabels.map((_, i) => basePalette[i % basePalette.length]);

        const activeChart = new Chart(activeCtx, {
            type: 'doughnut',
            data: {
                labels: activeLabels.length ? activeLabels : ['No Data'],
                datasets: [{
                    data: activeCounts.length ? activeCounts : [1],
                    backgroundColor: activeColors,
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '75%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => {
                                const val = ctx.raw ?? 0;
                                const suffix = val === 1 ? 'student' : 'students';
                                return `${ctx.label}: ${val} ${suffix}`;
                            }
                        }
                    }
                }
            }
        });

        // Legend dinamis & center otomatis
        const legendEl = document.getElementById('activeLegend');
        legendEl.innerHTML = activeLabels.map((label, i) => `
        <div class="flex flex-col items-center w-12">
            <div class="w-2 h-2 rounded-full" style="background:${activeColors[i]}"></div>
            <div class="mt-1 text-gray-600">${label}</div>
        </div>
    `).join('');
    </script>
@endsection
