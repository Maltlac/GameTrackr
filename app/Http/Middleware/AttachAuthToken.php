<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AttachAuthToken
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->header('Authorization')) {
            $token = $request->cookie('auth_token');
            if ($token) {
                $request->headers->set('Authorization', 'Bearer '.$token);
            }
        }
        return $next($request);
    }
}