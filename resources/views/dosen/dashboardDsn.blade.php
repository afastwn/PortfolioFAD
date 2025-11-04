{{-- resources/views/dashboardDsn.blade.php --}}
@extends('layouts.appDosen')

@section('title', 'Dashboard')

@section('content')
    {{-- Header --}}
    <header class="flex items-center justify-between border-b border-gray-200 pb-4">
        <h2 class="text-base sm:text-lg font-semibold tracking-wide">Dashboard</h2>
        <h1 class="text-2xl font-extrabold flex items-center gap-2">
            Hello, {{ explode(' ', Auth::user()->name_asli)[0] ?? 'User' }}! 👋
        </h1>
    </header>

    {{-- Row 1: Charts --}}
    <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
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
                <div id="activeLegend" class="mt-4 flex flex-wrap justify-center gap-3 text-center text-xs"></div>
            </div>
        </div>
    </div>

    {{-- Row 2: School Origin (dynamic map) --}}
    <div class="mt-10">
        <div class="bg-white rounded-2xl border border-gray-200 shadow p-4 sm:p-6">
            <h3 class="text-xs sm:text-sm font-extrabold tracking-wide mb-4">SCHOOL ORIGIN</h3>
            <div id="schoolsMap" class="w-full rounded-xl border border-gray-200" style="height: 520px;"></div>
            <p class="mt-3 text-xs text-gray-500">Zoom/drag to explore. Pin color shows category; size follows total.</p>
        </div>
    </div>

    {{-- Chart.js (CDN) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    {{-- Leaflet (CDN) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        .leaflet-div-icon {
            background: transparent;
            border: none;
        }
    </style>

    {{-- ===== MAP (Leaflet) ===== --}}
    <script>
        // Data markers dari controller: [{id,name,province,lat,lng,total}]
        const MAP_MARKERS = @json($mapMarkers ?? []);

        // Inisialisasi peta
        const map = L.map('schoolsMap', {
            minZoom: 4
        }).setView([-2.5, 117], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OSM contributors'
        }).addTo(map);

        // Skala & kategori warna
        const totals = MAP_MARKERS.map(m => Number(m.total) || 0);
        // Hitung nilai-nilai penting
        const filtered = totals.filter(v => v > 0).sort((a, b) => a - b);
        const minVal = filtered[0];
        const maxVal = filtered[filtered.length - 1];

        // Ambil nilai tengah (median unik)
        let midVal;
        if (filtered.length <= 2) {
            midVal = Math.floor((minVal + maxVal) / 2);
        } else {
            const midIndex = Math.floor(filtered.length / 2);
            midVal = filtered[midIndex];
        }


        // >>> pastikan input selalu Number
        const pinSize = vRaw => {
            const v = Number(vRaw) || 0;
            return 24 + (v / maxVal) * 18; // 24..42 px
        };

        const COLORS = {
            high: '#22c55e',
            mid: '#eab308',
            low: '#ef4444'
        };

        function colorFor(vRaw) {
            const v = Number(vRaw) || 0; // <<< cast
            if (v <= 1) return COLORS.low; // merah
            if (v === maxVal && maxVal > 1) return COLORS.high; // hijau
            return COLORS.mid; // kuning
        }

        // Ikon pin SVG (selalu pakai angka)
        function pinIcon(vRaw) {
            const v = Number(vRaw) || 0; // <<< cast
            const h = Math.round(pinSize(v));
            const w = Math.round(h * 0.67);
            const color = colorFor(v);
            const html = `
              <svg width="${w}" height="${h}" viewBox="0 0 24 36" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M12 36c0 0 9-12 9-19.5A9 9 0 1 0 3 16.5C3 24 12 36 12 36z"
                      fill="${color}" stroke="rgba(0,0,0,0.25)" stroke-width="1"/>
                <circle cx="12" cy="12" r="4.5" fill="white" fill-opacity="0.95"/>
              </svg>`;
            return L.divIcon({
                html,
                className: 'pin-icon',
                iconSize: [w, h],
                iconAnchor: [w / 2, h],
                popupAnchor: [0, -h]
            });
        }

        // Tambahkan markers
        const layers = [];
        MAP_MARKERS.forEach(m => {
            if (m.lat == null || m.lng == null) return;
            const marker = L.marker([m.lat, m.lng], {
                icon: pinIcon(m.total)
            }).addTo(map);
            marker.bindTooltip(
                `<div class="text-xs">
                    <div class="font-semibold">${m.name}${m.province ? ' – ' + m.province : ''}</div>
                    <div>${Number(m.total) || 0} student${Number(m.total) === 1 ? '' : 's'}</div>
                </div>`, {
                    sticky: true,
                    direction: 'top',
                    offset: [0, -8]
                }
            );
            layers.push(marker);
        });

        // Fit bounds
        if (layers.length) {
            const group = L.featureGroup(layers);
            map.fitBounds(group.getBounds().pad(0.2));
        }

        // Legend 3 warna
        const Legend = L.Control.extend({
            options: {
                position: 'bottomright'
            },
            onAdd: function() {
                const div = L.DomUtil.create('div', 'legend bg-white/90 rounded-lg shadow p-3 text-xs');
                div.innerHTML = `
            <div class="font-semibold mb-1">Category</div>
            <div class="flex items-center gap-2 mb-1">
              <span style="display:inline-block;width:12px;height:12px;border-radius:9999px;background:${COLORS.high};border:1px solid rgba(0,0,0,0.2)"></span>
              <span>Highest number of schools</span>
            </div>
            <div class="flex items-center gap-2 mb-1">
              <span style="display:inline-block;width:12px;height:12px;border-radius:9999px;background:${COLORS.mid};border:1px solid rgba(0,0,0,0.2)"></span>
              <span>Moderate number of schools</span>
            </div>
            <div class="flex items-center gap-2">
              <span style="display:inline-block;width:12px;height:12px;border-radius:9999px;background:${COLORS.low};border:1px solid rgba(0,0,0,0.2)"></span>
              <span>Lowest number of schools</span>
            </div>
        `;
                return div;
            }
        });
        map.addControl(new Legend());
        // Legend 3 warna (English version)
        //     const Legend = L.Control.extend({
        //         options: {
        //             position: 'bottomright'
        //         },
        //         onAdd: function() {
        //             const div = L.DomUtil.create('div', 'legend bg-white/90 rounded-lg shadow p-3 text-xs');
        //             div.innerHTML = `
    //   <div class="font-semibold mb-1">Category</div>
    //   <div class="flex items-center gap-2 mb-1">
    //     <span style="display:inline-block;width:12px;height:12px;border-radius:9999px;background:${COLORS.high};border:1px solid rgba(0,0,0,0.2)"></span>
    //     <span>Highest number of schools <span class="text-gray-500">(${maxVal})</span></span>
    //   </div>
    //   <div class="flex items-center gap-2 mb-1">
    //     <span style="display:inline-block;width:12px;height:12px;border-radius:9999px;background:${COLORS.mid};border:1px solid rgba(0,0,0,0.2)"></span>
    //     <span>Moderate number of schools <span class="text-gray-500">(${midVal})</span></span>
    //   </div>
    //   <div class="flex items-center gap-2">
    //     <span style="display:inline-block;width:12px;height:12px;border-radius:9999px;background:${COLORS.low};border:1px solid rgba(0,0,0,0.2)"></span>
    //     <span>Lowest number of schools <span class="text-gray-500">(${minVal})</span></span>
    //   </div>
    // `;
        //             return div;
        //         }
        //     });
        //     map.addControl(new Legend());
    </script>

    {{-- ===== CHARTS (Chart.js) ===== --}}
    <script>
        const basePalette = [
            '#3b82f6', '#ef4444', '#10b981', '#f59e0b',
            '#8b5cf6', '#14b8a6', '#eab308', '#22c55e',
            '#06b6d4', '#a855f7'
        ];

        // Student Interests (Horizontal Bar)
        (function() {
            const ctx = document.getElementById('interestsChart').getContext('2d');
            const labels = @json($interestLabels ?? []);
            const data = @json($interestCounts ?? []);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels.length ? labels : ['No Data'],
                    datasets: [{
                        label: 'Number of Projects',
                        data: data.length ? data : [1],
                        backgroundColor: '#22c55e',
                        borderRadius: 6,
                        borderSkipped: false
                    }]
                },
                options: {
                    indexAxis: 'y',
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    size: 12
                                },
                                stepSize: 1,
                                callback: v => v
                            }
                        },
                        y: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#4b5563',
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(31,41,55,0.9)',
                            titleFont: {
                                weight: 'bold',
                                size: 13
                            },
                            callbacks: {
                                label: ctx => {
                                    const val = ctx.raw ?? 0;
                                    return `${val} ${val === 1 ? 'project' : 'projects'}`;
                                }
                            }
                        }
                    }
                }
            });
        })();

        // Active Students (Doughnut)
        (function() {
            const activeCtx = document.getElementById('activeChart').getContext('2d');
            const activeLabels = @json($activeCohortLabels ?? []);
            const activeCounts = @json($activeCohortCounts ?? []);
            const activeColors = activeLabels.map((_, i) => basePalette[i % basePalette.length]);

            new Chart(activeCtx, {
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
                                    return `${ctx.label}: ${val} ${val === 1 ? 'student' : 'students'}`;
                                }
                            }
                        }
                    }
                }
            });

            // Legend dinamis
            const legendEl = document.getElementById('activeLegend');
            legendEl.innerHTML = activeLabels.map((label, i) => `
                <div class="flex flex-col items-center w-12">
                    <div class="w-2 h-2 rounded-full" style="background:${activeColors[i]}"></div>
                    <div class="mt-1 text-gray-600">${label}</div>
                </div>
            `).join('');
        })();
    </script>
@endsection
