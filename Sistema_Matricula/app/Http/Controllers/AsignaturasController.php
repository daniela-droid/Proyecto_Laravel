<?php

namespace App\Http\Controllers;

use App\Models\Asignaturas;
use Illuminate\Http\Request;

class AsignaturasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asignaturas =Asignaturas::all();
        return view('asignaturas.index',compact('asignaturas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('asignaturas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request ->validate([
            'nombre'=>'required|string|max:255'
        ]);
        
        Asignaturas::create($request->all());
        return redirect()->route('asignaturas.index')->with('success','Asignatura creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asignaturas $asignatura)
    {
        return view('asignaturas.show',compact('asignatura'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asignaturas $asignatura)
    {
        return view('asignaturas.edit',compact('asignatura'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asignaturas $asignatura)
    {
        $request->validate([
            'nombre'=>'required|string|max:255'

        ]);
        $asignatura->update($request->all());
        return redirect()->route('asignaturas.index')->with('access','asignaturas actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asignaturas $asignatura)
    {
        $asignatura->delete();
        return redirect()->route('asignaturas.index')->with('access','asignatura eliminada');
    }
}
