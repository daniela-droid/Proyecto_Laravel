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

    if (Auth::attempt(['Email' => $request->Email, 'password' => $request->password])) {
        $request->session()->regenerate();
        $user = Auth::user();

        // AQUÍ decides a dónde va cada uno
        if ($user->rol === 'docentes') {
            return redirect()->route('docente.mi_horario');
        }
        
        return redirect()->intended('/inicio'); // Para el admin
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