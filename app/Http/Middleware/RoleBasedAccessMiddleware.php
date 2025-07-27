<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleBasedAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permissionType = null, ...$permissions): Response
    {
        // First check if user is authenticated
        if (!Auth::check()) {
            // Clear intended url to prevent redirect loops
            $request->session()->forget('url.intended');
            return redirect()->route('login')
                ->with('error', 'U moet ingelogd zijn om toegang te krijgen tot deze functie.');
        }

        // Skip permission check if no permissions are specified
        if (empty($permissions)) {
            return $next($request);
        }

        $user = Auth::user();
        $permissionType = strtolower($permissionType ?? 'any');

        switch ($permissionType) {
            case 'all':
                $hasPermission = $user->hasAllPermissions($permissions);
                break;
            case 'any':
            default:
                $hasPermission = $user->hasAnyPermission($permissions);
                break;
        }

        if ($hasPermission) {
            return $next($request);
        }

        // Admin user can bypass permission checks (optional)
        if ($user->hasRole('admin')) {
            return $next($request);
        }

        return redirect()->route('admin.dashboard')
            ->with('error', 'Je hebt geen toegang tot deze functie.');
    }
}
