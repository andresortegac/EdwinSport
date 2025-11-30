<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeveloperMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // ✅ Entra dueño developer y también admins
        if (!in_array(strtolower($user->role), ['developer', 'admin', 'superadmin'])) {
            abort(403, 'No autorizado');
        }

        return $next($request);
    }
}
