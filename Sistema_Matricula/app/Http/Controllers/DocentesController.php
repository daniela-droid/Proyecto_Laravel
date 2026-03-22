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
       $request->validate([
           
            'id_usuario'=>'required|exists:usuarios,id',
            'Nombre'=>'required|string|max:255',
            'Apellido'=>'required|string|max:255',
            'FechadeNacimiento'=>'required|date',
            'Email'=>'required|string|max:255',
            'Telefono'=>'required|integer',
            'id_especialidads'=>'required|exists:especialidads,id'

        ]);
    Docentes::create($request->all());
    return redirect()->route('docentes.index')->with('secces','Docente creado correctamente');

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
        $usuario=Usuario::all();
        $especialidad=Especialidad::all();
        return view('docentes.edit',compact('docente','usuario','especialidad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Docentes $docente)
    {
       $request->validate([
           
            'id_usuario'=>'required|exists:usuarios,id|unique:docentes,id_usuario,'. $docente->id,
            'Nombre'=>'required|string|max:255',
            'Apellido'=>'required|string|max:255',
            'FechadeNacimiento'=>'required|date',
            'Email'=>'required|string|max:255|unique:docentes,Email,' . $docente->id,
            'Telefono'=>'required|integer',
            'id_especialidads'=>'required|exists:especialidads,id'

        ]);
        $docente->update($request->all());
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
