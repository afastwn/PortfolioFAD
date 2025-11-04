<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Project;

class DosenDashboardController extends Controller
{
    public function index()
    {
        // ========== ACTIVE STUDENTS ==========
        $rowsActive = DB::table('users')
            ->where('role', 'mahasiswa')
            ->whereNotNull('nim')
            ->selectRaw("
                CASE
                    WHEN LENGTH(CAST(nim AS CHAR)) >= 4
                        THEN CONCAT('20', SUBSTRING(LPAD(CAST(nim AS CHAR), 8, '0'), 3, 2))
                    ELSE 'Unknown'
                END AS cohort
            ")
            ->selectRaw("COUNT(*) AS total")
            ->groupBy('cohort')
            ->orderBy('cohort')
            ->get();

        $activeLabels = $rowsActive->pluck('cohort');
        $activeCounts = $rowsActive->pluck('total');

        // ========== STUDENT INTERESTS ==========
        $rowsInterest = Project::query()
            ->whereNotNull('category')
            ->select('category', DB::raw('COUNT(*) AS total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->limit(10)               // << hanya 10 terbanyak
            ->get();

        $interestLabels = $rowsInterest->pluck('category');
        $interestCounts = $rowsInterest->pluck('total');

        // ===== SCHOOL ORIGIN MAP: baca dari city_id, city, atau regency =====

        // 1) baris yang sudah punya FK
        $byId = DB::table('schools as s')
            ->join('cities as c', 's.city_id', '=', 'c.id')
            ->select('c.id','c.name','c.province','c.lat','c.lng', DB::raw('COUNT(*) as total'))
            ->whereNotNull('s.city_id')
            ->groupBy('c.id','c.name','c.province','c.lat','c.lng');

        // 2) baris lama yang masih teks "city"
        $byCityName = DB::table('schools as s')
            ->join('cities as c', 'c.name', '=', 's.city')
            ->select('c.id','c.name','c.province','c.lat','c.lng', DB::raw('COUNT(*) as total'))
            ->whereNull('s.city_id')
            ->whereNotNull('s.city')
            ->where('s.city', '!=', '')
            ->groupBy('c.id','c.name','c.province','c.lat','c.lng');

        // 3) baris lama yang hanya isi "regency"
        $byRegencyName = DB::table('schools as s')
            ->join('cities as c', 'c.name', '=', 's.regency')
            ->select('c.id','c.name','c.province','c.lat','c.lng', DB::raw('COUNT(*) as total'))
            ->whereNull('s.city_id')
            ->where(function ($q) {
                $q->whereNull('s.city')->orWhere('s.city', '=', '');
            })
            ->whereNotNull('s.regency')
            ->where('s.regency', '!=', '')
            ->groupBy('c.id','c.name','c.province','c.lat','c.lng');

        // gabungkan semuanya lalu jumlahkan
        $union = $byId->unionAll($byCityName)->unionAll($byRegencyName);

        $mapMarkers = DB::query()
            ->fromSub($union, 't')
            ->select('id','name','province','lat','lng', DB::raw('SUM(total) as total'))
            ->groupBy('id','name','province','lat','lng')
            ->orderByDesc('total')
            ->get();

        return view('dosen.dashboardDsn', [
            'activeCohortLabels' => $activeLabels,
            'activeCohortCounts' => $activeCounts,
            'interestLabels'     => $interestLabels,
            'interestCounts'     => $interestCounts,
            'mapMarkers'         => $mapMarkers, // << kirim ke Blade
        ]);
    }
}
