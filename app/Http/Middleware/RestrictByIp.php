<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictByIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedIps = explode(',', env('ALLOWED_IPS', ''));
        $clientIp = $request->ip();

        if (!in_array($clientIp, $allowedIps)) {
            return response()->json(['message' => 'Unauthorized','ip'=>$clientIp], 403);
        }

        return $next($request);
    }
}
