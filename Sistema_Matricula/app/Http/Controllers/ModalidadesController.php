<?php

namespace App\Http\Controllers;

use App\Models\modalidades;
use Illuminate\Http\Request;

class ModalidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modalidades=modalidades::all();
        return view('modalidades.index',compact('modalidades'));
    }

    /*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modalidades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
              'nombre'=>'required|string|max:255',
              'codigo'=>'required|string|max:255',
              'descripcion'=>'required|string|max:255'
        ]);
        modalidades::create($request->all());
        return redirect()->route('modalidades.index')->with('success','Modalida Creada Correctamente');
    }
     public function storeRapido(Request $request)
    {
        $request->validate([
           'nombre'=>'required|string|max:255',
            'codigo'=>'required|string|max:255',
            'descripcion'=>'required|string|max:255',
           
        ]);

        $modalidad = modalidades::create($request->all());

        return response()->json([
            'success' => true,
            'id' => $modalidad->id,
            'nombre' => $modalidad->nombre
        ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(modalidades $modalidade)
    {
        return view('modalidades.show',compact('modalidade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(modalidades $modalidade)
    {
          return view('modalidades.edit',compact('modalidade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, modalidades $modalidade)
    {
        $request->validate([
              'nombre'=>'required|string|max:255',
              'codigo'=>'required|string|max:255',
              'descripcion'=>'required|string|max:255'
        ]);

        $modalidade->update($request->all());

        return redirect()->route('modalidades.index')->with('success','Modalida Creada Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(modalidades $modalidade)
    {
        $modalidade->delete();
          return redirect()->route('modalidades.index')->with('success','Modalida Creada Correctamente');
    }
}
