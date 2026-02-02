<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;// IMPORTANTE

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles) // <-- 2. Usar el operador ... para recibir múltiples roles
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Verificamos si el rol del usuario está dentro de la lista de roles permitidos
        if (!in_array($user->rol, $roles)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}