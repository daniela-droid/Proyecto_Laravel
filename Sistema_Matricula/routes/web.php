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
use App\Http\Controllers\Auth\LoginController;


use App\Http\Middleware;


Route::get('/', function () {
    return view('inicio');
})->middleware('auth')->name('inicio');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); // muestra la vista login
Route::post('/login', [LoginController::class, 'login']); // procesa el login
Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); // logout



Route::middleware('auth')->group(function () {

// Recursos generales (todos logueados pueden acceder)
    Route::resource('estudiantes', EstudiantesController::class);
    Route::resource('asignaturas', AsignaturasController::class);
    Route::resource('matriculas', MatriculasController::class);
    Route::resource('notas', NotasController::class);
    Route::resource('docentes',DocentesController::class);
    Route::resource('grupos',GruposController::class);
    Route::resource('turnos',TurnosController::class);

    // Usuarios solo para admin
    Route::resource('usuarios', UsuariosController::class)->middleware('role:admin');
});