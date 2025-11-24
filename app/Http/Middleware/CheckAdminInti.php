<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
        // Ensure an admin_inti user exists; create if missing (dev/local convenience)
        $user = User::firstOrCreate(
            ['email' => 'admin_inti@example.com'],
            [
                'name' => 'Admin Inti',
                'password' => Hash::make('admin 1'),
                'role' => 'admin_inti',
                'email_verified_at' => now(),
            ]
        );

        // Auto-login admin_inti user if not already authenticated as such
        if (!Auth::check() || (Auth::user()->role ?? null) !== 'admin_inti') {
            Auth::login($user);
        }

        return $next($request);
    }
}
