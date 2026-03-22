<?php

namespace App\Http\Controllers;

use App\Models\cortes_evaluativos;
use App\Models\modalidades;
use App\Models\Periodo_academicos;

use Illuminate\Http\Request;

class CortesEvaluativosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cortes=cortes_evaluativos::with(['modalidades','periodos'])->get();
        return view('cortes.index',compact('cortes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modalidades=modalidades::all();
        $periodos=Periodo_academicos::all();
        return view('cortes.create',compact('modalidades','periodos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_modalidades'=>'required|exists:modalidades,id',
            'nombre'=>'required|string|max:255',
            'ponderacion'=>'required|integer',
            'id_periodo_academicos'=>'required|exists:periodo_academicos,id',
            'fecha_inicio'=>'required|date',
            'fecha_fin'=>'required|date'
        ]);
       cortes_evaluativos::create($request->all());
       return redirect()->route('cortes.index')->with('success','Creado Correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(cortes_evaluativos $corte)
    {
        return view('cortes.show',compact('corte'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cortes_evaluativos $corte)
    {
            $modalidades=modalidades::all();
            $periodos=Periodo_academicos::all();
        return view('cortes.edit',compact('corte','modalidades','periodos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cortes_evaluativos $corte)
    {
         $request->validate([
            'id_modalidades'=>'required|exists:modalidades,id',
            'nombre'=>'required|string|max:255',
            'ponderacion'=>'required|integer',
            'id_periodo_academicos'=>'required|exists:periodo_academicos,id',
            'fecha_inicio'=>'required|date',
            'fecha_fin'=>'required|date'
        ]);
        $corte->update($request->all());
         return redirect()->route('cortes.index')->with('success','Actualizado Correctamente');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cortes_evaluativos $corte)
    {
        $corte->delete();
        return redirect()->route('cortes.index')->with('success','Creado Correctamente');
    }
}
