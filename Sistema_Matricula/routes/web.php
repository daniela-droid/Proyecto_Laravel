<?php

use Illuminate\Support\Facades\Route;
use Illuminate\views;
use App\Http\Controllers\EstudiantesController;
use App\Http\Controllers\AsignaturasController;
use App\Http\Controllers\MatriculasController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\NotasController;
use App\Http\Controllers\DocentesController;
use App\Http\Controllers\GruposController;
use App\Http\Controllers\TurnosController;
use App\Http\Controllers\PadresController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\ComarcaController;
use App\Http\Controllers\AulasController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GradosController;
use App\Http\Controllers\HorariosController;
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\ModalidadesController;
use App\Http\Controllers\CortesEvaluativosController;
use App\Http\Controllers\ReportesAdminController;
use App\Http\Controllers\ReportesDocenteController;
use App\Http\Controllers\ReportesAdmController;
use App\Http\Controllers\SolicitudesCorreccionNotasController;
use App\Models\Estudiante;
use App\Models\Horarios;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware;

// 1. RUTAS PÚBLICAS (LIBRES)

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Esta es tu llave maestra para escapar:
Route::get('/logout-manual', function () {
    auth()->logout();
    session()->flush();
    return redirect('/login');
})->name('logout.manual');

// 2. RUTAS PROTEGIDAS (Solo para los que ya pasaron el login)
Route::middleware(['auth'])->group(function () {

Route::get('/acceso-denegado', function() { 
        return view('No_permisos'); 
    })->name('No_permisos');

   //vista general para ambos
  Route::get('/', function () {
        return view('inicio'); 
    })->name('inicio');

    // --- GRUPO ADMIN ---
    Route::middleware('role:admin')->group(function () {
        Route::resource('usuarios', UsuariosController::class);
        Route::resource('admins', AdminController::class);
        Route::resource('docentes', DocentesController::class);
        Route::resource('grupos', GruposController::class);
        Route::resource('grados', GradosController::class);
        Route::resource('aulas', AulasController::class);
        Route::resource('estudiantes', EstudiantesController::class);
         Route::get('/estudiantes-primaria', [EstudiantesController::class, 'primaria'])->name('estudiantes.primaria');
        Route::get('/estudiantes-secundaria', [EstudiantesController::class, 'secundaria'])->name('estudiantes.secundaria');
        Route::post('estudiantes/store-rapido', [EstudiantesController::class, 'storeRapido']);
        Route::resource('asignaturas', AsignaturasController::class);
        Route::resource('horarios', HorariosController::class);
         Route::resource('turnos', TurnosController::class);
        Route::resource('especialidades', EspecialidadController::class)->parameters([
        'especialidades' => 'especialidad'
        ]);
        Route::resource('periodo', PeriodoAcademicoController::class);
        Route::resource('padres', PadresController::class);
         Route::post('padres/store-rapido', [PadresController::class, 'storeRapido']);
        Route::resource('comarcas', ComarcaController::class);
        Route::post('comarcas/store-rapido', [ComarcaController::class, 'storeRapido']);
        Route::resource('matriculas', MatriculasController::class);
  
        Route::resource('modalidades', ModalidadesController::class);
        Route::resource('cortes', CortesEvaluativosController::class);
        Route::get('/notas/matricula/{idMatricula}/historial', [NotasController::class, 'historialMatricula'])->name('notas.historial');
        Route::resource('notas', NotasController::class);
        Route::get('/admin/solicitudes-notas', [SolicitudesCorreccionNotasController::class, 'index'])->name('admin.solicitudes-notas.index');
        Route::post('/admin/solicitudes-notas/{solicitud}/aprobar', [SolicitudesCorreccionNotasController::class, 'aprobar'])->name('admin.solicitudes-notas.aprobar');
        Route::post('/admin/solicitudes-notas/{solicitud}/rechazar', [SolicitudesCorreccionNotasController::class, 'rechazar'])->name('admin.solicitudes-notas.rechazar');
         Route::resource('reportesadm', ReportesAdminController::class)->parameters([
         'reportesadm'=>'reporte']);
         Route::get('/reporte-pdf/{tipo}/{id}', [ReportesAdmController::class, 'generarPdf'])->name('reportes.pdf');
  
     
     
          
    });

         //para que retorne y se comunique con las notas y los estudiantes del horario 
        Route::get('/horarios/{id}/estudiantes', [HorariosController::class, 'getEstudiantesPorHorario']);

            Route::get('/api/horarios/{id}/estudiantes', function($id) {
            try {
        // Buscamos el horario cargando la relación grupo y sus estudiantes
        // Asegúrate que en tu modelo Grupo la relación se llame 'estudiantes'
                 $horario = Horarios::with(['grupo.estudiantes'])->find($id);

                    if (!$horario || !$horario->grupo) {
                        return response()->json([], 200);
                    }
                // Extraemos los estudiantes con su ID de matrícula
                $estudiantes = $horario->grupo->estudiantes->map(function($est) {
                    return [
                        // 'pivot' es donde Laravel guarda los datos de la tabla intermedia
                        'id_matricula' => $est->pivot->id ?? $est->id, 
                        'Nombre' => $est->Nombre,
                        'Apellido' => $est->Apellido
                    ];
                });

        return response()->json($estudiantes);

    } catch (\Exception $e) {
        // Esto escribirá el error real en storage/logs/laravel.log
        Log::error("Error en API Estudiantes: " . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
//rutas para metodos 
  
         //pdf para docentes
        Route::get('/reporte-pdf/{tipo}/{id}', [ReportesAdmController::class, 'generarPdf'])->name('reportes.pdf');
  
        Route::get('/guia-sistema', function (){ return view('description');})->name('guia.description');
        Route::get('/guia-politicas', function (){ return view('Politicas');})->name('guia.Politicas');
        // --- grupo docente---
        Route::middleware('role:docentes')->group(function () {
        Route::get('/mi-horario', [HorariosController::class, 'miHorario'])->name('docente.mi_horario');
        //Esto debo analizarlo encaunto a la matricula para el curso que llevara el estudiante
        Route::get('/mis-estudiantes', [HorariosController::class, 'misEstudiantes']);
        Route::get('/docente/notas/create', [NotasController::class, 'createDocente'])->name('docente.notas.create');
        Route::resource('reportes', ReportesDocenteController::class);

    });
});
