<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AttachAuthToken
{
    /**
     * Attach Authorization header from auth_token cookie if present.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasHeader('Authorization')) {
            $token = $request->cookie('auth_token');
            if ($token) {
                $request->headers->set('Authorization', 'Bearer '.$token);
            }
        }

        return $next($request);
    }
}