<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Profile, CampusAct, Skills, School};

class MhsProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return view('mhs.profileMhs', [
            'user'       => $user,
            'profile'    => $user->profile ?? new Profile(),
            'activities' => $user->campusActs ?? collect(),      // collection
            'skills'     => $user->skillsMhs ?? collect(),       // collection
            'school'     => $user->school ?? new School(),
        ]);
    }

    public function saveProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'phone'         => 'nullable|string|max:50',
            'address'       => 'nullable|string|max:255',
            'email_pribadi' => 'nullable|email|max:255',
            'motivation'    => 'nullable|string',
            'tags'          => 'nullable|array|max:3',   // ← maksimal 3 item
            'tags.*'        => 'string|max:20',          // ← tiap item max 20 char
        ]);

        // Normalisasi whitespace + buang kosong
        $tags = collect($data['tags'] ?? [])
                ->map(fn($t) => trim(preg_replace('/\s+/', ' ', $t)))
                ->filter()
                ->values()
                ->all();

        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone'         => $data['phone'] ?? null,
                'address'       => $data['address'] ?? null,
                'email_pribadi' => $data['email_pribadi'] ?? null,
                'motivation'    => $data['motivation'] ?? null,
                'tags'          => $tags,
            ]
        );

        return back()->with('success', 'Profile saved.');
    }


    public function saveActivities(Request $request)
    {
        $user = Auth::user();
        $acts = array_filter($request->input('activities', []));

        // reset & simpan ulang sederhana
        $user->campusActs()->delete();
        foreach ($acts as $a) {
            CampusAct::create([
                'user_id' => $user->id,
                'activity' => trim($a),
            ]);
        }
        return back()->with('success', 'Activities saved.');
    }

    public function saveSkills(Request $request)
    {
        $user = Auth::user();
        $skills = array_filter($request->input('skills', []));

        $user->skillsMhs()->delete();
        foreach ($skills as $s) {
            Skills::create([
                'user_id' => $user->id,
                'skill'   => trim($s),
            ]);
        }
        return back()->with('success', 'Skills saved.');
    }

    public function saveSchool(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'school_origin' => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:100',
            'regency'       => 'nullable|string|max:100',
            'province'      => 'nullable|string|max:100',
            'level'         => 'nullable|in:SMA,SMK',
        ]);

        School::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return back()->with('success', 'School saved.');
    }
}
