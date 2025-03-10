<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
 /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if the user has the required role(s)
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Unauthorized Access');
        }

        return $next($request);
    }}
