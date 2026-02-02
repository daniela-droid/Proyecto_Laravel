<?php

namespace App\Http\Controllers;

use App\Models\Grupos;
use Illuminate\Http\Request;

class GruposController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grupos=Grupos::with(['docentes','turnos'])->get();

        return view('grupos.index',compact('grupos'));
    }

    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        $docentes=Docentes::all();
        $turnos=Turnos::all();
        return view('grupos.create',compact('docentes','turnos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
                'Codigo'=>'required|string|max:255',
                'Nombre'=>'required|string|max:255',
                'Descripcion'=>'required|string|max:255',
                'Seccion'=>'required|string|max:255',
                'Grado'=>'required|string|max:255',
                'id_turnos'=>'required|exists:turnos,id',
                'id_docentes'=>'required|exists:docentes,id',
                'Periodo'=>'required|string|max:255',

        ]);
        Grupos::create([
                'Codigo'=>$request->Codigo,
                'Nombre'=>$request->Nombre,
                'Descripcion'=>$request->Descripcion,
                'Seccion'=>$request->Seccion,
                'Grado'=>$request->Grado,
                'id_turnos'=>$request->id_turnos,
                'id_docentes'=>$request->id_docentes,
                'Periodo'=>$request->Periodo

            ] );
    return redirect()->route('grupos.index')->with('succes','Grupo creado correctamete');

    }

    /**
     * Display the specified resource.
     */
    public function show(Grupos $grupo)
    {
        return view('grupos.show',compact('grupo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grupos $grupo)
    {
        $turnos=Turnos::all();
        $docentes=Docentes::all();
        return view('grupos.edit',compact('grupo','turnos','docentes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grupos $grupos)
    {
        $request->validate([
            'Codigo'=>'required|string|max:255',
            'Nombre'=>'required|string|max:255',
            'Descripcion'=>'required|string|max:255',
            'Seccion'=>'required|string|max:255',
            'Grado'=>'required|string|max:255',
            'id_turnos'=>'required|exists:turnos,id',
            'id_docentes'=>'required|exists:docentes,id',
            'Periodo'=>'required|string|max:255',

        ]);
        $grupos->update([
            'Codigo'=>$request->Codigo,
                'Nombre'=>$request->Nombre,
                'Descripcion'=>$request->Descripcion,
                'Seccion'=>$request->Seccion,
                'Grado'=>$request->Grado,
                'id_turnos'=>$request->id_turnos,
                'id_docentes'=>$request->id_docentes,
                'Periodo'=>$request->Periodo

        ]);
        return redirect()->route('grupos.index')->with('succes','Grupo Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grupos $grupo)
    {
        $grupo->delete();
        return redirect()->route('grupos.index')->with('succes','Grupos Elimindado');
    }
}
