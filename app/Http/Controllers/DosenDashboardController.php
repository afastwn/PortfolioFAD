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
            ->select('category', DB::raw('COUNT(*) AS total'))
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->get();

        $interestLabels = $rowsInterest->pluck('category');
        $interestCounts = $rowsInterest->pluck('total');

        // kirim semua ke view
        return view('dosen.dashboardDsn', [
            // Active students
            'activeCohortLabels' => $activeLabels,
            'activeCohortCounts' => $activeCounts,
            // Student interests
            'interestLabels' => $interestLabels,
            'interestCounts' => $interestCounts,
        ]);
    }
}
