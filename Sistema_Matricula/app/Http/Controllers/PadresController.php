<?php

namespace App\Http\Controllers;

use App\Models\Padres;
use Illuminate\Http\Request;

class PadresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $padres=Padres::all();
        return view('padres.index',compact('padres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('padres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'Nombre_o_Tutor'=>'required|string|max:255',
            'Apellido'=>'required|string|max:255',
            'Email'=>'required|string|max:255',
            'Cedula'=>'required|string|max:255',
            'Telefono'=>'required|string|max:25'

        ]);
        Padres::create($request->all());

        //  decidimos si volver o no a estudaintes
   if ($request->input('origen') == 'estudiante') {
        return redirect()->route('estudiantes.create')
       ->with('success', 'Padre creado');
    }
        return redirect()->route('padres.index')->with('success','padres creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(padres $padre)
    {
        return view('padres.show',compact('padre'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(padres $padre)
    {
        return view('padres.edit',compact('padre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, padres $padre)
    {
         $request->validate([
            'Nombre_o_Tutor'=>'required|string|max:255',
            'Apellido'=>'required|string|max:255',
            'Email'=>'required|string|max:255',
            'Cedula'=>'required|string|max:255',
            'Telefono'=>'required|string|max:25'

        ]);
         $padre->update($request->all());
          return redirect()->route('padres.index')->with('success','Padre actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(padres $padre)
    {
        $padre->delete();
          return redirect()->route('padres.index')->with('success','Padre eliminado');
    }
}
