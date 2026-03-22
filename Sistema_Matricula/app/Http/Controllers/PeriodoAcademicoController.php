<?php

namespace App\Http\Controllers;

use App\Models\Periodo_academicos;
use Illuminate\Http\Request;

class PeriodoAcademicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periodo_academicos=Periodo_academicos::all();
        return view('periodo.index',compact('periodo_academicos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('periodo.create');

   }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nombre'=>'required|string|max:255',
            'Fecha_inicio'=>'required|date', 
            'Fecha_fin' => 'required|date|after_or_equal:Fecha_inicio',
            'Activo'=>'required|boolean'

        ]);
        Periodo_academicos::create($request->all());
        return redirect()->route('periodo.index')->with('success','Ha sido creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Periodo_academicos $periodo)
    {
        return view('periodo.show',compact('periodo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Periodo_academicos $periodo)
    {
        return view('periodo.edit',compact('periodo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Periodo_academico $periodo)
    {
           $request->validate([
                'Nombre'=>'required|string|max:255',
               'Fecha_inicio'=>'required|date', 
               'Fecha_fin'=>'required|date|after_or_equal:Fecha_inicio',  
               'Activo'=>'required|boolean'

        ]);
        $periodo->update($request->all());

      return redirect()->route('periodo.index')->with('success','Ha sido actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Periodo_academicos $periodo)
    {
        $periodo->delete();    

      return redirect()->route('periodo.index')->with('success','Ha sido eliminado correctamente');
    }
}
