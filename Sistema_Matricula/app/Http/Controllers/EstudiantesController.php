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

        Estudiantes::create($request::all());
        
          return redirect()->route('estudiantes.index')->with('success', 'Estudiante creado correctamente');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Estudiantes $estudiantes)
    {
        return $request('estudiantes.show',compact('estudiantes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estudiantes $estudiantes)
    {
        return $request('estudiantes.edit',compact('estudiantes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estudiantes $estudiantes)
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

        $estudiantes->update($request->all());

        return redirect()->route('estudiantes.index')->with('access','estudiante actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estudiantes $estudiantes)
    {
        $estudiantes->delete();

        return redirect()->route('estudiantes.index')->with('access','estudiante eliminado correctamente');
    }
}
