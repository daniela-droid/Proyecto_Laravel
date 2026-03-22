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
use App\Http\Controllers\ReportesController;
use App\Models\Estudiante;
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
        Route::resource('asignaturas', AsignaturasController::class);
        Route::resource('horarios', HorariosController::class);
         Route::resource('turnos', TurnosController::class);
        Route::resource('especialidades', EspecialidadController::class);
        Route::resource('periodo', PeriodoAcademicoController::class);
        Route::resource('padres', PadresController::class);
        Route::resource('comarcas', ComarcaController::class);
      Route::resource('matriculas', MatriculasController::class);
          Route::resource('modalidades', ModalidadesController::class);
           Route::resource('cortes', CortesEvaluativosController::class);
            Route::resource('reportes', ReportesController::class);
             Route::resource('notas', NotasController::class);
          
    });

    Route::get('/mis-estudiantes', [HorariosController::class, 'misEstudiantes']);

    // --- grupo docente---
    Route::middleware('role:docentes')->group(function () {
        Route::get('/mi-horario', [HorariosController::class, 'miHorario'])->name('docente.mi_horario');
        //Esto debo analizarlo encaunto a la matricula para el curso que llevara el estudiante
       Route::get('/mis-estudiantes', [HorariosController::class, 'misEstudiantes']);
    });
});