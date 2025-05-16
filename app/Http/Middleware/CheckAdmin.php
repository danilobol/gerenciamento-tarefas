<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json(['status' => 'Usuário não autenticado.'], 401);
        }

        if (! $user->isAdmin()) {
            return response()->json(['status' => 'Acesso permitido apenas para administradores.'], 403);
        }

        return $next($request);
    }
}
