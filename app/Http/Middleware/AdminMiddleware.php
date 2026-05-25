<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($user && $user->is_admin) {
            return $next($request);
        }
        abort(403, 'Accès réservé aux administrateurs.');
    }
}
