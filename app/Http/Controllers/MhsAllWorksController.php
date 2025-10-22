<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class MhsAllWorksController extends Controller
{
    /**
     * Tampilkan SEMUA project mahasiswa (bukan hanya milik user).
     * Fitur: pagination + per_page (10/20/30), search & filter ringan.
     */
    public function index(Request $request)
    {
        // per_page dari dropdown "Show entries"
        $perPage = (int) $request->input('per_page', 10);
        if (!in_array($perPage, [10, 20, 30])) {
            $perPage = 10;
        }

        // optional: q (search), category, semester, sort
        $q        = trim((string) $request->input('q', ''));
        $category = trim((string) $request->input('category', ''));
        $semester = $request->filled('semester') ? (int) $request->input('semester') : null;
        $sort     = $request->input('sort', 'latest'); // latest | most_liked | most_viewed

        $query = Project::query()
            ->with(['user:id,name_asli,username,email']) // untuk tampilkan pemilik project
            ->select(['id','user_id','anonim_name','title','category','course','client','semester','display_photos','views','likes']);

        // Search ringan di beberapa kolom
        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('category', 'like', "%{$q}%")
                    ->orWhere('course', 'like', "%{$q}%")
                    ->orWhere('client', 'like', "%{$q}%");
            });
        }

        if ($category !== '') {
            $query->where('category', $category);
        }

        if (!is_null($semester)) {
            $query->where('semester', $semester);
        }

        // Urutan default: terbaru (tanpa timestamps kita pakai id desc)
        switch ($sort) {
            case 'most_liked':
                $query->orderByDesc('likes')->orderByDesc('id');
                break;
            case 'most_viewed':
                $query->orderByDesc('views')->orderByDesc('id');
                break;
            default:
                $query->orderByDesc('id');
        }

        $projects = $query->paginate($perPage)->appends($request->query());

        return view('mhs.allWorksMhs', [
            'projects' => $projects,
            'perPage'  => $perPage,
            'q'        => $q,
            'category' => $category,
            'semester' => $semester,
            'sort'     => $sort,
        ]);
    }
}
