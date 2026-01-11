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
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->string('Codigo');
            $table->string('Nombre');
            $table->string('Descripcion');
            $table->string('Seccion');
            $table->string('Grado');
            $table->unsignedBigInteger('id_turnos');
            $table->unsignedBigInteger('id_docentes');
            $table->string('Periodo');

            $table->foreign('id_turnos')->references('id')->on('turnos')->onDelete('cascade'); 
            $table->foreign('id_docentes')->references('id')->on('docentes')->onDelete('cascade'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
