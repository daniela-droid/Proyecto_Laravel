<?php

use Illuminate\Support\Facades\Route;
use Illuminate\views;
use App\Http\Controllers\EstudiantesController;
use App\Http\Controllers\AsignaturasController;

Route::get('/', function () {    
    return view('estudiantes');
});

Route::resource('estudiantes', EstudiantesController::class);
Route::resource('asignaturas', AsignaturasController::class);