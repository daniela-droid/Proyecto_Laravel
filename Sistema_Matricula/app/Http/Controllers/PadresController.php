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
    $validated = $request->validate($this->rulesPadre(), $this->messagesPadre());

    $validated['Cedula'] = strtoupper(trim($validated['Cedula']));
    $validated['Telefono'] = trim($validated['Telefono']);

    $padre = Padres::create($validated);
    
    return redirect()->route('padres.index')->with('success','Padre creado');

    
}

public function storeRapido(Request $request)
{
    $validated = $request->validate($this->rulesPadreRapido(), $this->messagesPadre());

    $validated['Cedula'] = isset($validated['Cedula']) ? strtoupper(trim($validated['Cedula'])) : null;
    $validated['Telefono'] = isset($validated['Telefono']) ? trim($validated['Telefono']) : null;

    $padre = Padres::create($validated);

    return response()->json([
        'success' => true,
        'id' => $padre->id,
        'nombre' => $padre->Nombre_o_Tutor . ' ' . $padre->Apellido
    ]);
}


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
         $validated = $request->validate($this->rulesPadre(), $this->messagesPadre());
         $validated['Cedula'] = strtoupper(trim($validated['Cedula']));
         $validated['Telefono'] = trim($validated['Telefono']);

         $padre->update($validated);
          return redirect()->route('padres.index')->with('success','Padre actualizado');
    }

    private function rulesPadre(): array
    {
        return [
            'Nombre_o_Tutor'=>'required|string|max:255',
            'Apellido'=>'required|string|max:255',
            'Email'=>'required|string|max:255|email',
            'Cedula'=>['required', 'string', 'regex:/^[0-9]{13}[A-Z]$/'],
            'Telefono'=>['required', 'string', 'regex:/^\+505[0-9]{8}$/'],
        ];
    }

    private function rulesPadreRapido(): array
    {
        return [
            'Nombre_o_Tutor' => 'required|string|max:255',
            'Apellido' => 'required|string|max:255',
            'Email' => 'nullable|email|max:255',
            'Cedula' => ['nullable', 'string', 'regex:/^[0-9]{13}[A-Z]$/'],
            'Telefono' => ['nullable', 'string', 'regex:/^\+505[0-9]{8}$/'],
        ];
    }

    private function messagesPadre(): array
    {
        return [
            'Cedula.regex' => 'La cédula debe tener 13 dígitos y una letra final en mayúscula. Ejemplo: 5662811021000F.',
            'Telefono.regex' => 'El teléfono debe tener el formato +50512345678.',
        ];
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
