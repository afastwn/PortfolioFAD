<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class DosenVPortfController extends Controller
{
    /**
     * Tampilkan semua project mahasiswa untuk dosen (mirip All Works).
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 10);
        if (!in_array($perPage, [10, 20, 30])) $perPage = 10;

        $q        = trim((string) $request->input('q', ''));
        $category = trim((string) $request->input('category', ''));
        $semester = $request->filled('semester') ? (int) $request->input('semester') : null;
        $sort     = $request->input('sort', 'latest'); // latest | most_liked | most_viewed

        $query = Project::query()
            ->with(['user:id,name_asli,username,email'])
            ->select([
                'id','user_id','anonim_name','title','category','course','client','semester',
                'display_photos','views','likes'
            ]);

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('category', 'like', "%{$q}%")
                    ->orWhere('course', 'like', "%{$q}%")
                    ->orWhere('client', 'like', "%{$q}%");
            });
        }
        if ($category !== '')   $query->where('category', $category);
        if (!is_null($semester)) $query->where('semester', $semester);

        switch ($sort) {
            case 'most_liked':  $query->orderByDesc('likes')->orderByDesc('id');  break;
            case 'most_viewed': $query->orderByDesc('views')->orderByDesc('id');  break;
            default:            $query->orderByDesc('id');                        break;
        }

        $projects = $query->paginate($perPage)->appends($request->query());

        return view('dosen.vPortfolio', [
            'projects' => $projects,
            'perPage'  => $perPage,
            'q'        => $q,
            'category' => $category,
            'semester' => $semester,
            'sort'     => $sort,
        ]);
    }
}
