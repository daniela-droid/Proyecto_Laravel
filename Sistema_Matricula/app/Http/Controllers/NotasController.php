<?php

namespace App\Http\Controllers;

use App\Models\Notas;
use Illuminate\Http\Request;
use App\Models\Matriculas;
use App\Models\Estudiante;
use App\Models\Horarios;
use App\Models\Grupos;
use App\Models\cortes_evaluativos;
use App\Models\Usuario;

class NotasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notas = Notas::with([
            'matriculas.estudiantes',
            'horarios.asignatura',
            'horarios.grupo.grados',
            'cortes',
        ])->get();

        $notasPorGrado = $notas
            ->groupBy(function ($nota) {
                return $nota->horarios?->grupo?->grados?->Nombre ?? 'Sin grado';
            })
            ->map(function ($notasPorGrado) {
                return $notasPorGrado
                    ->groupBy('id_matricula')
                    ->map(function ($notasAlumno) {
                        return $notasAlumno->sortByDesc('created_at');
                    })
                    ->sortBy(function ($notasAlumno) {
                        return $notasAlumno->first()->matriculas?->estudiantes?->Nombre ?? '';
                    });
            })
            ->sortKeys(); // Ordenar grados alfabéticamente

        return view('notas.index', compact('notasPorGrado'));
    }

    /**
     * Show the form for creating a new resource.
     */
     
    public function create()
    {
        // Filtramos para que SOLO traiga horarios que tengan grupo Y que ese grupo tenga grado
        $horarios = Horarios::whereHas('grupo.grados') 
            ->with(['grupo.grados', 'asignatura'])
            ->get();

        $cortes = \App\Models\cortes_evaluativos::all(); // O como se llame tu modelo de cortes

        return view('notas.create', compact('horarios', 'cortes'));
    }

    public function createDocente()
    {
        return view('docentes.notas_create');
    }
    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    // 1. Validamos que lleguen los datos del encabezado y los arreglos de los estudiantes
    $request->validate([
        'id_horario' => 'required',
        'id_corte_evaluativo' => 'required',
        'id_matricula' => 'required|array', // Validamos que sea una lista
        'nota_normal' => 'required|array',   // Validamos que sea una lista
    ]);

    try {
        // 2. Extraemos los datos comunes (encabezado)
        $id_horario = $request->id_horario;
        $id_corte = $request->id_corte_evaluativo;
        $id_usuario = auth()->id();

        // 3. Recorremos el arreglo de matrículas usando su índice ($index)
        // Esto nos permite emparejar cada matrícula con su nota correspondiente
        foreach ($request->id_matricula as $index => $id_matricula) {
            
            // Obtenemos la nota normal de este estudiante específico usando el mismo índice
            $nota_actual = $request->nota_normal[$index];

            // OPCIONAL: Solo guardamos si el profesor escribió una nota. 
            // Si el campo está vacío, saltamos al siguiente estudiante.
            if ($nota_actual !== null && $nota_actual !== '') {
                
                \App\Models\Notas::updateOrCreate(
                    [
                        // Condiciones para buscar si ya existe la nota
                        'id_matricula' => $id_matricula,
                        'id_horario' => $id_horario,
                        'id_corte_evaluativo' => $id_corte,
                    ],
                    [
                        // Datos que se van a insertar o actualizar
                        'nota_normal' => $nota_actual,
                        // Usamos el índice para sacar la nota especial y observación de este alumno
                        'nota_especial' => $request->nota_special[$index] ?? null, 
                        'observacion' => $request->observacion[$index] ?? null,
                        'id_usuario' => $id_usuario,
                    ]
                );
            }
        }

        // 4. Respuesta de éxito
        return redirect()->route('notas.index')
            ->with('success', 'Se han registrado las calificaciones de todo el grupo correctamente.');

    } catch (\Exception $e) {
        // En caso de error, volvemos atrás con el mensaje
        return back()->with('error', 'Hubo un problema al guardar: ' . $e->getMessage());
    }
}
//metodo para ver historial de notas
public function historialMatricula($idMatricula)
    {
        $notas = Notas::with([
            'matriculas.estudiantes', 
            'horarios.asignatura', 
            'cortes'
        ])
        ->where('id_matricula', $idMatricula)
        ->orderBy('created_at', 'desc')
        ->get();

        // Transformar datos para frontend
        $notasTransformadas = $notas->map(function ($nota) {
            return [
                'id' => $nota->id,
                'nota_normal' => $nota->nota_normal,
                'nota_especial' => $nota->nota_especial ?? null,
                'observacion' => $nota->observacion ?? null,
                'created_at' => $nota->created_at?->format('d/m/Y H:i') ?? null,
                'horarios' => [
                    'asignatura' => [
                        'Nombre' => $nota->horarios?->asignatura?->Nombre ?? 'Sin asignatura',
                    ],
                ],
                'cortes' => [
                    'nombre' => $nota->cortes?->nombre ?? 'Sin corte',
                ],
            ];
        });

        return response()->json([
            'success' => true,
            'notas' => $notasTransformadas,
            'count' => $notas->count(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notas $nota)
    {
        return view('notas.show',compact('nota'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notas $nota)
    {
         $matriculas=Matriculas::all();
        $horarios=Horarios::all();
        $cortes=cortes_evaluativos::all();
        $usuarios=Usuario::all();
        return view('notas.edit',compact('nota','matriculas','horarios','cortes','usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notas $nota)
    {
        $request ->validate([
                'id_matricula'=>'required|exists:matriculas,id',
                'id_horario'=>'required|exists:horarios,id',
                'id_corte_evaluativo'=>'required|exists:cortes_evaluativos,id',
                'nota_normal'=>'required|numeric',
                'nota_especial'=>'required|numeric',
                'observacion'=>'required|string|max:255'
        ]);

     
        $nota->update($request->all());
        return redirect()->route('notas.index')->with('success','Notas actualizadas correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notas $nota)
    {
        $nota->delete();
        return redirect()->route('notas.index')->with('success','Notas eliminadas correctamente');
        
    }
}
