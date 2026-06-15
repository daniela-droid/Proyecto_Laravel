<?php

namespace App\Http\Controllers;

use App\Models\Horarios;
use App\Models\Grupos;
use App\Models\Asignatura;
use App\Models\Docentes;
use App\Models\Aulas;
use App\Models\Grados;
use Illuminate\Http\Request;
use  Illuminate\views;

class HorariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $horarios=Horarios::with(['grupo.grados','asignatura','docente','aula'])->get();
        return view('horarios.index',compact('horarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grupo=Grupos::with(['grados', 'turnos'])->get();
        $asignatura=Asignatura::all();
        $docente=Docentes::all();
        $aula=Aulas::all();
        return view('horarios.create',compact('grupo','asignatura','docente','aula'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_grupo'=>'required|exists:grupos,id',
            'id_asignatura'=>'required|exists:asignaturas,id',
            'id_docente'=>'required|exists:docentes,id',
            'id_aula'=>'required|exists:aulas,id',
            'Dia_semana'=>'required|in:Lunes,Martes,Miercoles,Jueves,Viernes,Sabado',
            'Hora_inicio'=>'required',
            'Hora_fin'=>'required'


        ]);
        Horarios::create($request->all());
        return redirect()->route('horarios.index')->with('success','Creado Correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(horarios $horario)
    {
        return view('horarios.show',compact('horario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(horarios $horario)
    {

        $grupo=Grupos::with(['grados', 'turnos'])->get();
        $asignatura=Asignatura::all();
        $docente=Docentes::all();
        $aula=Aulas::all();
        return view('horarios.edit',compact('horario','grupo','asignatura','docente','aula'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, horarios $horario)
    {
        $request->validate([
            'id_grupo'=>'required|exists:grupos,id',
            'id_asignatura'=>'required|exists:asignaturas,id',
            'id_docente'=>'required|exists:docentes,id',
            'id_aula'=>'required|exists:aulas,id',
            'Dia_semana'=>'required|in:Lunes,Martes,Miercoles,Jueves,Viernes,Sabado',
            'Hora_inicio'=>'required',
            'Hora_fin'=>'required'


        ]);
          $horario->update($request->all());
          return redirect()->route('horarios.index')->with('success','Actualizado Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(horarios $horario)
    {
          $horario->delete();
          return redirect()->route('horarios.index')->with('success','Eliminado Correctamente');
    }

//METODO DEL HORARIO QUE TOMA LOS VALORES NECESARIOS PARA QUE EL DOCENTE PUEDA VER SU PROPIO HORARIO
    public function miHorario()
    {
            // Obtenemos al usuario autenticado de TU tabla 'usuarios'
            $user = auth()->user();

            // Intentamos obtener el registro del docente vinculado
        
            $docente = \App\Models\Docentes::where('id_usuario', $user->id)->first();

            if (!$docente) {
                // Esto te avisará si el usuario existe pero no está en la tabla docentes
                return "Error: El usuario con email {$user->Email} no tiene un perfil docente creado.";
            }

            // Buscamos los horarios usando el id del docente encontrado
            $horarios = \App\Models\Horarios::with(['grupo', 'asignatura', 'aula'])
                    ->where('id_docente', $docente->id) 
                    ->get();

        return view('docentes.mi_horario', compact('horarios'));
    }
//VISTA PARA QUE EL DOCENTE SEPA EL GRUPO O SECCION AL QUE IMPARTIRA 
     public function misEstudiantes()
    {
            // Obtenemos al usuario autenticado de TU tabla 'usuarios'
            $user = auth()->user();

            // Intentamos obtener el registro del docente vinculado
        
            $docente = \App\Models\Docentes::where('id_usuario', $user->id)->first();

            if (!$docente) {
                // Esto te avisará si el usuario existe pero no está en la tabla docentes
                return "Error: El usuario con email {$user->Email} no tiene un perfil docente creado.";
            }

            $horarios = \App\Models\Horarios::with(['grupo.grados', 'notas','asignatura'])
            ->where('id_docente', $docente->id) 
            ->get()
            ->unique(function ($item) {
                // Esto crea una llave única combinando grupo y asignatura
                return $item->id_grupo . $item->id_asignatura;
            });

         return view('docentes.mis_estudiantes', compact('horarios'));
    }

    //API DE LOS ESTUDAINTES QUE RETORNAN EN LAS NOTAS
    public function getEstudiantesPorHorario($id, Request $request)
    {
        $corteActual = $request->query('corte'); // Recibimos el corte desde el JS

        $horario = \App\Models\Horarios::with([
            'grupo.matriculas.estudiantes',
            'grupo.matriculas.notas' // Traemos todas las notas de esas matrículas
        ])->findOrFail($id);

        $data = $horario->grupo->matriculas->map(function($matricula) use ($corteActual, $id) {
            $est = $matricula->estudiantes;
            
            // 1. Buscamos si ya existe nota para EL CORTE SELECCIONADO
            $notaDelCorte = $matricula->notas
                ->where('id_horario', $id)
                ->where('id_corte_evaluativo', $corteActual)
                ->first();

            // 2. Traemos el historial (Notas de otros cortes en esta misma materia)
            $historial = $matricula->notas
                ->where('id_horario', $id)
                ->where('id_corte_evaluativo', '!=', $corteActual)
                ->map(function($n) {
                    return [
                        'corte' => $n->cortes->nombre ?? 'N/A',
                        'valor' => $n->nota_normal
                    ];
                });

            return [
                'id_matricula'   => $matricula->id,
                'Nombre'         => $est->Nombre . ' ' . $est->Apellido,
                'Codigo_Persona' => $est->Código_Persona,
                'Sexo'           => $est->Sexo,
                'Celular'        => $est->Celular,
                // Datos de control
                'nota_actual'    => $notaDelCorte ? $notaDelCorte->nota_normal : null,
                'nota_especial'  => $notaDelCorte ? $notaDelCorte->nota_especial : null,
                'observacion'    => $notaDelCorte ? $notaDelCorte->observacion : null,
                'historial'      => $historial
            ];
        });

        return response()->json($data);
    }

     public function __construct()
    {
        $this->middleware('auth');
        
        // Si el alias es 'role', úsalo así:
       
        // $this->middleware('role:admin')->except('miHorario');
        $this->middleware('role:docentes')->only('miHorario');
       // $this->middleware('role:admin')->except('miEstudiantes');
        $this->middleware('role:docentes')->only('miEstudiantes');
        

    }

    // public function __construct()
    // {
    //     $this->middleware('auth');
        
    //     // Si el alias es 'role', úsalo así:
    //     $this->middleware('role:admin')->except('miHorario');
    //     $this->middleware('role:docentes')->only('miHorario');
    //      $this->middleware('role:admin')->except('miEstudiantes');
    //     $this->middleware('role:docentes')->only('miEstudiantes');

    // }
}
