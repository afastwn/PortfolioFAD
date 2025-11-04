<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectInteraction;
use App\Models\ProjectNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectInteractionController extends Controller
{
    /**
     * Toggle Like
     */
    public function toggleLike(Project $project, Request $request)
    {
        $userId = Auth::id();
        $anonId = $request->cookie('anon_id');

        if (!$userId && !$anonId) {
            $anonId = (string) Str::uuid();
            Cookie::queue(cookie('anon_id', $anonId, 60 * 24 * 365));
        }

        return DB::transaction(function () use ($project, $userId, $anonId) {
            $interaction = ProjectInteraction::where('project_id', $project->id)
                ->when($userId, fn($q) => $q->where('user_id', $userId))
                ->when(!$userId, fn($q) => $q->where('anon_key', $anonId))
                ->first();

            $liked = false;

            if ($interaction) {
                // toggle
                $liked = !$interaction->liked;
                $interaction->liked = $liked;
                $interaction->save();

                // jika unlike & tidak ada komentar → hapus row
                $hasComments = is_array($interaction->comments) && count($interaction->comments) > 0;
                if (!$liked && !$hasComments) {
                    $interaction->delete();
                    $interaction = null;
                }

                // ✅ notifikasi like on (record lama → like true)
                if ($liked === true) {
                    $this->notifyProjectOwner($project, $userId, $userId ? null : $anonId, 'like');
                }
            } else {
                // buat baru liked = true
                ProjectInteraction::create([
                    'project_id' => $project->id,
                    'user_id'    => $userId,
                    'anon_key'   => $userId ? null : $anonId,
                    'liked'      => true,
                    'comments'   => null,
                ]);
                $liked = true;

                // ✅ notifikasi like on (record baru)
                $this->notifyProjectOwner($project, $userId, $userId ? null : $anonId, 'like');
            }

            // sync counter likes
            $likesCount = ProjectInteraction::where('project_id', $project->id)
                ->where('liked', true)->count();
            $project->update(['likes' => $likesCount]);

            return response()->json([
                'liked'        => $liked,
                'likes_count'  => $likesCount,
            ]);
        });
    }

    /**
     * Simpan komentar preset (checkbox)
     */
    public function storeComments(Project $project, Request $request)
    {
        $data = $request->validate([
            'comments'   => 'array',            // boleh kosong → artinya hapus komentar
            'comments.*' => 'string|max:255',
        ]);
        // normalisasi komentar: trim, buang kosong, unique, reindex
        $selected = array_values(array_unique(array_filter(array_map(
            fn($s) => trim((string)$s),
            $data['comments'] ?? []
        ), fn($s) => $s !== '')));

        $userId = Auth::id();
        $anonId = $request->cookie('anon_id');

        if (!$userId && !$anonId) {
            $anonId = (string) Str::uuid();
            Cookie::queue(cookie('anon_id', $anonId, 60 * 24 * 365));
        }

        return DB::transaction(function () use ($project, $userId, $anonId, $selected) {
            $interaction = ProjectInteraction::where('project_id', $project->id)
                ->when($userId, fn($q) => $q->where('user_id', $userId))
                ->when(!$userId, fn($q) => $q->where('anon_key', $anonId))
                ->first();

            if (!$interaction) {
                // tidak ada row sebelumnya
                if (count($selected) === 0) {
                    return response()->json(['ok' => true, 'has_comments' => false]); // nothing to do
                }
                $interaction = ProjectInteraction::create([
                    'project_id' => $project->id,
                    'user_id'    => $userId,
                    'anon_key'   => $userId ? null : $anonId,
                    'liked'      => false,
                    'comments'   => $selected,
                ]);

                // ✅ notifikasi comment (baru)
                $this->notifyProjectOwner($project, $userId, $userId ? null : $anonId, 'comment', ['comments' => $selected]);

                return response()->json(['ok' => true, 'has_comments' => true, 'comments' => $selected]);
            }

            // sudah ada row
            if (count($selected) === 0) {
                // kosongkan komentar
                $interaction->comments = null;
                $interaction->save();

                // jika juga tidak like → hapus row
                if (!$interaction->liked) {
                    $interaction->delete();
                }

                return response()->json(['ok' => true, 'has_comments' => false]);
            }

            // ada komentar → simpan replace
            $interaction->comments = $selected;
            $interaction->save();

            // ✅ notifikasi comment (update/replace)
            $this->notifyProjectOwner($project, $userId, $userId ? null : $anonId, 'comment', ['comments' => $selected]);

            return response()->json(['ok' => true, 'has_comments' => true, 'comments' => $selected]);
        });
    }

    private function notifyProjectOwner(Project $project, ?int $actorUserId, ?string $actorAnon, string $type, array $payload = []): void
    {
        // Jangan kirim notifikasi jika pemilik = aktor
        if ($actorUserId && $project->user_id === $actorUserId) return;

        // Tentukan nama aktor
        $actorName = 'Unknown';
        if ($actorUserId) {
            $user = \App\Models\User::find($actorUserId);
            if ($user) {
                $first = explode(' ', trim($user->name_asli ?? ''))[0] ?? '';
                $actorName = $first !== '' ? $first : 'User';
            }
        }

        // Bentuk pesan berdasarkan tipe
        if ($type === 'like') {
            $message = "<strong>{$actorName}</strong> liked your work titled <strong>\"{$project->title}\"</strong>";
        } elseif ($type === 'comment') {
            $comments = $payload['comments'] ?? [];
            $joinedComments = is_array($comments) ? implode(', ', $comments) : (string) $comments;

            // newline biar komentar di baris berikut + gaya italic nanti di blade
            $message = "<strong>{$actorName}</strong> commented on your work titled <strong>\"{$project->title}\"</strong>:\n\"{$joinedComments}\"";
        } else {
            $message = "<strong>{$actorName}</strong> interacted with your work titled <strong>\"{$project->title}\"</strong>";
        }


        // Simpan notifikasi
        ProjectNotification::create([
            'project_id'     => $project->id,
            'owner_user_id'  => $project->user_id,
            'actor_user_id'  => $actorUserId,
            'actor_anon_key' => $actorAnon,
            'type'           => $type,
            'payload'        => [
                'message' => $message,
                'project_title' => $project->title,
                'actor_name' => $actorName,
                'comments' => $payload['comments'] ?? [],
            ],
        ]);
    }

}
