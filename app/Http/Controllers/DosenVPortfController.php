<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class DosenVPortfController extends Controller
{
    /**
     * Tampilkan semua project mahasiswa untuk dosen (mirip All Works),
     * dengan filter kategori dan kontrol show entries.
     */
    public function index(Request $request)
    {
        // Default 10, hanya izinkan 10/25/50/100
        $perPage = (int) $request->input('per_page', 10);
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        // Hanya filter category
        $category = trim((string) $request->input('category', ''));

        $query = Project::query()
            ->with([
                'user:id,name_asli,username,email',
                'currentViewerInteraction', // penting untuk warna ikon hati
            ])
            ->select([
                'id','user_id','anonim_name','title','category','course','client',
                'semester','display_photos','views','likes'
            ]);

        if ($category !== '') {
            $query->where('category', $category);
        }

        // Default: karya terbaru dulu
        $query->orderByDesc('id');

        $projects = $query
            ->paginate($perPage)
            ->appends($request->query());

        return view('dosen.vPortfolio', [
            'projects' => $projects,
            'perPage'  => $perPage,
            'category' => $category,
        ]);
    }
}
