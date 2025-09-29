<?php

use Illuminate\Support\Facades\Route;
use Illuminate\views;
use App\Http\Controllers\EstudiantesController;
use App\Http\Controllers\AsignaturasController;
use App\Http\Controllers\MatriculasController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\NotasController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {    
    return view('inicio');
});


Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::resource('login', LoginController::class);
Route::resource('estudiantes', EstudiantesController::class);
Route::resource('asignaturas', AsignaturasController::class);
Route::resource('matriculas',MatriculasController::class);
Route::resource('usuarios',UsuariosController::class);
Route::resource('notas',NotasController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
