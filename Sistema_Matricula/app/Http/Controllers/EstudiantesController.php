<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Comarca;
use App\Models\Padres;
use Illuminate\Http\Request;

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
    public function primaria(){
     $estudiantesPrimaria = Estudiante::whereHas('matriculas.grupos.grados', function ($query) {
        $query->where('tipo_nivel', 'Primaria');
    })->get();

    return view('estudiantes.primaria',compact('estudiantesPrimaria'));
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
      
        $request ->validate([
        'Código_Persona' => 'required|integer|unique:estudiantes,Código_Persona',
        'Nombre' => 'required|string|max:255',
        'Apellido' => 'required|string|max:255',
        'Sexo' => 'required|string|max:12',
        'Fecha_N' => 'required|date',
        'Celular' => 'required|integer',
        'id_padre'=>'required|exists:padres,id',
        'id_comarca'=>'required|exists:comarcas,id'
        ]);
                

        Estudiante::create($request->all());
        
        if ($request->from === 'matriculas') {
            return redirect()->route('matriculas.create')->with('success', 'Estudiante creado correctamente. Ahora puedes continuar con la matrícula.');
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
        $request ->validate([
        'Código_Persona' => 'required|integer',
        'Nombre' => 'required|string|max:255',
        'Apellido' => 'required|string|max:255',
        'Sexo' => 'required|string|max:12',
        'Fecha_N' => 'required|date',
        'Celular' => 'required|integer',
        'id_padre'=>'required|exists:padres,id',
        'id_comarca'=>'required|exists:comarcas,id'
        ]);

      $estudiante->update($request->all());

        return redirect()->route('estudiantes.index')->with('success','estudiante actualizado correctamente');
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
