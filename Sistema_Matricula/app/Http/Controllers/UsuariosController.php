<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //obtener usuarios
        $usuarios=Usuario::all();
        return view('usuarios.index',compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //creamos el usuaurio
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        $request->validate([
               'Email'    => 'required|string|email|max:125|unique:usuarios,Email',
                'password' => 'required|string|min:8|confirmed', 
                'rol'      => 'required|in:admin,docentes'

        ]);
      Usuario::create([
            'Email'    => $request->Email,
            'password' => Hash::make($request->password),
            'rol'      => $request->rol,
        ]);

        $redirectChoice = $request->input('redirect_choice', 'usuarios');
        if ($redirectChoice === 'docentes') {
            return redirect()->route('docentes.create')->with('success','Usuario creado correctamente');
        }

        return redirect()->route('usuarios.index')->with('success','Usuario creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        //
        return view('usuarios.show',compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $usuario)
    {
        return view('usuarios.edit',compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Usuario $usuario)
{
    $request->validate([
       
        'Email'  => 'required|string|email|max:125|unique:usuarios,Email,' . $usuario->id,
        'password' => 'nullable|string|min:8|confirmed', 
        'rol' => 'required|in:admin,docentes'
    ]);

    $data = [
        
        'Email'  => $request->Email,
        'rol'    => $request->rol
    ];

    // Solo actualizar contraseña si se ingresó
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $usuario->update($data);

    return redirect()->route('usuarios.index')->with('success','Editado correctamente');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success','Usuario eliminado correctamente');
    }
}
