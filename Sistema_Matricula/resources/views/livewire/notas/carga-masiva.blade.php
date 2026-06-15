<?php

use Livewire\Component;
use App\Models\Matriculas;
use App\Models\Estudiante;
use App\Models\Horarios;
use App\Models\cortes_evaluativos;
use App\Models\Periodo_academicos;
use App\Models\Notas;
use App\Models\Grados;
use App\Models\Grupos;
use App\Models\SolicitudCorreccionNota;

new class extends Component
{
    public $id_periodo;
    public $id_grado;
    public $id_grupo;
    public $id_asignatura;
    public $id_horario;
    public $id_corte_evaluativo;
    public $modo = 'admin';
    public $docenteId;

    public $grupos = [];
    public $asignaturas = [];
    public $horarios = [];
    public $estudiantes_lista = [];
    public $search = '';

    public $id_matricula = [];
    public $nota_normal = [];
    public $nota_especial = [];
    public $observacion = [];
    public $notas_existentes = [];
    public $notas_ids = [];
    public $notas_editables = [];
    public $solicitudes_aprobadas = [];

    public $solicitud_index;
    public $solicitud_nota_id;
    public $motivo_solicitud = '';
    public $nota_sugerida;

    public function mount($modo = 'admin')
    {
        $this->modo = $modo;

        if ($this->esDocente) {
            $docente = auth()->user()?->docentes;

            if (!$docente) {
                abort(403, 'No tiene un perfil docente vinculado.');
            }

            $this->docenteId = $docente->id;
        }
    }

    public function getEsDocenteProperty()
    {
        return $this->modo === 'docente' || auth()->user()?->rol === 'docentes';
    }

    protected function horariosPermitidosQuery()
    {
        $query = Horarios::with(['asignatura', 'docente', 'grupo.grados']);

        if ($this->esDocente) {
            $query->where('id_docente', $this->docenteId);
        }

        return $query;
    }

    public function getCortesProperty()
    {
        return cortes_evaluativos::where('id_periodo_academicos', $this->id_periodo)->get();
    }

    public function updatedIdPeriodo($id)
    {
        $this->id_grado = $this->id_grupo = $this->id_asignatura = $this->id_horario = $this->id_corte_evaluativo = null;
        $this->grupos = collect();
        $this->asignaturas = collect();
        $this->horarios = collect();
        $this->estudiantes_lista = collect();
        $this->resetNoteArrays();
    }

    public function updatedIdGrado($id)
    {
        $this->id_grupo = $this->id_asignatura = $this->id_horario = null;
        $this->asignaturas = collect();
        $this->horarios = collect();
        $this->estudiantes_lista = collect();
        $this->resetNoteArrays();

        if ($id && $this->id_periodo) {
            $this->grupos = Grupos::where('id_grado', $id)
                ->where('id_periodo_academicos', $this->id_periodo)
                ->when($this->esDocente, function ($query) {
                    $query->whereHas('horarios', function ($horarioQuery) {
                        $horarioQuery->where('id_docente', $this->docenteId);
                    });
                })
                ->get();
        } else {
            $this->grupos = collect();
        }
    }

    public function updatedIdGrupo($id)
    {
        $this->id_asignatura = $this->id_horario = null;
        $this->horarios = collect();
        $this->asignaturas = collect();
        $this->estudiantes_lista = collect();
        $this->resetNoteArrays();

        if ($id) {
            $this->horarios = $this->horariosPermitidosQuery()
                ->where('id_grupo', $id)
                ->get();

            $this->asignaturas = $this->horarios
                ->pluck('asignatura')
                ->filter()
                ->unique('id')
                ->values();

            $grupo = Grupos::with(['matriculas.estudiantes'])->find($id);
            $this->estudiantes_lista = $grupo ? $grupo->matriculas : collect();
            $this->initializeNotasFromStudents();
        }
    }

    public function updatedIdAsignatura($id)
    {
        $this->id_horario = null;
        $this->resetNoteArrays();

        if ($id && $this->id_grupo) {
            $this->horarios = $this->horariosPermitidosQuery()
                ->where('id_grupo', $this->id_grupo)
                ->where('id_asignatura', $id)
                ->get();

            if ($this->horarios->count() === 1) {
                $this->id_horario = $this->horarios->first()->id;
            }

            $this->initializeNotasFromStudents();
        }
    }

    public function updatedIdHorario($id)
    {
        if ($id) {
            $this->initializeNotasFromStudents();
        }
    }

    public function updatedIdCorteEvaluativo($id)
    {
        if ($id) {
            $this->initializeNotasFromStudents();
        }
    }

    protected function initializeNotasFromStudents()
    {
        $this->id_matricula = [];
        $this->nota_normal = [];
        $this->nota_especial = [];
        $this->observacion = [];
        $this->notas_existentes = [];
        $this->notas_ids = [];
        $this->notas_editables = [];
        $this->solicitudes_aprobadas = [];

        foreach ($this->estudiantes_lista as $index => $mat) {
            $this->id_matricula[$index] = $mat->id;
            $this->nota_normal[$index] = '';
            $this->nota_especial[$index] = '';
            $this->observacion[$index] = '';
            $this->notas_existentes[$index] = false;
            $this->notas_ids[$index] = null;
            $this->notas_editables[$index] = false;
            $this->solicitudes_aprobadas[$index] = null;

            if ($this->id_horario && $this->id_corte_evaluativo) {
                $notaExistente = Notas::where('id_matricula', $mat->id)
                    ->where('id_horario', $this->id_horario)
                    ->where('id_corte_evaluativo', $this->id_corte_evaluativo)
                    ->first();

                if ($notaExistente) {
                    $this->nota_normal[$index] = $notaExistente->nota_normal ?? '';
                    $this->nota_especial[$index] = $notaExistente->nota_especial ?? '';
                    $this->observacion[$index] = $notaExistente->observacion ?? '';
                    $this->notas_existentes[$index] = true;
                    $this->notas_ids[$index] = $notaExistente->id;

                    // Si el admin aprobó una corrección, el docente puede editar esta nota una sola vez.
                    $solicitudAprobada = $this->solicitudAprobadaParaNota($notaExistente->id);
                    if ($solicitudAprobada) {
                        $this->notas_editables[$index] = true;
                        $this->solicitudes_aprobadas[$index] = $solicitudAprobada->id;
                    }
                }
            }
        }
    }

    protected function resetNoteArrays()
    {
        $this->id_matricula = [];
        $this->nota_normal = [];
        $this->nota_especial = [];
        $this->observacion = [];
        $this->notas_existentes = [];
        $this->notas_ids = [];
        $this->notas_editables = [];
        $this->solicitudes_aprobadas = [];
    }

    public function getFilteredEstudiantesProperty()
    {
        if (!$this->search) {
            return collect($this->estudiantes_lista);
        }

        $term = mb_strtolower($this->search);

        return collect($this->estudiantes_lista)
            ->filter(function ($mat) use ($term) {
                $nombre = mb_strtolower($mat->estudiantes->Nombre ?? '');
                $codigo = mb_strtolower($mat->estudiantes->Código_Persona ?? '');

                return str_contains($nombre, $term) || str_contains($codigo, $term);
            });
    }

    public function guardar()
    {
        $this->validate([
            'id_periodo' => 'required',
            'id_grado' => 'required',
            'id_grupo' => 'required',
            'id_asignatura' => 'required',
            'id_horario' => 'required',
            'id_corte_evaluativo' => 'required',
            'nota_normal.*' => 'nullable|numeric|min:0|max:100',
            'nota_especial.*' => 'nullable|numeric|min:0|max:100',
        ]);

        if (empty($this->id_matricula)) {
            $this->dispatch('alert', type: 'error', message: 'No hay estudiantes cargados para este grupo.');
            return;
        }

        if ($this->esDocente && !$this->horarioPerteneceAlDocente()) {
            $this->dispatch('alert', type: 'error', message: 'No tiene permiso para registrar notas en esta asignatura.');
            return;
        }

        try {
            $guardadas = 0;
            foreach ($this->id_matricula as $index => $id_mat) {
                $nota = $this->nota_normal[$index] ?? null;
                $notaEspecial = $this->nota_especial[$index] ?? null;
                $observacion = $this->observacion[$index] ?? null;
                $tieneDatos = $nota !== null && $nota !== ''
                    || $notaEspecial !== null && $notaEspecial !== ''
                    || $observacion !== null && trim((string) $observacion) !== '';

                // Guardar si hay nota_normal, nota_especial o observacion
                if ($tieneDatos) {
                    $notaExistente = Notas::where('id_matricula', $id_mat)
                        ->where('id_horario', $this->id_horario)
                        ->where('id_corte_evaluativo', $this->id_corte_evaluativo)
                        ->first();

                    if ($this->esDocente && $notaExistente && empty($this->notas_editables[$index])) {
                        continue;
                    }

                    \Log::info("Guardando nota: matricula={$id_mat}, horario={$this->id_horario}, corte={$this->id_corte_evaluativo}, nota_normal={$nota}, nota_especial={$notaEspecial}, observacion={$observacion}");
                    if ($this->esDocente) {
                        $datosNota = [
                            'nota_normal' => $nota,
                            'nota_especial' => $notaEspecial !== null && $notaEspecial !== '' ? $notaEspecial : null,
                            'observacion' => $observacion !== null && trim((string) $observacion) !== '' ? $observacion : null,
                            'id_usuario' => auth()->id(),
                        ];

                        if ($notaExistente) {
                            $notaExistente->update($datosNota);
                            $notaGuardada = $notaExistente;
                            $this->marcarSolicitudComoUsada($index);
                        } else {
                            $notaGuardada = Notas::create(array_merge([
                                'id_matricula' => $id_mat,
                                'id_horario' => $this->id_horario,
                                'id_corte_evaluativo' => $this->id_corte_evaluativo,
                            ], $datosNota));
                        }
                    } else {
                        $notaGuardada = Notas::updateOrCreate(
                            [
                                'id_matricula' => $id_mat,
                                'id_horario' => $this->id_horario,
                                'id_corte_evaluativo' => $this->id_corte_evaluativo,
                            ],
                            [
                                'nota_normal' => $nota,
                                'nota_especial' => $notaEspecial !== null && $notaEspecial !== '' ? $notaEspecial : null,
                                'observacion' => $observacion !== null && trim((string) $observacion) !== '' ? $observacion : null,
                                'id_usuario' => auth()->id(),
                            ]
                        );
                    }

                    $this->notas_existentes[$index] = true;
                    $this->notas_ids[$index] = $notaGuardada->id;
                    $this->notas_editables[$index] = false;
                    $guardadas++;
                    \Log::info("Nota guardada ID: {$notaGuardada->id}");
                } else {
                    \Log::info("Nota vacía para index {$index}, matricula {$id_mat}");
                }
            }

            $this->dispatch('alert', type: 'success', message: "Se guardaron {$guardadas} notas correctamente.");
        } catch (\Exception $e) {
            \Log::error("Error guardando notas: " . $e->getMessage());
            $this->dispatch('alert', type: 'error', message: 'Error al guardar: ' . $e->getMessage());
        }
    }

    protected function horarioPerteneceAlDocente()
    {
        if (!$this->esDocente) {
            return true;
        }

        return Horarios::where('id', $this->id_horario)
            ->where('id_docente', $this->docenteId)
            ->exists();
    }

    protected function solicitudAprobadaParaNota($idNota)
    {
        if (!$this->esDocente || !$this->docenteId) {
            return null;
        }

        return SolicitudCorreccionNota::aprobadasVigentes()
            ->where('id_nota', $idNota)
            ->where('id_docente', $this->docenteId)
            ->latest()
            ->first();
    }

    protected function marcarSolicitudComoUsada($index)
    {
        $idSolicitud = $this->solicitudes_aprobadas[$index] ?? null;

        if (!$idSolicitud) {
            return;
        }

        SolicitudCorreccionNota::where('id', $idSolicitud)->update([
            'estado' => 'usada',
            'usada_at' => now(),
        ]);

        $this->solicitudes_aprobadas[$index] = null;
    }

    public function abrirSolicitudCorreccion($index)
    {
        if (!$this->esDocente || empty($this->notas_ids[$index])) {
            return;
        }

        $this->resetValidation();
        $this->solicitud_index = $index;
        $this->solicitud_nota_id = $this->notas_ids[$index];
        $this->motivo_solicitud = '';
        $this->nota_sugerida = $this->nota_normal[$index] ?? null;

        $this->dispatch('mostrar-modal-solicitud');
    }

    public function enviarSolicitudCorreccion()
    {
        $this->validate([
            'solicitud_nota_id' => 'required|exists:notas,id',
            'motivo_solicitud' => 'required|string|min:8|max:1000',
            'nota_sugerida' => 'nullable|numeric|min:0|max:100',
        ]);

        if (!$this->esDocente || !$this->horarioPerteneceAlDocente()) {
            $this->dispatch('alert', type: 'error', message: 'No tiene permiso para solicitar corrección en esta nota.');
            return;
        }

        $yaExiste = SolicitudCorreccionNota::where('id_nota', $this->solicitud_nota_id)
            ->where('id_docente', $this->docenteId)
            ->whereIn('estado', ['pendiente', 'aprobada'])
            ->exists();

        if ($yaExiste) {
            $this->dispatch('alert', type: 'info', message: 'Ya existe una solicitud pendiente o aprobada para esta nota.');
            $this->dispatch('cerrar-modal-solicitud');
            return;
        }

        // Se guarda como pendiente para que el admin decida desde su panel.
        SolicitudCorreccionNota::create([
            'id_nota' => $this->solicitud_nota_id,
            'id_docente' => $this->docenteId,
            'estado' => 'pendiente',
            'motivo' => $this->motivo_solicitud,
            'nota_sugerida' => $this->nota_sugerida,
        ]);

        $this->dispatch('cerrar-modal-solicitud');
        $this->dispatch('alert', type: 'success', message: 'Solicitud enviada al administrador.');
    }

    public function render()
    {
        $grados = Grados::orderBy('Nombre')
            ->when($this->esDocente, function ($query) {
                $query->whereHas('grupos.horarios', function ($horarioQuery) {
                    $horarioQuery->where('id_docente', $this->docenteId);
                });
            })
            ->get();

        $periodos = Periodo_academicos::orderBy('Nombre', 'desc')
            ->when($this->esDocente, function ($query) {
                $query->whereHas('grupos.horarios', function ($horarioQuery) {
                    $horarioQuery->where('id_docente', $this->docenteId);
                });
            })
            ->get();

        return view('livewire.notas.carga-masiva', [
            'periodos' => $periodos,
            'grados' => $grados,
            'cortes' => $this->cortes,
            'grupos' => $this->grupos,
            'asignaturas' => $this->asignaturas,
            'horarios' => $this->horarios,
            'estudiantes_lista' => $this->estudiantes_lista,
        ]);
    }
};
?>
{{-- 1. ÚNICO CONTENEDOR PADRE --}}
<div class="p-0">

    {{-- 2. BLOQUE DE FILTROS Y BOTÓN GUARDAR --}}
    <div class="card card-outline card-navy shadow-sm mb-3">
        <div class="card-body">
            <div class="row align-items-end">
                {{-- Periodo Académico --}}
                <div class="col-md-2">
                    <label class="text-muted  font-weight-bold">PERIODO</label>
                    <select wire:model.live="id_periodo" class="form-control form-control font-weight-bold">
                        <option value="">-Año --</option>
                        @foreach($periodos as $periodo)
                            <option value="{{ $periodo->id }}">{{ $periodo->Nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Grado --}}
                <div class="col-md-2">
                    <label class="text-muted  font-weight-bold">GRADO</label>
                    <select wire:model.live="id_grado" class="form-control form-control" @disabled(!$id_periodo)>
                        <option value="">-Seleccione grado --</option>
                        @foreach($grados as $grado)
                            <option value="{{ $grado->id }}">{{ $grado->Nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Grupo --}}
                <div class="col-md-2">
                    <label class="text-muted  font-weight-bold">GRUPO</label>
                    <select wire:model.live="id_grupo" class="form-control form-control" @disabled(!$id_grado || $grupos->isEmpty())>
                        <option value="">-Seleccione grupo --</option>
                        @foreach($grupos as $grupo)
                            <option value="{{ $grupo->id }}">{{ $grupo->Nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Asignatura --}}
                <div class="col-md-3">
                    <label class="text-muted  font-weight-bold">ASIGNATURA</label>
                    <select wire:model.live="id_asignatura" class="form-control form-control" @disabled(!$id_grupo || $asignaturas->isEmpty())>
                        <option value="">-Seleccione asignatura --</option>
                        @foreach($asignaturas as $asignatura)
                            <option value="{{ $asignatura->id }}">{{ $asignatura->Nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Corte Evaluativo --}}
                <div class="col-md-3">
                    <label class="text-muted  font-weight-bold">CORTE EVALUATIVO</label>
                    <select wire:model.live="id_corte_evaluativo" class="form-control form-control" @disabled(!$id_periodo)>
                        <option value="">-Seleccionar --</option>
                        @foreach($cortes as $corte)
                            <option value="{{ $corte->id }}">{{ $corte->nombre }} ({{ $corte->ponderacion }}%)</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row align-items-end mt-3">
                <div class="col-md-6">
                    @if($id_asignatura)
                        @if($horarios->count() > 1)
                            <label class="text-muted small font-weight-bold">HORARIO / DOCENTE</label>
                            <select wire:model.live="id_horario" class="form-control form-control-sm">
                                <option value="">-- Seleccione horario --</option>
                                @foreach($horarios as $horario)
                                    <option value="{{ $horario->id }}">
                                        {{ $horario->Dia_semana ?? 'Horario' }}
                                        {{ $horario->Hora_inicio }}-{{ $horario->Hora_fin }}
                                        | {{ $horario->docente->Nombre ?? 'Sin docente' }}
                                    </option>
                                @endforeach
                            </select>
                        @elseif($horarios->count() === 1)
                            <label class="text-muted small font-weight-bold">HORARIO ASIGNADO</label>
                            <div class="form-control form-control-sm bg-white text-sm">
                                {{ $horarios->first()->Dia_semana ?? 'Horario' }}
                                {{ $horarios->first()->Hora_inicio }}-{{ $horarios->first()->Hora_fin }}
                                | {{ $horarios->first()->docente->Nombre ?? 'Sin docente' }}
                            </div>
                        @endif
                    @endif
                </div>

                <div class="col-md-6 text-right mt-2 mt-md-0">
                    <button type="button" wire:click="guardar" class="btn btn-primary shadow-sm" @disabled(!$id_horario || !$id_corte_evaluativo)>
                        <i class="fas fa-cloud-upload-alt mr-1"></i>
                        {{ $this->esDocente ? 'Registrar notas del grupo' : 'Guardar notas del grupo' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <hr>

    {{-- 3. BLOQUE DE CUERPO (TABLA Y OBSERVACIONES) --}}
    <div class="row">

        {{-- Listado Principal (Izquierda) --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-navy py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title text-bold mb-0 text-info small text-uppercase">Info de Estudiantes</h3>
                        {{-- Buscador --}}
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" wire:model.live="search" class="form-control" placeholder="Buscar...">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr class="small text-uppercase">
                                    <th style="padding-left: 1.5rem;">Estudiante</th>
                                    <th style="width: 150px;" class="text-center">Nota Normal</th>
                                    <th style="width: 80px;" class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($this->filteredEstudiantes as $index => $mat)
                                    <tr>
                                        <td style="padding-left: 1.5rem;">
                                            @if($mat->estudiantes)
                                                <div class="font-weight-bold text-sm text-uppercase">{{ $mat->estudiantes->Nombre }}</div>
                                                <small class="text-muted">ID: {{ $mat->estudiantes->Código_Persona }}</small>
                                            @else
                                                <span class="text-danger small italic">Dato de estudiante no encontrado</span>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="number" wire:model.defer="nota_normal.{{ $index }}" 
                                                   class="form-control form-control-sm text-center font-weight-bold border-primary mx-auto" 
                                                   style="max-width: 90px;"
                                                   @disabled($this->esDocente && !empty($notas_existentes[$index]) && empty($notas_editables[$index]))>
                                        </td>
                                        <td class="text-center">
                                            @if(!empty($notas_editables[$index]))
                                                <i class="fas fa-unlock text-success" title="Corrección aprobada"></i>
                                            @elseif(!empty($notas_existentes[$index]))
                                                @if($this->esDocente)
                                                    <button type="button"
                                                            class="btn btn-xs btn-outline-warning"
                                                            title="Solicitar corrección"
                                                            wire:click="abrirSolicitudCorreccion({{ $index }})">
                                                        <i class="fas fa-lock mr-1"></i>Solicitar
                                                    </button>
                                                @else
                                                    <i class="fas fa-lock text-muted" title="Nota registrada"></i>
                                                @endif
                                            @elseif(isset($nota_normal[$index]) && $nota_normal[$index] !== '')
                                                <i class="fas fa-check-circle text-success shadow-sm"></i>
                                            @else
                                                <i class="far fa-circle text-muted"></i>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center py-5 text-muted small">Cargue un grupo y asignatura para visualizar la lista.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Panel de Acciones Especiales (Derecha) --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-navy py-2" style="background-color: #001f3f; color: white;">
                    <h3 class="card-title text-sm text-uppercase">Acciones Especiales (Notas y Observaciones.)</h3>
                </div>
                <div class="card-body bg-light p-2" style="max-height: 75vh; overflow-y: auto;">
                    @foreach($this->filteredEstudiantes as $index => $mat)
                        @if($mat->estudiantes)
                            <div class="card mb-2 shadow-none border bg-white p-2">
                                <label class="text-xs font-weight-bold mb-1 d-block text-truncate">
                                    {{ $mat->estudiantes->Nombre }}
                                </label>
                                <div class="form-row no-gutters">
                                    <div class="col-5 pr-1">
                                        {{-- Campo para Nota Especial --}}
                                        <input type="number" placeholder="Especial" 
                                               wire:model.defer="nota_especial.{{ $index }}" 
                                               class="form-control form-control-sm border-warning"
                                               @disabled($this->esDocente && !empty($notas_existentes[$index]) && empty($notas_editables[$index]))>
                                    </div>
                                    <div class="col-7">
                                        {{-- Campo para Observación --}}
                                        <textarea placeholder="Observación..." 
                                                  wire:model.defer="observacion.{{ $index }}" 
                                                  class="form-control form-control-sm" 
                                             rows="1"
                                             @disabled($this->esDocente && !empty($notas_existentes[$index]) && empty($notas_editables[$index]))></textarea>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div> {{-- Fin Columna Derecha --}}

    </div> {{-- Fin Row Cuerpo --}}

{{-- Modal Livewire: el docente explica por qué necesita corregir una nota ya registrada. --}}
<div wire:ignore.self class="modal fade" id="modalSolicitudCorreccion" tabindex="-1" role="dialog" aria-labelledby="modalSolicitudCorreccionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="modalSolicitudCorreccionLabel">
                    <i class="fas fa-exclamation-circle mr-1"></i> Solicitar corrección
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nota sugerida</label>
                    <input type="number" class="form-control" wire:model.defer="nota_sugerida" min="0" max="100">
                    @error('nota_sugerida') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group">
                    <label>Motivo</label>
                    <textarea class="form-control" rows="4" wire:model.defer="motivo_solicitud" placeholder="Explique al administrador por qué necesita corregir esta nota."></textarea>
                    @error('motivo_solicitud') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"></i> Cancelar</button>
                <button type="button" class="btn btn-warning" wire:click="enviarSolicitudCorreccion">
                    <i class="fas fa-paper-plane mr-1"></i> Enviar solicitud
                </button>
            </div>
        </div>
    </div>
</div>

<script>
window.addEventListener('mostrar-modal-solicitud', () => $('#modalSolicitudCorreccion').modal('show'));
window.addEventListener('cerrar-modal-solicitud', () => $('#modalSolicitudCorreccion').modal('hide'));
</script>

<style>
    /* Estilos personalizados para un look moderno */
    .avatar-circle {
        width: 35px; height: 35px; background: #e9ecef; 
        border-radius: 50%; display: flex; align-items: center; 
        justify-content: center; font-weight: bold; color: #495057;
    }
    .badge-success-soft { background: #d4edda; color: #28a745; padding: 5px 10px; border-radius: 20px; }
    .badge-warning-soft { background: #fff3cd; color: #856404; padding: 5px 10px; border-radius: 20px; }
    .sticky-top { z-index: 1000; }
    .bg-navy { background-color: #001f3f; }
</style>

</div> {{-- FIN ÚNICO CONTENEDOR PADRE --}}
