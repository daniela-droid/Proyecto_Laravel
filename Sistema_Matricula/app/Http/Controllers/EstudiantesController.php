<?php

namespace App\Http\Controllers;

use App\Models\Estudiantes;
use Illuminate\Http\Request;

class EstudiantesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {//lista todos los estudiantes
       $estudiantes= Estudiantes::all();
       // dd($estudiantes->toArray());
           return view('estudiantes.index', compact('estudiantes'));
         
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('estudiantes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request ->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'sexo' => 'required|string|max:12',
        'cedula' => 'required|string|max:255',
        'edad' => 'required|integer',
        'celular' => 'required|integer',
        'nombre_madre' => 'required|string|max:150',
        'nombre_padre' => 'required|string|max:150',
        'comarca' => 'required|string|max:150'
        ]);

        Estudiantes::create($request->all());
        
          return redirect()->route('estudiantes.index')->with('success', 'Estudiante creado correctamente');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Estudiantes $estudiante)
    {
        //para depurar
        // dd($estudiante);
        return view('estudiantes.show',compact('estudiante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estudiantes $estudiante)
    {
        return view('estudiantes.edit',compact('estudiante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estudiantes $estudiante)
    {
        $request ->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'sexo' => 'required|string|max:12',
        'cedula' => 'required|string|max:255',
        'edad' => 'required|integer',
        'celular' => 'required|integer',
        'nombre_madre' => 'required|string|max:150',
        'nombre_padre' => 'required|string|max:150',
        'comarca' => 'required|string|max:150'
        ]);

        $estudiante->update($request->all());

        return redirect()->route('estudiantes.index')->with('access','estudiante actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estudiantes $estudiante)
    {
        $estudiante->delete();

        return redirect()->route('estudiantes.index')->with('access','estudiante eliminado correctamente');
    }
}
