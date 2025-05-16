<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiProtectedRoute
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (! $user->isAtivo()) {
                return response()->json(['status' => 'Usuário não está ativo no sitema.'], 401);
            }

            $request->merge(['userData' => $user]);
            auth()->setUser($user);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['status' => 'Token is Invalid'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['status' => 'Token is Expired'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => 'Authorization Token not found'], 403);
        }

        return $next($request);
    }
}
