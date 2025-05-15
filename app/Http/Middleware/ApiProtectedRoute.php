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
            $user = JWTAuth::parseToken()->checkOrFail();
            $userInfo = $user->get('user');
            $userData = (object)['userInfo' => $userInfo];

            $request->merge(['userData' => $userData]);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return \response()->json(['status' => 'Token is Invalid'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return \response()->json(['status' => 'Token is Expired'], 401);
        } catch (\Illuminate\Database\QueryException $e) {
            return $next($request);
        } catch (\Exception $e) {
            return \response()->json(['status' => 'Authorization Token not found'], 403);
        }

        return $next($request);
    }
}
