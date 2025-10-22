<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectViewController extends Controller
{
    public function show(Project $project)
    {
        // eager minimal buat tampilan
        $project->load('user');

        // flag read-only agar Blade menonaktifkan form/aksi
        $readOnly = true;
        $isEdit   = true;  // biar section "Edit Project" tetap tampilkan data

        return view('dosen.project_readonly', compact('project','readOnly','isEdit'));
    }
}