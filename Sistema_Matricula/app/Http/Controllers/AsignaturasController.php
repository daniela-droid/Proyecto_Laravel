<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use Illuminate\Http\Request;

class AsignaturasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asignaturas =Asignatura::all();
      //  dd(view()->exists('asignaturas.index'));
        return view('asignaturas.index',compact('asignaturas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('asignaturas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'Nombre'=>'required|string|max:255',
            'Descripcion'=>'required|string|max:255',
            'Código'=>'required|string|max:255'
          
        ]);
        
        Asignatura::create($request->all());
        return redirect()->route('asignaturas.index')->with('success','Asignatura creada correctamente');
    }

    public function storeRapido(Request $request)
    {
        $request->validate([
           'Nombre'=>'required|string|max:255',
            'Descripcion'=>'required|string|max:255',
            'Código'=>'required|string|max:255'
        ]);

        $asignatura = Asignatura::create($request->all());

        return response()->json([
            'success' => true,
            'id' => $asignatura->id,
            'nombre' => $asignatura->Nombre
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Asignatura $asignatura)
    {
        return view('asignaturas.show',compact('asignatura'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asignatura $asignatura)
    {
        return view('asignaturas.edit',compact('asignatura'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asignatura $asignatura)
    {
        $request->validate([
            'Nombre'=>'required|string|max:255',
            'Descripcion'=>'required|string|max:255',
            'Código'=>'required|string|max:255'

        ]);
        $asignatura->update($request->all());
        return redirect()->route('asignaturas.index')->with('access','asignaturas actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asignatura $asignatura)
    {
        $asignatura->delete();
        return redirect()->route('asignaturas.index')->with('access','asignatura eliminada');
    }
}
