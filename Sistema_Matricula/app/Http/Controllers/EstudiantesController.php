<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Comarca;
use App\Models\Grados;
use App\Models\Padres;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EstudiantesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {//lista todos los estudiantes
    // Esto carga el estudiante y todas sus matrículas de un solo golpe
     $total_estudiantes=Estudiante::count();
     
      // Necesitas estas variables AQUÍ para que las tarjetas del INDEX no den error
    $estudiantesPrimaria = Estudiante::whereHas('matriculas.grupos.grados', function ($query) {
        $query->where('tipo_nivel', 'Primaria');
    })->get();

    $estudiantesSecundaria = Estudiante::whereHas('matriculas.grupos.grados', function ($query) {
        $query->where('tipo_nivel', 'Secundaria');
    })->get();
       $estudiantes= Estudiante::with(['padre','comarca','matriculas'])->get();
       // dd($estudiantes->toArray());
           return view('estudiantes.index', compact(
        'estudiantes','total_estudiantes','estudiantesPrimaria','estudiantesSecundaria'));
         
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $padre=Padres::all();
        $comarca=Comarca::all();
        return view('estudiantes.create',compact('padre','comarca'));
    }

    //metodo de tablas de estudiante de primaria
    public function primaria(Request $request){
        $gradoSelected = $request->query('grado');

        $grados = Grados::where('tipo_nivel', 'Primaria')
            ->orderBy('Nombre')
            ->get();

        $estudiantesPrimaria = Estudiante::whereHas('matriculas.grupos.grados', function ($query) use ($gradoSelected) {
            $query->where('tipo_nivel', 'Primaria');
            if ($gradoSelected) {
                $query->where('id', $gradoSelected);
            }
        })->with(['matriculas.grupos.grados'])
          ->get();

        return view('estudiantes.primaria', compact('estudiantesPrimaria', 'grados', 'gradoSelected'));
    }
    //metodo de tablas de estudiante de secundaria 
    public function secundaria(){
    $estudiantesSecundaria = Estudiante::whereHas('matriculas.grupos.grados', function ($query) {
        $query->where('tipo_nivel', 'Secundaria');
    })->get();


     return view('estudiantes.secundaria',compact('estudiantesSecundaria'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'Código_Persona' => trim((string) $request->input('Código_Persona', '')),
            'c_temporal' => strtoupper(trim((string) $request->input('c_temporal', ''))),
        ]);
      
        $validated = $request->validate([
            'Código_Persona' => ['nullable','regex:/^[0-9]{7,8}$/','unique:estudiantes,Código_Persona'],
            'c_temporal' => ['nullable','regex:/^[0-9A-F]{16}$/'],
            'Nombre' => 'required|string|max:255',
            'Apellido' => 'required|string|max:255',
            'Sexo' => 'required|string|max:12',
            'Fecha_N' => 'required|date',
            'Celular' => ['required', 'string', 'regex:/^\+505[0-9]{8}$/'],
            'id_padre' => 'required|exists:padres,id',
            'id_comarca' => 'required|exists:comarcas,id'
        ]);

        $validated['Nombre'] = $this->formatName($validated['Nombre']);
        $validated['Apellido'] = $this->formatName($validated['Apellido']);
        $validated['Código_Persona'] = isset($validated['Código_Persona']) ? trim($validated['Código_Persona']) : '';
        $validated['c_temporal'] = isset($validated['c_temporal']) ? strtoupper(trim($validated['c_temporal'])) : '';

        $estudiante = Estudiante::create($validated);
        
        if ($request->from === 'matriculas') {
            $redirectChoice = $request->input('redirect_choice', 'matriculas');

            if ($redirectChoice === 'matriculas') {
                return redirect()->route('matriculas.create', ['selected_estudiante' => $estudiante->id])
                    ->with('success', 'Estudiante creado correctamente. Ahora puedes continuar con la matrícula.');
            }

            return redirect()->route('estudiantes.index')->with('success', 'Estudiante creado correctamente');
        }
        
        return redirect()->route('estudiantes.index')->with('success', 'Estudiante creado correctamente');
              
    }

    /**
     * Display the specified resource.
     */
    public function show(Estudiante $estudiante)
    {
        //para depurar
         //dd($datosvalidados);
         // Buscamos al estudiante por id y cargamos sus 3 relaciones
       $estudiante->load(['padre', 'comarca', 'matriculas']);
        return view('estudiantes.show',compact('estudiante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estudiante $estudiante)
    {
        $padre=Padres::all();
        $comarca=Comarca::all();
        return view('estudiantes.edit',compact('estudiante','padre','comarca'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estudiante $estudiante)
    {
        $request->merge([
            'Código_Persona' => trim((string) $request->input('Código_Persona', '')),
            'c_temporal' => strtoupper(trim((string) $request->input('c_temporal', ''))),
        ]);

        $validated = $request->validate([
            'Código_Persona' => [
                'nullable',
                'regex:/^[0-9]{7,8}$/',
                Rule::unique('estudiantes', 'Código_Persona')->ignore($estudiante->id),
            ],
            'c_temporal' => ['nullable','regex:/^[0-9A-F]{16}$/'],
            'Nombre' => 'required|string|max:255',
            'Apellido' => 'required|string|max:255',
            'Sexo' => 'required|string|max:12',
            'Fecha_N' => 'required|date',
            'Celular' => ['required', 'string', 'regex:/^\+505[0-9]{8}$/'],
            'id_padre' => 'required|exists:padres,id',
            'id_comarca' => 'required|exists:comarcas,id'
        ]);

        $validated['Nombre'] = $this->formatName($validated['Nombre']);
        $validated['Apellido'] = $this->formatName($validated['Apellido']);
        $validated['Código_Persona'] = isset($validated['Código_Persona']) ? trim($validated['Código_Persona']) : '';
        $validated['c_temporal'] = isset($validated['c_temporal']) ? strtoupper(trim($validated['c_temporal'])) : '';

        $estudiante->update($validated);

        return redirect()->route('estudiantes.index')->with('success','estudiante actualizado correctamente');
    }

    private function formatName(string $value): string
    {
        return collect(explode(' ', trim($value)))
            ->filter()
            ->map(fn($word) => ucfirst(strtolower($word)))
            ->join(' ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estudiante $estudiante)
    {
        $estudiante->delete();

        return redirect()->route('estudiantes.index')->with('success','estudiante eliminado correctamente');
    }
}
