<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Check if the user is authenticated and is an admin
         if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Optionally, you can add a response or redirect if the user is not an admin

        // If the user is not an admin, redirect to login page
        return redirect()->route('admin')->withErrors(['You must be an administrator to view this page.']);

    }
}
