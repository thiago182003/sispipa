<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerificaNivelAcesso
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $rotaAtual = $request->route()->getName(); // Obtém o nome da rota atual

        if ($user->nivel !== 'Admin' && $rotaAtual === 'rota-restrita') {
            abort(403, 'Acesso não permitido.');
        }

        return $next($request);
    }
}
