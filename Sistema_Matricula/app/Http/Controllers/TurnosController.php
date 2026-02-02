<?php

namespace App\Http\Controllers;

use App\Models\Turnos;
use Illuminate\Http\Request;

class TurnosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $turnos=Turnos::all();
        return view('turnos.index',compact('turnos'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('turnos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'Nombre'=>'required|string|max:255',
        'Descripcion'=>'required|string|max:255'


        ]);    

        Turnos::create($request->all());
        return redirect()->route('turnos.index')->with('succes','Turnos Creado');

    }

    /**
     * Display the specified resource.
     */
    public function show(Turnos $turno)
    {
        return view('turnos.show',compact('turno'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Turnos $turno)
    {
        return view('turnos.edit',compact('turno'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Turnos $turno)
    {
        $request->validate([
        'Nombre'=>'required|string|max:255',
        'Descripcion'=>'required|string|max:255'


        ]);   

        $turno->update($request->all());
        return redirect()->route('turnos.index')->with('succes','Turno ha sido Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turnos $turno)
    {
        $turno->delete();
        return redirect()->route('turnos.index')->with('succes','Turnos Eliminado');
    }
}
