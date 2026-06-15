<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

  public function login(Request $request) {
    $credentials = $request->validate([
        'Email' => 'required|email',
        'password' => 'required'
    ]);

    // 1. Intentamos el login con los datos reales
    $authSuccess = Auth::attempt(['Email' => $request->Email, 'password' => $request->password]);

    // 2. 💡 EL TRUCO: Reemplazamos inmediatamente la contraseña por asteriscos en la petición
    $request->merge(['password' => '********']);

    if ($authSuccess) {
        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->rol === 'docentes') {
            return redirect()->route('docente.mi_horario');
        }
        
        return redirect()->intended('/inicio');
    }

    return back()->withErrors(['Email' => 'Credenciales incorrectas']);
}

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}