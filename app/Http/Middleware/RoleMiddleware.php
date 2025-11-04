<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Pakai: ->middleware('role:dosen,kaprodi')
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            abort(401);
        }

        // jika tidak ada daftar role di parameter, tolak
        if (empty($roles)) {
            abort(403);
        }

        // lolos kalau role user ada di daftar $roles
        if (!in_array($user->role, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
