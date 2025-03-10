<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // ✅ Import Auth Facade

class AuthMiddleware // ✅ Rename to avoid conflicts with the built-in Laravel Auth
{
 /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) { // ✅ Use Auth::check() instead of auth()->check()
            return $next($request);
        }

        // Store a session alert message
        session()->flash('alert', 'You are not logged in.');

        return redirect()->route('auth.signin'); // Ensure this route exists
    }
}
