<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $especialidads=Especialidad::all();
        return view('especialidades.index',compact('especialidads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('especialidades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Especialidad'=>'required|string|max:70',
            'Descripcion'=>'required|string|max:255'


        ]);
        Especialidad::create($request->all());
        return redirect()->route('especialidades.index')->with('success','Especialidad Creada');
    }

    /**
     * Display the specified resource.
     */
    public function show(Especialidad $especialidad)
    {
        return view('especialidades.show',compact('especialidad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Especialidad $especialidad)
    {
        return view('especialidades.edit',compact('especialidad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Especialidad $especialidad)
    {
         $request->validate([
            'Especialidad'=>'required|string|max:70',
            'Descripcion'=>'required|string|max:255'

        ]);

        $especialidad->update($request->all());
         return redirect()->route('especialidades.index')->with('success','Especialidad Actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Especialidad $especialidad)
    {
        $especialidad->delete();
     return redirect()->route('especialidades.index')->with('success','Especialidad Eliminado');
    }
}
