<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
  //PARA VERIFICAR ROLES
       public function handle(Request $request, Closure $next, $role)
    {
         // Verifica si el usuario está logueado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Si se pasan roles, verifica que el rol del usuario coincida
        if ($roles && !in_array($user->rol, $roles)) {
            abort(403, 'No autorizado');
        }

        return $next($request);
    }


    
}
