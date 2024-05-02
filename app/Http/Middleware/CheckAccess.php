<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $moduleCode, $action)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $permissions = $user->getModulePermissions($user, $moduleCode);

        // Check if the user has the required permission for the requested action
        if (! $permissions[$action]) {
            return redirect()
                ->back()
                ->with('error', 'Unauthorized Access');
        }

        return $next($request);
    }
}
