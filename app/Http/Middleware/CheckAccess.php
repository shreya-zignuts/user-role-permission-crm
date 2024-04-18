<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Module;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

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

    if (!$user) {
      return redirect()->route('login');
    }

    $permissions = $user->getModulePermissions($user, $moduleCode);

    // Check if the user has the required permission for the requested action
    if (!$permissions[$action]) {
      // You can redirect to an error page or a suitable fallback route
      return redirect()
        ->back()
        ->with('error', 'Unauthorized Access');
    }

    return $next($request);
  }
}