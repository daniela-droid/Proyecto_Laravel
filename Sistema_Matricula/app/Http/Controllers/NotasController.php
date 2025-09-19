<?php

namespace App\Http\Controllers;

use App\Models\Notas;
use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Asignatura;
use App\Models\Usuario;

class NotasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //obtener las notas con sus relaciones
        $notas = notas::with(['estudiante','asignatura','usuarios'])->get();
        return view('notas.index',compact('notas'));
    }

    /**
     * Show the form for creating a new resource.
     */
     
    public function create()
    {
        $estudiantes=Estudiante::all();
        $asignaturas=Asignatura::all();
        $usuarios=Usuario::all();
        return view('notas.create',compact('estudiantes','asignaturas','usuarios'));


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
                'id_estudiantes'=>'required|exists:estudiantes,id',
                'id_asignaturas'=>'required|exists:asignaturas,id',
                'id_usuarios'=>'required|exists:usuarios,id',
              'notas' => 'required|numeric|decimal:2|min:0|max:100',

        ]);
       
        Notas::create([
            'id_estudiantes' =>$request->id_estudiantes,
            'id_asignaturas' =>$request->id_asignaturas,
            'Id_usuarios'=>$request->id_usuarios,
            'notas'=> $request->nota

        ]);
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
    public function edit(Notas $notas)
    {
        $estudiantes=Estudiante::all();
        $asignaturas=Asignatura::all();
        $usuarios=Usuario::all();
        return view('notas.edit',compact('notas','estudiantes','asignaturas','usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notas $notas)
    {
        $request ->validate([
                'id_estudiantes'=>'required|exists:estudiantes,id',
                'id_asignaturas'=>'required|exists:asignaturas,id',
                'id_usuarios'=>'required|exists:usuarios,id',
                'nota' => 'required|numeric|decimal:2|min:0|max:100',
        ]);
        $notas->update([
            'id_estudiantes' =>$request->id_estudiantes,
            'id_asignaturas' =>$request->id_asignaturas,
            'id_usuarios'=>$request->id_usuarios
    

        ]);
        return redirect()->route('notas.index')->with('success','Notas actualizadas correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notas $notas)
    {
        $notas->delete();
        return redirect()->route('notas.index')->with('success','Notas eliminadas correctamente');
        
    }
}
