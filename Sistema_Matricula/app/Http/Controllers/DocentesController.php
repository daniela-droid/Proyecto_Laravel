<?php

namespace App\Http\Controllers;

use App\Models\Docentes;
use Illuminate\Http\Request;

class DocentesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //listamos los maestros
        $docentes=Docentes::all();
        //para pruebas de request
       // dd($docentes->toArray());
        return view('docentes.index',compact('docentes'));
     }

    
    public function create()
    {
        return view('docentes.create');

    }

    
    public function store(Request $request)
    {
        $request->validate([
            'Nombre'=>'required|string|max:255',
            'Apellido'=>'required|string|max:255',
            'FechadeNacimiento'=>'required|date',
            'Gmail'=>'required|string|max:255',
            'Telefono'=>'required|integer',
            'Especialidad'=>'required|string:max:255',
            'GrupoAsignado'=>'required|string|max:255'

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
        return view('docentes.edit',compact('docente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Docentes $docente)
    {
        $request->validate([
            'Nombre'=>'required|string|max:255',
            'Apellido'=>'required|string|max:255',
            'FechadeNacimientod'=>'require|date',
            'Gmail'=>'required|string|max:255',
            'Telefono'=>'required|integer',
            'Especialidad'=>'required|string:max:255',
            'GrupoAsignado'=>'required|string|max:255'

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
