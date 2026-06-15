<?php

namespace App\Http\Controllers;

use App\Models\Docentes;
use App\Models\Usuario;
use App\Models\Especialidad;
use Illuminate\Http\Request;

class DocentesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //listamos los maestros
        $docentes=Docentes::with(['usuarios','especialidades'])->get();
          
        //para pruebas de request
       // dd($docentes->toArray());
        return view('docentes.index',compact('docentes'));
     }

    
    public function create()
    {
         $usuarios=Usuario::all();
        $especialidads=Especialidad::all();
        return view('docentes.create',compact('usuarios','especialidads'));

    }

    
    public function store(Request $request)
    {
       $validated = $request->validate($this->rulesDocente(), $this->messagesDocente());

        $validated['Telefono'] = trim($validated['Telefono']);

        $usuario = Usuario::findOrFail($validated['id_usuario']);

        Docentes::create([
            'id_usuario' => $validated['id_usuario'],
            'Nombre' => $validated['Nombre'],
            'Apellido' => $validated['Apellido'],
            'FechadeNacimiento' => $validated['FechadeNacimiento'],
            'Telefono' => $validated['Telefono'],
            'id_especialidads' => $validated['id_especialidads'],
            'Email' => $usuario->Email,
        ]);

        $redirectChoice = $request->input('redirect_choice', 'docentes');
        if ($redirectChoice === 'horarios') {
            return redirect()->route('horarios.create')->with('success', 'Docente creado correctamente');
        }

        return redirect()->route('docentes.index')->with('success','Docente creado correctamente');

    }

    private function rulesDocente(): array
    {
        return [
            'id_usuario'=>'required|exists:usuarios,id',
            'Nombre'=>'required|string|max:255',
            'Apellido'=>'required|string|max:255',
            'FechadeNacimiento'=>'required|date',
            'Telefono'=>['required', 'string', 'regex:/^\+505[0-9]{8}$/'],
            'id_especialidads'=>'required|exists:especialidads,id',
        ];
    }

    private function messagesDocente(): array
    {
        return [
            'Telefono.regex' => 'El teléfono debe tener el formato +50512345678.',
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Docentes $docente)
    {
        return view('docentes.show',compact('docente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Docentes $docente)
    {
        $usuarios=Usuario::all();
        $especialidads=Especialidad::all();
        return view('docentes.edit',compact('docente','usuarios','especialidads'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Docentes $docente)
    {
       $validated = $request->validate([
           
            'id_usuario'=>'required|exists:usuarios,id|unique:docentes,id_usuario,'. $docente->id,
            'Nombre'=>'required|string|max:255',
            'Apellido'=>'required|string|max:255',
            'FechadeNacimiento'=>'required|date',
            'Email'=>'required|string|max:255|unique:docentes,Email,' . $docente->id,
            'Telefono'=>['required', 'string', 'regex:/^\+505[0-9]{8}$/'],
            'id_especialidads'=>'required|exists:especialidads,id'

        ], $this->messagesDocente());

        $validated['Telefono'] = trim($validated['Telefono']);

        $docente->update($validated);
        return redirect()->route('docentes.index')->with('succes','Docentes Actualizado correctamete');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Docentes $docente)
    {
        $docente->delete();

        return redirect()->route('docentes.index')->with('succes','El docente ha sido eliminado');
    }
}
