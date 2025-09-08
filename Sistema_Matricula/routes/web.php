<?php

use Illuminate\Support\Facades\Route;
use Illuminate\views;
use App\Http\Controllers\EstudiantesController;
use App\Http\Controllers\AsignaturasController;
use App\Http\Controllers\MatriculasController;
use App\Http\Controllers\UsuariosController;

Route::get('/', function () {    
    return view('estudiantes');
});

Route::resource('estudiantes', EstudiantesController::class);
Route::resource('asignaturas', AsignaturasController::class);
Route::resource('matriculas',MatriculasController::class);
Route::resource('usuarios',UsuariosController::class);