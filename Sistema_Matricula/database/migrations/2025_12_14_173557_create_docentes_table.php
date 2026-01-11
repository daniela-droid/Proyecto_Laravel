<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre');
             $table->string('Apellido');
            $table->date('FechadeNacimiento');
             $table->string('Gmail');
            $table->integer('Telefono');
            $table->string('Especialidad');
            $table->string('GrupoAsignado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
