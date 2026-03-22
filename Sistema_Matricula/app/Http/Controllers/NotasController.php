<?php

namespace App\Http\Controllers;

use App\Models\Notas;
use Illuminate\Http\Request;
use App\Models\Matriculas;
use App\Models\Horarios;
use App\Models\cortes_evaluativos;
use App\Models\Usuario;

class NotasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //obtener las notas con sus relaciones
        $notas = notas::with(['matriculas','horarios','cortes','usuarios'])->get();
        return view('notas.index',compact('notas'));
    }

    /**
     * Show the form for creating a new resource.
     */
     
    public function create()
    {
        $matriculas=Matriculas::all();
        $horarios=Horarios::all();
        $cortes=cortes_evaluativos::all();
        $usuarios=Usuario::all();
        return view('notas.create',compact('matriculas','horarios','cortes','usuarios'));


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
                
                'id_matricula'=>'required|exists:matriculas,id',
                'id_horario'=>'required|exists:horarios,id',
                'id_corte_evaluativo'=>'required|exists:cortes_evaluativos,id',
                'id_usuario'=>'required|exists:usuarios,id',
                'nota_normal'=>'required|double',
                'nota_especial'=>'required|double',
                'observacion'=>'required|string|max:255'

        ]);
       
        Notas::create($request->all());
        return redirect()->route('notas.index')->with('success','Notas creadas correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notas $nota)
    {
        return view('notas.show',compact('nota'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notas $nota)
    {
        return view('notas.edit',compact('nota','matriculas','horarios','cortes','usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notas $notas)
    {
        $request ->validate([
               'id_matricula'=>'required|exists:matriculas,id',
                'id_horario'=>'required|exists:horarios,id',
                'id_corte_evaluativo'=>'required|exists:cortes_evaluativos,id',
                'id_usuario'=>'required|exists:usuarios,id',
                'nota_normal'=>'required|double',
                'nota_especial'=>'required|double',
                'observacion'=>'required|string|max:255'
        ]);
        $notas->update($request->all());
        return redirect()->route('notas.index')->with('success','Notas actualizadas correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notas $nota)
    {
        $nota->delete();
        return redirect()->route('notas.index')->with('success','Notas eliminadas correctamente');
        
    }
}
