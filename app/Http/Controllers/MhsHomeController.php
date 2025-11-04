<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectNotification;
use Illuminate\Support\Str;

class MhsHomeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Target tetap: 8 proyek (8 semester)
        $TOTAL_TARGET = 8;

        // Jumlah proyek yang sudah diupload oleh mahasiswa ini
        $uploadedCount = $user->projects()->count();

        // 100% / 8 = 12.5% per proyek
        $progressPercent = min(100, round($uploadedCount * (100 / $TOTAL_TARGET), 1)); // 1 angka desimal

        $notifications = ProjectNotification::query()
        ->where('owner_user_id', $user->id)
        ->latest()
        ->limit(20)
        ->get()
        ->map(function ($n) {
            return (object)[
                'id'       => $n->id,
                'type'     => $n->type,
                'message'  => $n->payload['message'] ?? null,
                'created_at' => $n->created_at,
            ];
        });

        return view('mhs.homeMhs', compact(
            'TOTAL_TARGET',
            'uploadedCount',
            'progressPercent',
            'notifications'
        ));
    }
}
