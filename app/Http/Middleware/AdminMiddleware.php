<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // ✅ importamos tu modelo

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        /** @var User|null $user */  // ✅ le decimos al IDE qué tipo es
        $user = Auth::user();

        if (!$user || !$user->isAdmin()) {
            abort(403, 'No autorizado.');
        }

        return $next($request);
    }
}
