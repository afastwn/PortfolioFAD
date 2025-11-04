<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        // Dropdown Show entries di halaman galeri publik juga bisa dipakai
        $perPage = (int) $request->input('per_page', 10);
        if (!in_array($perPage, [10, 20, 30])) $perPage = 10;

        $projects = Project::query()
            ->with([
                'user:id,name_asli',
                'currentViewerInteraction', // cek like via cookie anon untuk publik
            ])
            ->select([
                'id','user_id','anonim_name','title','category','course','client',
                'semester','display_photos','views','likes'
            ])
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        return view('showGalery', [
            'projects' => $projects,
            'perPage'  => $perPage,
        ]);
    }
}
