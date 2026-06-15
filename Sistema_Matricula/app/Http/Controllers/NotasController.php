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
use App\Models\Centros_educativos;

class NotasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centroEducativo = Centros_educativos::principal();
        $nombreCentro = $centroEducativo?->nombre;
        $ordenGrados = function ($grado) {
            $nombre = mb_strtolower((string) $grado, 'UTF-8');
            $orden = [
                'primero' => 1,
                'primer' => 1,
                'segundo' => 2,
                'tercero' => 3,
                'tercer' => 3,
                'cuarto' => 4,
                'quinto' => 5,
                'sexto' => 6,
            ];

            foreach ($orden as $texto => $numero) {
                if (str_contains($nombre, $texto)) {
                    return $numero;
                }
            }

            return 99;
        };

        $notas = Notas::with([
            'matriculas.estudiantes',
            'horarios.asignatura',
            'horarios.docente',
            'horarios.grupo.turnos',
            'horarios.grupo.grados',
            'cortes.modalidades',
        ])->get();

        $matriculas = Matriculas::with([
            'estudiantes',
            'grupos.grados',
            'grupos.turnos',
            'notas.horarios.asignatura',
            'notas.horarios.docente',
            'notas.horarios.grupo.grados',
            'notas.cortes',
        ])->get();

        $notasPorGrado = $matriculas
            ->groupBy(function ($matricula) {
                return $matricula->grupos?->grados?->Nombre ?? 'Sin grado';
            })
            ->map(function ($matriculasPorGrado) {
                return $matriculasPorGrado
                    ->mapWithKeys(function ($matricula) {
                        return [
                            $matricula->id => [
                                'matricula' => $matricula,
                                'notas' => $matricula->notas->sortByDesc('created_at')->values(),
                            ],
                        ];
                    })
                    ->sortBy(function ($datosAlumno) {
                        return $datosAlumno['matricula']->estudiantes?->Nombre ?? '';
                    });
            })
            ->sortBy(function ($matriculasGrado, $grado) use ($ordenGrados) {
                return $ordenGrados($grado);
            });

        $reportesPorGrado = $notas
            ->groupBy(function ($nota) {
                return $nota->horarios?->grupo?->grados?->Nombre ?? 'Sin grado';
            })
            ->map(function ($notasGrado, $grado) use ($nombreCentro) {
                $cortes = $notasGrado
                    ->map(function ($nota) {
                        return $nota->cortes?->nombre ?? 'Sin corte';
                    })
                    ->unique()
                    ->values();
                $turnos = $notasGrado
                    ->map(function ($nota) {
                        return $nota->horarios?->grupo?->turnos?->Nombre;
                    })
                    ->filter()
                    ->unique()
                    ->values();
                $modalidades = $notasGrado
                    ->map(function ($nota) {
                        return $nota->cortes?->modalidades?->nombre
                            ?? $nota->horarios?->grupo?->grados?->tipo_nivel;
                    })
                    ->filter()
                    ->unique()
                    ->values();
                $docentes = $notasGrado
                    ->map(function ($nota) {
                        return trim(($nota->horarios?->docente?->Nombre ?? '') . ' ' . ($nota->horarios?->docente?->Apellido ?? '')) ?: null;
                    })
                    ->filter()
                    ->unique()
                    ->values();
                $asignaturas = $notasGrado
                    ->groupBy('id_horario')
                    ->map(function ($notasAsignatura, $idHorario) {
                        $primeraNota = $notasAsignatura->first();

                        return [
                            'key' => (string) $idHorario,
                            'nombre' => $primeraNota->horarios?->asignatura?->Nombre ?? 'Sin asignatura',
                        ];
                    })
                    ->sortBy('nombre')
                    ->values();

                return [
                    'grado' => $grado,
                    'centro' => $nombreCentro ?: 'Centro educativo no especificado',
                    'corte' => $cortes->isNotEmpty() ? $cortes->implode(', ') : 'Sin corte',
                    'turno' => $turnos->isNotEmpty() ? $turnos->implode(', ') : 'Sin turno',
                    'modalidad' => $modalidades->isNotEmpty() ? $modalidades->implode(', ') : 'Sin modalidad',
                    'docentes' => $docentes->isNotEmpty() ? $docentes->implode(', ') : 'Sin docente',
                    'asignaturas' => $asignaturas,
                    'filas' => $notasGrado
                        ->groupBy('id_matricula')
                        ->map(function ($notasFila) use ($asignaturas) {
                            $primeraNota = $notasFila->first();
                            $estudiante = $primeraNota->matriculas?->estudiantes;
                            $notasPorAsignatura = $notasFila->groupBy('id_horario');

                            return [
                                'codigo' => $estudiante?->{'Código_Persona'} ?? '',
                                'estudiante' => trim(($estudiante?->Nombre ?? '') . ' ' . ($estudiante?->Apellido ?? '')),
                                'grupo' => $primeraNota->horarios?->grupo?->Nombre ?? 'Sin grupo',
                                'asignaturas' => $asignaturas->mapWithKeys(function ($asignatura) use ($notasPorAsignatura) {
                                    $notasMateria = $notasPorAsignatura->get((int) $asignatura['key'], collect())
                                        ->sortBy(function ($nota) {
                                            return $nota->cortes?->nombre ?? '';
                                        })
                                        ->values();

                                    return [
                                        $asignatura['key'] => $notasMateria->map(function ($nota) {
                                            return [
                                                'corte' => $nota->cortes?->nombre ?? 'Sin corte',
                                                'nota_normal' => $nota->nota_normal,
                                                'nota_especial' => $nota->nota_especial,
                                                'promedio' => $nota->promedio,
                                                'observacion' => $nota->observacion,
                                            ];
                                        }),
                                    ];
                                }),
                            ];
                        })
                        ->sortBy(function ($fila) {
                            return $fila['estudiante'];
                        })
                        ->values(),
                ];
            })
            ->sortBy(function ($reporte, $grado) use ($ordenGrados) {
                return $ordenGrados($grado);
            });

        return view('notas.index', compact('notasPorGrado', 'reportesPorGrado', 'nombreCentro'));
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
        $matricula = Matriculas::with(['estudiantes', 'grupos.grados'])->find($idMatricula);
        $estudiante = $matricula?->estudiantes;
        $grupo = $matricula?->grupos;
        $grado = $grupo?->grados;

        $notas = Notas::with([
            'matriculas.estudiantes',
            'horarios.asignatura',
            'horarios.docente',
            'cortes'
        ])
        ->where('id_matricula', $idMatricula)
        ->get()
        ->sortBy(function ($nota) {
            $asignatura = $nota->horarios?->asignatura?->Nombre ?? '';
            $corte = $nota->cortes?->nombre ?? '';
            return trim($asignatura . '|' . $corte);
        })
        ->values();

        $notasTransformadas = $notas->map(function ($nota) {
            return [
                'id' => $nota->id,
                'id_horario' => $nota->id_horario,
                'nota_normal' => $nota->nota_normal,
                'nota_especial' => $nota->nota_especial ?? null,
                'promedio' => $nota->promedio ?? null,
                'observacion' => $nota->observacion ?? null,
                'created_at' => $nota->created_at?->format('d/m/Y H:i') ?? null,
                'horarios' => [
                    'asignatura' => [
                        'Nombre' => $nota->horarios?->asignatura?->Nombre ?? 'Sin asignatura',
                    ],
                    'docente' => [
                        'Nombre' => trim(($nota->horarios?->docente?->Nombre ?? '') . ' ' . ($nota->horarios?->docente?->Apellido ?? '')) ?: 'Sin docente',
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
            'estudiante' => [
                'nombre' => trim(($estudiante?->Nombre ?? '') . ' ' . ($estudiante?->Apellido ?? '')) ?: 'Estudiante desconocido',
                'codigo' => $estudiante?->Código_Persona ?? '',
                'grado' => $grado?->Nombre ?? '',
                'grupo' => $grupo?->Nombre ?? '',
            ],
        ]);
    }

    public function calcularPromedioMatricula($idMatricula)
    {
        $notas = Notas::where('id_matricula', $idMatricula)
            ->whereNotNull('id_horario')
            ->orderBy('id_horario')
            ->orderBy('id_corte_evaluativo')
            ->get();

        $promediosAsignaturas = $notas
            ->groupBy('id_horario')
            ->map(function ($notasAsignatura) {
                $calificaciones = $notasAsignatura
                    ->map(function ($nota) {
                        return $nota->nota_especial !== null ? $nota->nota_especial : $nota->nota_normal;
                    })
                    ->filter(function ($nota) {
                        return $nota !== null && $nota !== '' && is_numeric($nota);
                    })
                    ->values();

                if ($calificaciones->isEmpty()) {
                    return null;
                }

                return $calificaciones->sum() / $calificaciones->count();
            })
            ->filter(function ($promedioAsignatura) {
                return $promedioAsignatura !== null;
            })
            ->values();

        if ($promediosAsignaturas->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Este estudiante no tiene calificaciones suficientes para sacar el promedio.',
            ], 422);
        }

        $promedio = round($promediosAsignaturas->sum() / $promediosAsignaturas->count(), 2);

        Notas::whereIn('id', $notas->pluck('id'))->update([
            'promedio' => $promedio,
        ]);

        return response()->json([
            'success' => true,
            'promedio' => $promedio,
            'excelencia' => $promedio > 85,
            'message' => $promedio > 85 ? 'Excelencia' : 'Promedio calculado',
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
