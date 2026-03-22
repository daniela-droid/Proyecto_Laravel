<?php

namespace App\Http\Controllers;

use App\Models\Grupos;
use App\Models\Turnos;
use App\Models\Grados;
use App\Models\Periodo_academicos;
use App\Http\Controllers\GradosController;
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\TurnosController;

use Illuminate\Http\Request;

class GruposController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grupos=Grupos::with(['turnos','grados','periodos'])->get();

        return view('grupos.index',compact('grupos'));
    }

    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
       
        $turnos=Turnos::all();
        $grados=Grados::all();
        $periodos=Periodo_academicos::all();
        return view('grupos.create',compact('turnos','grados','periodos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
                'Código'=>'required|string|max:255',
                'Nombre'=>'required|string|max:255',
                'Descripcion'=>'required|string|max:255',
                'id_turno'=>'required|exists:turnos,id',
                'id_grado'=>'required|exists:grados,id',
                'id_periodo_academicos'=>'required|exists:periodo_academicos,id'

        ]);
        Grupos::create($request->all());
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
        $grados=Grados::all();
        $periodos=Periodo_academicos::all();
        return view('grupos.edit',compact('grupo','turnos','grados','periodos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grupos $grupo)
    {
        $request->validate([
                'Código'=>'required|string|max:255',
                'Nombre'=>'required|string|max:255',
                'Descripcion'=>'required|string|max:255',
                'id_turno'=>'required|exists:turnos,id',
                'id_grado'=>'required|exists:grados,id',
                'id_periodo_academicos'=>'required|exists:periodo_academicos,id'
        ]);
        $grupo->update($request->all());
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
