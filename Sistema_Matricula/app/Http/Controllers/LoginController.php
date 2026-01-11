<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Mostrar formulario de login
   public function showLoginForm()
{
    return view('auth.login');
}

public function login(Request $request)
{
    $request->validate([
        'gmail' => 'required|email',
        'password' => 'required|string',
    ]);

    $credentials = $request->only('gmail', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Redirigir según rol
        if ($user->rol == 'admin' || $user->rol == 'docente') {
            return redirect()->route('inicio'); // por ahora todos van a inicio
        }
    }

    return back()->withErrors(['gmail' => 'Credenciales incorrectas'])->withInput();
}

public function logout()
{
    Auth::logout();
    return redirect()->route('login');
}

}
