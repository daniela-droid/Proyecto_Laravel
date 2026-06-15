<?php

namespace App\Http\Controllers;

use App\Models\Grados;
use Illuminate\Http\Request;

class GradosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grados=Grados::all();
        return view('grados.index',compact('grados'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('grados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
             'Nombre'=>'required|string|max:255',
             'Nivel'=>'required|int',
             'tipo_nivel'=>'required|in:Primaria,Secundaria'
                

        ]);

        Grados::create($request->all());
        return redirect()->route('grados.index')->with('success','Grado creado exitosamente');
    }

     public function storeRapido(Request $request)
    {
        $request->validate([
           'Nombre'=>'required|string|max:255',
            'Nivel'=>'required|int',
            'tipo_nivel'=>'required|in:Primaria,Secundaria'
        ]);

        $grado = Grados::create($request->all());

        return response()->json([
            'success' => true,
            'id' => $grado->id,
            'nombre' => $grado->Nombre
        ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(grados $grado)
    {
        return view('grados.show',compact('grado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(grados $grado)
    {
        return view('grados.edit',compact('grado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, grados $grado)
    {
         $request->validate([
             'Nombre'=>'required|string|max:255',
             'Nivel'=>'required|int',
            'tipo_nivel'=>'required|in:Primaria,Secundaria'

        ]);
        $grado->update($request->all());
         return redirect()->route('grados.index')->with('success',);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(grados $grado)
    {
        $grado->delete();
         return redirect()->route('grados.index')->with('success','grado eliminado');
    }
}
