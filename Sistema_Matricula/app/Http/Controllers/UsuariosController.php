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
        $usuarios=usuario::all();
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
                'nombre'=>'required|string|max:80',
                'gmail'    => 'required|string|email|max:125|unique:usuarios,gmail',
                'password' => 'required|string|min:8|confirmed', 
                'rol'      => 'required|in:admin,docente'

        ]);
      Usuario::create([
            'nombre'   => $request->nombre,
            'gmail'    => $request->gmail,
            'password' => Hash::make($request->password),
            'rol'      => $request->rol,
        ]);

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
   public function update(Request $request, Usuario $usuarios)
{
    $request->validate([
        'nombre' => 'required|string|max:80',
        'gmail'  => 'required|string|email|max:125|unique:usuarios,gmail,' . $usuarios->id,
        'password' => 'nullable|string|min:8|confirmed', // puede ser opcional
        'rol' => 'required|in:admin,docente'
    ]);

    $data = [
        'nombre' => $request->nombre,
        'gmail'  => $request->gmail,
        'rol'    => $request->rol
    ];

    // Solo actualizar contraseña si se ingresó
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $usuarios->update($data);

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
