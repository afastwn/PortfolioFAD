<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StudentProfilingController extends Controller
{
    /* =======================
     * LIST + SEARCH (tetap)
     * ======================= */
    public function index(Request $request)
    {
        $q        = trim((string) $request->get('q'));
        $pageSize = (int) ($request->integer('size') ?: 10);
        if (!in_array($pageSize, [10, 25, 50, 100])) $pageSize = 10;

        // hanya kaprodi yang boleh pakai filter cohort
        $applyCohort = auth()->check() && auth()->user()->role === 'kaprodi';
        $selectedCohort = $applyCohort ? trim((string) $request->get('cohort')) : '';

        $baseQuery = $this->makeBaseQuery($request, $applyCohort);

        $students = (clone $baseQuery)
            ->orderByRaw('COALESCE(nim, id)')
            ->paginate($pageSize)
            ->withQueryString();

        $students->getCollection()->transform(function ($user) {
            $categories = $user->projects->pluck('category')->filter()->unique()->values()->implode(', ');
            $user->categories_text = $categories ?: '-';
            return $user;
        });

        // daftar angkatan dari NIM (8 digit)
        $cohorts = \App\Models\User::where('role','mahasiswa')
            ->whereNotNull('nim')
            ->pluck('nim')
            ->map(fn($nim) => preg_match('/^\d{8}$/', $nim) ? (int)('20'.substr($nim,2,2)) : null)
            ->filter()->unique()->sort()->values();

        return view('dosen.studentProfiling', [
            'students'       => $students,
            'q'              => $q,
            'pageSize'       => $pageSize,
            'cohorts'        => $cohorts,
            'selectedCohort' => $selectedCohort,
        ]);
    }


    /* =======================
     * DETAIL (tetap)
     * ======================= */
    public function show(User $user)
    {
        abort_unless($user->role === 'mahasiswa', 404);

        $user->load([
            'profile:id,user_id,address,email_pribadi,phone,photo',
            'projects:id,user_id,title,course,semester,category,display_photos',
        ]);

        $categoriesText = $user->projects
            ->pluck('category')->filter()->unique()->values()->implode(', ');

        $avatarUrl = null;
        if ($user->profile && !empty($user->profile->photo)) {
            $avatarUrl = asset('uploads/profiles/' . $user->profile->photo);
        }

        return view('dosen.showProfile', [
            'user'           => $user,
            'profile'        => $user->profile,
            'projects'       => $user->projects,
            'categoriesText' => $categoriesText ?: '-',
            'avatarUrl'      => $avatarUrl,
        ]);
    }

    /* =======================
     * EXPORT (CSV / XLSX)
     * ======================= */
    public function export(Request $request)
    {
        $format = strtolower($request->input('format', 'csv'));
        $query  = $this->makeBaseQuery($request, true)->orderByRaw('COALESCE(nim, id)');

        return $format === 'xlsx'
            ? $this->exportXlsxTemplate($query)   // ✅ cukup 1 argumen
            : $this->exportCsv($query);
    }


    /* =======================
     * PRIVATE HELPERS
     * ======================= */

    /**
     * Satu sumber kebenaran untuk filter & relasi (dipakai index + export).
     */
    private function makeBaseQuery(Request $request, bool $applyCohort = false)
    {
        $q = trim((string) $request->get('q'));
        $cohort = $applyCohort ? trim((string) $request->get('cohort')) : '';

        return \App\Models\User::query()
            ->where('role', 'mahasiswa')
            ->select(['id','nim','name_asli','email'])
            ->with([
                'profile:id,user_id,address,email_pribadi,phone,photo',
                'projects:id,user_id,category',
                'school:id,user_id,school_origin,city,regency,province,level',
            ])
            ->withCount(['projects as projects_count'])
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name_asli','like',"%{$q}%")
                        ->orWhere('nim','like',"%{$q}%")
                        ->orWhere('email','like',"%{$q}%")
                        ->orWhereHas('projects', fn($qq)=>$qq->where('category','like',"%{$q}%"))
                        ->orWhereHas('profile', fn($qq)=>$qq->where('phone','like',"%{$q}%")->orWhere('address','like',"%{$q}%"))
                        ->orWhereHas('school', fn($qq)=>$qq->where('school_origin','like',"%{$q}%")->orWhere('city','like',"%{$q}%")->orWhere('regency','like',"%{$q}%")->orWhere('province','like',"%{$q}%"));
                });
            })
            ->when($applyCohort && $cohort !== '', function ($q2) use ($cohort) {
                $yy = substr($cohort, -2); // "2022" -> "22"
                $q2->whereRaw("nim REGEXP '^[0-9]{8}$'")
                ->whereRaw("SUBSTRING(nim, 3, 2) = ?", [$yy]);
            });
    }



    /**
     * Export ke CSV (tanpa styling).
     * Catatan: kita kirim BOM UTF-8 agar Excel Windows membaca karakter non-ASCII dengan benar.
     */
    // private function exportCsv($query)
    // {
    //     $filename = 'students_'.now()->format('Ymd_His').'.csv';

    //     return response()->streamDownload(function () use ($query) {
    //         // BOM UTF-8 untuk Excel
    //         echo "\xEF\xBB\xBF";

    //         $out = fopen('php://output', 'w');
    //         fputcsv($out, ['NO','NIM','NAMA','NO HP','EMAIL','ALAMAT','NAMA SEKOLAH','ASAL SEKOLAH','JUMLAH KARYA']);

    //         $no = 1;
    //         $query->chunk(1000, function ($rows) use (&$no, $out) {
    //             foreach ($rows as $u) {
    //                 $p = optional($u->profile);
    //                 $s = optional($u->school);
    //                 $asal = $s->regency ?: $s->city ?: '-';

    //                 fputcsv($out, [
    //                     $no++,
    //                     $u->nim ?? $u->id,
    //                     $u->name_asli ?? '-',
    //                     $p->phone ?? '-',
    //                     $u->email ?? '-',
    //                     $p->address ?? '-',
    //                     $s->school_origin ?? '-',
    //                     $asal,
    //                     (int)($u->projects_count ?? 0),
    //                 ]);
    //             }
    //         });

    //         fclose($out);
    //     }, $filename, [
    //         'Content-Type' => 'text/csv; charset=UTF-8',
    //     ]);
    // }

    /**
     * Export ke XLSX berdasar template.
     * Template: storage/app/templates/students_template.xlsx
     * Header di baris-1, data diisi mulai baris-2 (A..I).
     */
   /** Export ke XLSX dengan template (header di baris-1, data di baris-2) */
    /** Export ke XLSX dengan template (header baris-1, data mulai baris-2) */
    private function exportXlsxTemplate($query)
    {
        $template = storage_path('app/templates/students_template.xlsx');
        if (!file_exists($template)) {
            abort(500, 'Template Excel tidak ditemukan di storage/app/templates/students_template.xlsx');
        }

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);
        $sheet = $spreadsheet->getActiveSheet();

        $row = 2; $no = 1;
        $query->chunk(1000, function ($rows) use (&$row, &$no, $sheet) {
            foreach ($rows as $u) {
                $p = optional($u->profile);
                $s = optional($u->school);
                $asal = $s->regency ?: $s->city ?: '-';

                // kategori unik (gabung dengan koma)
                $kategoriText = $u->projects
                    ->pluck('category')
                    ->filter()
                    ->unique()
                    ->values()
                    ->implode(', ');

                // A..J sesuai template terbaru
                $sheet->setCellValue("A{$row}", $no);
                $sheet->setCellValue("B{$row}", $u->nim ?? $u->id);
                $sheet->setCellValue("C{$row}", $u->name_asli ?? '-');
                $sheet->setCellValue("D{$row}", $p->phone ?? '-');
                $sheet->setCellValue("E{$row}", $u->email ?? '-');
                $sheet->setCellValue("F{$row}", $p->address ?? '-');
                $sheet->setCellValue("G{$row}", $s->school_origin ?? '-');
                $sheet->setCellValue("H{$row}", $asal);
                $sheet->setCellValue("I{$row}", $kategoriText ?: '-');            // ⬅️ KATEGORI KARYA
                $sheet->setCellValue("J{$row}", (int)($u->projects_count ?? 0));   // ⬅️ JUMLAH KARYA

                $row++; $no++;
            }
        });

        $cohort    = request()->input('cohort');
        $timestamp = now()->tz('Asia/Jakarta')->format('Y-m-d_H-i');
        $filename  = 'productdesign_' . ($cohort ?: 'all') . '_students_' . $timestamp . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            if (ob_get_level()) { @ob_end_clean(); }
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }


}
