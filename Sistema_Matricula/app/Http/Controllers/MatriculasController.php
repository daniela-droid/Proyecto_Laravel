<?php

namespace App\Http\Controllers;

use App\Models\Matriculas;
use Illuminate\Http\Request;

class MatriculasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //obtener las matriculas con estudiante y asignatura
        $matriculas  = matriculas::with(['estudiante','asignatura'])->get();
        return view('matriculas.index',compact('matriculas'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //traer estudiantes y asignaturas para el select
        $estudiantes= Estudiantes::all();
        $asignaturas = Asignaturas::all();
        return view('matriculas.create',compact('estudiantes',asignaturas));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validacion
        $request->validate(
            [
                'id_estudiante'=>'required|exists:estudiantes,id',
                'id_asignatura'=>'required|exists:asignaturas,id',
            ]
        );
        //crear la matricula
        Matricula::create([
'id_estudiante' =>$request->id_estudiante,
'id_asignatura' =>$request->id_asignatura

]);
return redirect()->route('matriculas.index')->with('success','Matriculas creada correctamente');
    }


    /**
     * Display the specified resource.
     */
    public function show(Matriculas $matriculas)
    {
       return view('matriculas.show',compact('matriculas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matriculas $matriculas)
    {
        $estudiantes = Estudiantes::all();
        $asignaturas = Asignaturas::all();
        return view('matriculas.edit',compact('matriculas','estudiantes','asignaturas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Matriculas $matriculas)
    {
        $request->validate([
            'id_estudiante' => 'required|exists:estudiantes,id',
            'id_asignatura' => 'required|exists:asignaturas,id'
        ]);
        $matriculas->update([
        'id_estudiante' =>$request->id_estudiante,
        'id_asignatura' =>$request->id_asignatura

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
