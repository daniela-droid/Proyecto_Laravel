<?php

namespace App\Http\Controllers;

use App\Models\Matriculas;
use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Asignatura;

class MatriculasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        //obtener las matriculas con estudiante y asignatura
        $matriculas  = Matriculas::with(['estudiantes','asignaturas'])->get();
        return view('matriculas.index',compact('matriculas'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //traer estudiantes y asignaturas para el select
        $estudiante=Estudiante::all();
        $asignatura=Asignatura::all();
        return view('matriculas.create',compact('estudiante','asignatura'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validacion
        $request->validate(
            [
                'id_estudiantes'=>'required|exists:estudiantes,id',
                'id_asignaturas'=>'required|exists:asignaturas,id',
            ]
        );
        //crear la matricula
        Matricula::create([
            'id_estudiantes' =>$request->id_estudiantes,
            'id_asignaturas' =>$request->id_asignaturas

            ]);
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
    public function edit(Matriculas $matriculas)
    {
        $estudiantes = Estudiante::all();
        $asignaturas = Asignatura::all();
        return view('matriculas.edit',compact('matriculas','estudiantes','asignaturas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Matriculas $matriculas)
    {
        $request->validate([
            'id_estudiantes' => 'required|exists:estudiantes,id',
            'id_asignaturas' => 'required|exists:asignaturas,id'
        ]);
        $matriculas->update([
        'id_estudiantes' =>$request->id_estudiantes,
        'id_asignaturas' =>$request->id_asignaturas

        ]);

        return redirect()->route('matriculas.index')->with('success','Matricula actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matriculas $matriculas)
    {
        $matriculas->delete();
        return redirect()->route('matriculas.index')->with('success','Matricula eliminada correctamente');
    }
}
