<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class RedirectIfAdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the admin guard user is logged in
        if (Auth::guard('admin')->check()) {
            // Redirect to admin dashboard if logged in
            $admin = Auth::guard('admin')->user();

            // Redirect based on user type
            switch ($admin->user_type) {
                case 'superadmin':
                    return redirect()->route('coffee.dashboard');
                case 'admin':
                    return redirect()->route('coffee.admin.dashboard');
                case 'management':
                    return redirect()->route('coffee.management.dashboard');
                case 'member':
                    return redirect()->route('coffee.member.dashboard');
                case 'agent':
                    return redirect()->route('coffee.agent.dashboard');
                default:
                    // If the user_type is not recognized, log out the user
                    Auth::guard('admin')->logout();
                    return redirect()->route('login')->withErrors(['unauthorized' => 'Access not allowed']);
            }
        }
        return $next($request);
    }
}
