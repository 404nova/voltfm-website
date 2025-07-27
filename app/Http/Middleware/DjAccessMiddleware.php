<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class DjAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if ($user && ($user->hasRole('dj') || $user->hasRole('admin') || $user->hasRole('beheer'))) {
            return $next($request);
        }
        
        return redirect()->route('admin.dashboard')->with('error', 'Je hebt geen toegang tot deze functie.');
    }
}
