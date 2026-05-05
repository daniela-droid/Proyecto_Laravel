<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReportesAdmin;

class CheckRole
{
   public function handle(Request $request, Closure $next, ...$roles)
{
    // 1. Si no hay nadie logueado, NO revises roles. 
    // Deja que Laravel lo mande al Login mediante el middleware 'auth'.
    if (!Auth::check()) {
        return $next($request); 
    }

    $user = Auth::user();

    // 2. Si el usuario está logueado, entonces SÍ revisamos si tiene el rol
    if (in_array($user->rol, $roles)) {
        return $next($request);
    }

    return redirect()->route('No_permisos');
}
}