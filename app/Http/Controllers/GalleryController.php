<?php

namespace App\Http\Controllers;

use App\Models\Project;

class GalleryController extends Controller
{
    public function index()
    {
        // ambil semua project mahasiswa (tanpa login)
        $projects = Project::with('user:id,name_asli')
            ->orderByDesc('id')
            ->limit(15)
            ->get();

        return view('showGalery', compact('projects'));
    }
}
