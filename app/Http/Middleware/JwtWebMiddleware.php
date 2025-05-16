<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtWebMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = $request->cookie('jwt_token') ?: $request->bearerToken();

            if (!$token) {
                return redirect()->route('login');
            }

            $user = JWTAuth::setToken($token)->authenticate();

            if (!$user) {
                return redirect()->route('login');
            }

            $request->merge(['user' => $user]);

        } catch (\Exception $e) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
