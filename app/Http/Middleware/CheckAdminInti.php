<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminInti
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Auto-login as admin_inti user (assuming user with ID 1 is admin_inti)
        $adminInti = \App\Models\User::where('role', 'admin_inti')->first();
        
        if (!$adminInti) {
            return response('Admin inti user not found', 403);
        }
        
        Auth::login($adminInti);
        
        return $next($request);

        return $next($request);
    }
}
