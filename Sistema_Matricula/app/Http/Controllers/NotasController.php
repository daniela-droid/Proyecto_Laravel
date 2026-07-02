<?php

namespace App\Http\Controllers;

use App\Models\Notas;
use Illuminate\Http\Request;
use App\Models\Matriculas;
use App\Models\Estudiante;
use App\Models\Horarios;
use App\Models\Grupos;
use App\Models\Centros_educativos;
use App\Models\cortes_evaluativos;
use App\Models\Usuario;

class NotasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las matrículas con estudiantes y sus grados y turnos
        $matriculas = Matriculas::with([
            'estudiantes',
            'grupos.grados',
            'grupos.turnos',
        ])->get();

        // Obtener todas las notas con sus relaciones
        $notas = Notas::with([
            'matriculas.estudiantes',
            'horarios.asignatura',
            'horarios.grupo.grados',
            'cortes.modalidades',
        ])->get();

        // Agrupar matrículas por grado (solo las que tengan grado válido)
        $notasPorGrado = $matriculas
            ->filter(function ($matricula) {
                return $matricula->grupos?->grados?->Nombre !== null;
            })
            ->groupBy(function ($matricula) {
                return $matricula->grupos?->grados?->Nombre;
            })
            ->map(function ($matriculasGrado) use ($notas) {
                // Para cada grado, construir la estructura de datos
                $estructuraGrado = $matriculasGrado->mapWithKeys(function ($matricula) use ($notas) {
                    $id_matricula = $matricula->id;
                    
                    // Buscar las notas válidas para esta matrícula
                    $notasAlumno = $notas->filter(function ($nota) use ($id_matricula) {
                        return $nota->id_matricula == $id_matricula
                            && $nota->horarios
                            && $nota->horarios->asignatura
                            && trim((string) ($nota->horarios->asignatura->Nombre ?? '')) !== '';
                    })->sortByDesc('created_at')->values();

                    return [$id_matricula => [
                        'matricula' => $matricula,
                        'notas' => $notasAlumno,
                    ]];
                });

                // Ordenar las matrículas por nombre del estudiante
                $estructuraGrado = $estructuraGrado->sortBy(function ($datosAlumno) {
                    return $datosAlumno['matricula']->estudiantes->Nombre ?? '';
                });

                return $estructuraGrado;
            })
            ->sortBy(function ($matriculasGrado) {
                $nivel = intval($matriculasGrado->first()->grupos?->grados?->Nivel ?? PHP_INT_MAX);
                $nombre = $matriculasGrado->first()->grupos?->grados?->Nombre ?? '';
                return sprintf('%05d-%s', $nivel, $nombre);
            });

        // Construir datos para reportes por grado
        $nombreCentro = Centros_educativos::principal()?->nombre ?? 'Centro educativo no especificado';

        $reportesPorGrado = $matriculas
            ->filter(function ($matricula) {
                return $matricula->grupos?->grados?->Nombre !== null;
            })
            ->groupBy(function ($matricula) {
                return $matricula->grupos?->grados?->Nombre;
            })
            ->sortBy(function ($matriculasGrado) {
                $nivel = intval($matriculasGrado->first()->grupos?->grados?->Nivel ?? PHP_INT_MAX);
                $nombre = $matriculasGrado->first()->grupos?->grados?->Nombre ?? '';
                return sprintf('%05d-%s', $nivel, $nombre);
            })
            ->mapWithKeys(function ($matriculasGrado, $grado) use ($notas, $nombreCentro) {
                $asignaturas = [];
                $docentes = [];

                // Primero, cargar todas las asignaturas del grupo desde horarios
                if ($matriculasGrado->count() > 0) {
                    $grupoId = $matriculasGrado->first()->id_grupo;
                    $horariosGrupo = Horarios::where('id_grupo', $grupoId)
                        ->with('asignatura', 'docente')
                        ->get();

                    foreach ($horariosGrupo as $horario) {
                        if (!$horario->asignatura || empty(trim((string) $horario->asignatura->Nombre))) {
                            continue;
                        }

                        $key = (string) $horario->id;
                        $nombreAsignatura = $horario->asignatura->Nombre;
                        $tipoAsignatura = $horario->asignatura->tipo ?? null;
                        $docenteNombre = trim((string) (($horario->docente?->Nombre ?? '') . ' ' . ($horario->docente?->Apellido ?? '')));

                        if (!isset($asignaturas[$key])) {
                            $asignaturas[$key] = [
                                'key' => $key,
                                'nombre' => $nombreAsignatura,
                                'tipo' => $tipoAsignatura,
                            ];
                        }

                        if ($docenteNombre !== '') {
                            $docentes[$docenteNombre] = true;
                        }
                    }
                }

                $filas = $matriculasGrado->map(function ($matricula) use ($notas, &$asignaturas, &$docentes) {
                    $idMatricula = $matricula->id;
                    $notasAlumno = $notas->where('id_matricula', $idMatricula);
                    $asignaturasPorFila = [];

                    // Inicializar todas las asignaturas del grupo con array vacío
                    foreach ($asignaturas as $key => $asig) {
                        $asignaturasPorFila[$key] = [];
                    }

                    // Luego llenar con notas que existan
                    foreach ($notasAlumno as $nota) {
                        if (!$nota->horarios || !$nota->horarios->asignatura || empty(trim((string) $nota->horarios->asignatura->Nombre))) {
                            continue;
                        }

                        $key = (string) $nota->id_horario;
                        $nombreAsignatura = $nota->horarios->asignatura->Nombre;
                        $tipoAsignatura = $nota->horarios->asignatura->tipo ?? null;

                        if (!isset($asignaturasPorFila[$key])) {
                            $asignaturasPorFila[$key] = [];
                        }

                        $asignaturasPorFila[$key][] = [
                            'id' => $nota->id,
                            'id_horario' => $nota->id_horario,
                            'nota_normal' => $nota->nota_normal,
                            'nota_especial' => $nota->nota_especial,
                            'promedio' => $nota->promedio,
                            'cortes' => ['nombre' => $nota->cortes?->nombre ?? ''],
                            'horarios' => [
                                'asignatura' => [
                                    'Nombre' => $nombreAsignatura,
                                    'tipo' => $tipoAsignatura,
                                ],
                                'docente' => ['Nombre' => $nota->horarios->docente?->Nombre ?? ''],
                            ],
                        ];
                    }

                    return [
                        'codigo' => $matricula->estudiantes?->Código_Persona ?? '',
                        'estudiante' => trim((string) (($matricula->estudiantes?->Nombre ?? '') . ' ' . ($matricula->estudiantes?->Apellido ?? ''))),
                        'asignaturas' => $asignaturasPorFila,
                    ];
                })->values();

                $asignaturas = collect($asignaturas)
                    ->values()
                    ->sortBy('nombre')
                    ->values();

                $modalidadNombre = $notas
                    ->whereIn('id_matricula', $matriculasGrado->pluck('id')->all())
                    ->map(fn($nota) => $nota->cortes?->modalidades?->nombre)
                    ->filter()
                    ->first() ?? '';

                return [$grado => [
                    'grado' => $grado,
                    'turno' => $matriculasGrado->first()->grupos?->turnos?->Nombre ?? '',
                    'modalidad' => $modalidadNombre,
                    'modalidades' => $modalidadNombre,
                    'corte' => '',
                    'centro' => $nombreCentro,
                    'docentes' => count($docentes) ? implode(', ', array_keys($docentes)) : 'Sin docente asignado',
                    'asignaturas' => $asignaturas,
                    'filas' => $filas,
                ]];
            });

        $cortes = cortes_evaluativos::orderBy('nombre')->get(['id', 'nombre']);

        return view('notas.index', compact('notasPorGrado', 'reportesPorGrado', 'nombreCentro', 'cortes'));
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
            'horarios.docentes',
            'cortes'
        ])
        ->where('id_matricula', $idMatricula)
        ->orderBy('created_at', 'desc')
        ->get();

        // Filtrar solo notas que tengan horario válido con asignatura real
        $notasValidas = $notas->filter(function ($nota) {
            // Verificar que exista el horario
            if (!$nota->horarios) {
                return false;
            }
            // Verificar que exista la asignatura y tenga nombre
            if (!$nota->horarios->asignatura || empty($nota->horarios->asignatura->Nombre)) {
                return false;
            }
            // Si pasa todas las validaciones, incluir
            return true;
        })->values();

        // Transformar datos para frontend
        $notasTransformadas = $notasValidas->map(function ($nota) {
            return [
                'id' => $nota->id,
                'nota_normal' => $nota->nota_normal,
                'nota_especial' => $nota->nota_especial ?? null,
                'observacion' => $nota->observacion ?? null,
                'created_at' => $nota->created_at?->format('d/m/Y H:i') ?? null,
                'id_horario' => $nota->horarios->id,
                'horarios' => [
                    'asignatura' => [
                        'Nombre' => $nota->horarios->asignatura->Nombre,
                        'tipo' => $nota->horarios->asignatura->tipo ?? null,
                    ],
                    'docente' => [
                        'Nombre' => $nota->horarios->docentes->Nombre ?? 'Sin docente',
                    ]
                ],
                'cortes' => [
                    'nombre' => $nota->cortes->nombre ?? 'Sin corte',
                ],
            ];
        })->values();

        return response()->json([
            'success' => true,
            'notas' => $notasTransformadas,
            'count' => $notasValidas->count(),
        ]);
    }

    public function calcularPromedioMatricula($idMatricula)
    {
        $notas = Notas::with(['horarios.asignatura', 'cortes'])
            ->where('id_matricula', $idMatricula)
            ->get();

        $cortes = [];

        foreach ($notas as $nota) {
            $asignaturaNombre = $nota->horarios?->asignatura?->Nombre;
            $valorNota = $nota->nota_especial !== null && $nota->nota_especial !== ''
                ? $nota->nota_especial
                : $nota->nota_normal;

            if (!$asignaturaNombre || $valorNota === null || $valorNota === '') {
                continue;
            }

            if (!is_numeric($valorNota)) {
                continue;
            }

            $tipo = trim(strtolower((string) ($nota->horarios->asignatura->tipo ?? '')));
            if ($tipo !== 'cuantitativa') {
                continue;
            }

            $corteNombre = $nota->cortes?->nombre ?? 'Sin corte';
            if (!isset($cortes[$corteNombre])) {
                $cortes[$corteNombre] = [];
            }

            $cortes[$corteNombre][] = (float) $valorNota;
        }

        $promediosCortes = collect($cortes)
            ->map(function ($valores, $corte) {
                return [
                    'corte' => $corte,
                    'promedio' => count($valores) ? array_sum($valores) / count($valores) : null,
                    'cantidad' => count($valores),
                ];
            })
            ->sortBy(function ($item) {
                return $item['corte'];
            })
            ->values()
            ->all();

        $valoresPromedio = array_filter(array_column($promediosCortes, 'promedio'), function ($valor) {
            return $valor !== null && $valor !== '' && is_numeric($valor);
        });

        $promedioGeneral = null;
        if (count($valoresPromedio)) {
            $promedioGeneral = array_sum($valoresPromedio) / count($valoresPromedio);
        }

        $mensaje = 'Promedio general calculado correctamente.';
        $excelencia = false;

        if ($promedioGeneral !== null) {
            $excelencia = $promedioGeneral > 85;
            $mensaje = $excelencia ? 'Excelencia' : 'Promedio general calculado correctamente.';
        } else {
            $mensaje = 'No se encontraron notas cuantitativas para calcular el promedio general.';
        }

        return response()->json([
            'success' => true,
            'promedio' => $promedioGeneral !== null ? round($promedioGeneral, 2) : null,
            'promedios_cortes' => $promediosCortes,
            'excelencia' => $excelencia,
            'message' => $mensaje,
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
