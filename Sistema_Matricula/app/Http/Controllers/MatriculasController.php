<?php

namespace App\Http\Controllers;

use App\Models\Matriculas;
use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Grupos;
use App\Models\Periodo_academicos;
use App\Models\Usuario;
use Illuminate\Validation\Rule;
class MatriculasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        //obtener las matriculas con estudiante y asignatura
        $matriculas  = Matriculas::with(['estudiantes','grupos.Grados','periodos','usuarios'])->get();
        return view('matriculas.index',compact('matriculas'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // traer estudiantes y asignaturas para el select
        $estudiantes = Estudiante::all();
        $grupos = Grupos::all();
        $periodos = Periodo_academicos::all();
        $usuarios = Usuario::all();

        $selectedStudent = null;
        $selectedStudentId = request('selected_estudiante');
        if ($selectedStudentId) {
            $selectedStudent = Estudiante::find($selectedStudentId);
        }

        return view('matriculas.create', compact('estudiantes', 'grupos', 'periodos', 'usuarios', 'selectedStudent'));
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
        {
            $request->validate([
                'id_estudiante' => ['required','exists:estudiantes,id',
                    // Esta regla verifica que el id_estudiante no exista ya en la tabla matriculas
                    // PERO filtrando por el periodo académico seleccionado.
                    Rule::unique('matriculas')->where(function ($query) use ($request) {
                        return $query->where('id_estudiante', $request->id_estudiante)
                        ->where('id_periodo_academicos', $request->id_periodo_academicos);
                    }),
                ],
                'id_grupo' => 'required|exists:grupos,id',
                'id_periodo_academicos' => 'required|exists:periodo_academicos,id',
                'fecha_matricula' => 'required|date',
                'estado' => 'required|in:Activo,Retirado,Suspendido,Expulsado',
                'observaciones' => 'required|string|max:255'
            ], [
                // Mensaje personalizado para que el usuario entienda qué pasó
                'id_estudiante.unique' => 'Este estudiante ya se encuentra matriculado en el periodo académico seleccionado.'
            ]);

            // Agregamos al usuario manualmente
            $request->merge(['id_usuario' => auth()->id()]);

            // Crear la matrícula
            Matriculas::create($request->all());

            return redirect()->route('matriculas.index')->with('success', 'Matrícula creada correctamente');
        }


    /**
     * Display the specified resource.
     */
    public function show(Matriculas $matricula)
    {
       return view('matriculas.show',compact('matricula'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matriculas $matricula)
    {
         $estudiantes=Estudiante::all();
        $grupos=Grupos::all();
        $periodos=Periodo_academicos::all();
        $usuarios=Usuario::all();
        return view('matriculas.edit',compact('matricula','estudiantes','grupos','periodos','usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, Matriculas $matricula)
{   
          $request->validate([
                 'id_estudiante'=>'required|exists:estudiantes,id',
                'id_grupo'=>'required|exists:grupos,id',
                'id_periodo_academicos'=>'required|exists:periodo_academicos,id',
              //  'id_usuario'=>'required|exists:usuarios,id',
                'fecha_matricula'=>'required|date',//date
                'estado'=>'required|in:Activo,Retirado,Suspendido,Expulsado',  //enum
                'observaciones'=>'required|string|max:255'//string
            
        
    ]);

    $matricula->update($request->all());
     return redirect()->route('matriculas.index')->with('success', 'Matrícula actualizada correctamente');
}

        public function updateStatusOnly(Request $request, $id)
        {
            $request->validate([
                'estado' => ['required', \Illuminate\Validation\Rule::in(['Activo', 'Retirado', 'Suspendido', 'Expulsado'])], 
            ]);

            try {
                $matricula = \App\Models\Matriculas::findOrFail($id);
                $matricula->estado = $request->input('estado');
                $matricula->save(); 

                return response()->json([
                    'success' => true,
                    'message' => 'Estado actualizado con éxito.'
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error en el servidor: ' . $e->getMessage()
                ], 500);
            }
        }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matriculas $matricula)
    {
        $matricula->delete();
        return redirect()->route('matriculas.index')->with('success','Matricula eliminada correctamente');
    }
}
