<?php

namespace App\Http\Controllers;

use App\Models\Matriculas;
use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Grupos;
use App\Models\Periodo_academicos;
use App\Models\Usuario;

class MatriculasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        //obtener las matriculas con estudiante y asignatura
        $matriculas  = Matriculas::with(['estudiantes','grupos.Grados','periodos','usuarios'])->get();
        return view('matriculas.index',compact('matriculas'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //traer estudiantes y asignaturas para el select
        $estudiantes=Estudiante::all();
        $grupos=Grupos::all();
        $periodos=Periodo_academicos::all();
        $usuarios=Usuario::all();
        return view('matriculas.create',compact('estudiantes','grupos','periodos','usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      //return  $request->all();
        //validacion
      $request->validate(
            [
                'id_estudiante'=>'required|exists:estudiantes,id',
                'id_grupo'=>'required|exists:grupos,id',
                'id_periodo_academicos'=>'required|exists:periodo_academicos,id',
                //'id_usuario'=>'required|exists:usuarios,id',
                'fecha_matricula'=>'required|date',//date
                'estado'=>'required|in:Activo,Retirado,Suspendido,Expulsado',  //enum
                'observaciones'=>'required|string|max:255'//string
            ]
        );
        //agregamos al usuario manuelmente
        $request['id_usuario'] = auth()->id();
        //crear la matricula
        Matriculas::create($request->all());
        return redirect()->route('matriculas.index')->with('success','Matriculas creada correctamente');
            }


    /**
     * Display the specified resource.
     */
    public function show(Matriculas $matricula)
    {
       return view('matriculas.show',compact('matricula'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matriculas $matricula)
    {
         $estudiantes=Estudiante::all();
        $grupos=Grupos::all();
        $periodos=Periodo_academicos::all();
        $usuarios=Usuario::all();
        return view('matriculas.edit',compact('matricula','estudiantes','grupos','periodos','usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, Matriculas $matricula)
{   
          $request->validate([
                 'id_estudiante'=>'required|exists:estudiantes,id',
                'id_grupo'=>'required|exists:grupos,id',
                'id_periodo_academicos'=>'required|exists:periodo_academicos,id',
              //  'id_usuario'=>'required|exists:usuarios,id',
                'fecha_matricula'=>'required|date',//date
                'estado'=>'required|in:Activo,Retirado,Suspendido,Expulsado',  //enum
                'observaciones'=>'required|string|max:255'//string
            
        
    ]);

    $matricula->update($request->all());
     return redirect()->route('matriculas.index')->with('success', 'Matrícula actualizada correctamente');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matriculas $matricula)
    {
        $matricula->delete();
        return redirect()->route('matriculas.index')->with('success','Matricula eliminada correctamente');
    }
}
