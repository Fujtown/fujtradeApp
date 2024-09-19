<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY');
        $validApiKey = env('FUJTRADE_API_KEY'); // You should define this in your .env file
        // dd($request);
        if ($apiKey !== $validApiKey) {
            // If API key is invalid or not provided, return error response
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
