<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        // Default 10 karya terbaru saat halaman pertama dibuka
        $perPage = (int) $request->input('per_page', 10);
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        // Base query
        $query = Project::query()
            ->with([
                'user:id,name_asli',
                'currentViewerInteraction', // like/comment via cookie
            ])
            ->select([
                'id','user_id','anonim_name','title','category','course','client',
                'semester','display_photos','views','likes'
            ]);

        // ========== FILTER CATEGORY ==========
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Urutkan karya terbaru
        $query->orderByDesc('id');

        // Pagination
        $projects = $query
            ->paginate($perPage)
            ->withQueryString();

        return view('showGalery', [
            'projects' => $projects,
            'perPage'  => $perPage,
        ]);
    }
}
