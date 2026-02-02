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
            $table->bigIncrements('id');
            $table->string('Codigo');
            $table->string('Nombre');
            $table->string('Descripcion');
            $table->string('Seccion');
            $table->string('Grado');
            $table->unsignedBigInteger('id_turnos')->index('grupos_id_turnos_foreign');
            $table->unsignedBigInteger('id_docentes')->index('grupos_id_docentes_foreign');
            $table->string('Periodo');
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
