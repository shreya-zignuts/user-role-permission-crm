<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user id is 1 (admin)
            if (Auth::check() && Auth::user()->id !== 1 && Auth::user()->tokens()->count() === 0) {
                return redirect()->route('login')->with('error', 'Forecefully Logout');
            }
        }

        return $next($request);
    }
}
