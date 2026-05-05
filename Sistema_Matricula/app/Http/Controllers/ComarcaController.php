<?php

namespace App\Http\Controllers;

use App\Models\Comarca;
use Illuminate\Http\Request;

class ComarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comarcas=Comarca::all();
        // dd($comarcas->toArray());
        return view('comarcas.index',compact('comarcas'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('comarcas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $request->validate([
           'Comarca'=>'required|string|max:255',
            'Direccion'=>'required|string|max:255'

        ]);
        Comarca::create($request->all());
        return redirect()->route('comarcas.index')->with('success','Comarca creada');
    }
    
        public function storeRapido(Request $request)
    {
        $request->validate([
           'Comarca'=>'required|string|max:255',
            'Direccion'=>'required|string|max:255'
        ]);

        $comarca = Comarca::create($request->all());

        return response()->json([
            'success' => true,
            'id' => $comarca->id,
            'nombre' => $comarca->Comarca
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(comarca $comarca)
    {
      return view('comarcas.show',compact('comarca'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(comarca $comarca)
    {
          return view('comarcas.edit',compact('comarca'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, comarca $comarca)
    {
        //
        $request->validate([
           'Comarca'=>'required|string|max:255',
            'Direccion'=>'required|string|max:255'

        ]);
    $comarca->update($request->all());
          return redirect()->route('comarcas.index')->with('success','Comarca actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(comarca $comarca)
    {
        $comarca->delete();
          return redirect()->route('comarcas.index')->with('success','Comarca eliminada');
    }
}
