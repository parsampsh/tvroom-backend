<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function handle(Request $request, $next)
    {
        if (! auth()->check()) {
            return response()->json([
                'error' => 'Authentication is required',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
