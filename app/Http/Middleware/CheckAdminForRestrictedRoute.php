<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminForRestrictedRoute
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user(); // Usa o helper direto do Request

        if ($user && $user->nivel !== 'Admin' && $request->route()->getName() === 'rota-restrita') {
            abort(403, 'Acesso não permitido.');
        }

        return $next($request);
    }
}

