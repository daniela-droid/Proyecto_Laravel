<?php

namespace App\Http\Controllers;

use App\Models\Aulas;
use Illuminate\Http\Request;

class AulasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aulas=Aulas::all();
        return view('aulas.index',compact('aulas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('aulas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $request->validate([
        'Nombre' => 'required|string|max:255',
        'Capacidad' => 'required|string|max:60'

        ]);

        Aulas::create($request->all());
        return redirect()->route('aulas.index')->with('success','Aula creada');
    }

    public function storeRapido(Request $request)
    {
        $request->validate([
           'Nombre'=>'required|string|max:255',
            'Capacidad'=>'required|string|max:60',
         
        ]);

        $aula = Aulas::create($request->all());

        return response()->json([
            'success' => true,
            'id' => $aula->id,
            'nombre' => $aula->Nombre
        ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(aulas $aula)
    {
        return view('aulas.show',compact('aula'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(aulas $aula)
    {
          return view('aulas.edit',compact('aula'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, aulas $aula)
    {
      $request->validate([
        'Nombre' => 'required|string|max:255',
        'Capacidad' => 'required|string|max:60'

        ]);

        $aula->update($request->all());
        return redirect()->route('aulas.index')->with('success','Aula actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(aulas $aula)
    {
        $aula->delete();
         return redirect()->route('aulas.index')->with('success','Aula eliminada');
    }
}
