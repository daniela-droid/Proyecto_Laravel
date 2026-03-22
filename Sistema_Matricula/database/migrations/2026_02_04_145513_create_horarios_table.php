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
        Schema::create('horarios', function (Blueprint $table) {
        $table->bigIncrements('id');
        //id de relaciones
        $table->unsignedBigInteger('id_grupo')->index('horarios_id_grupo_foreign');
        $table->unsignedBigInteger('id_asignatura')->index('horarios_id_asignatura_foreign');
        $table->unsignedBigInteger('id_docente')->index('horarios_id_docente_foreign');
        $table->unsignedBigInteger('id_aula')->index('horarios_id_aula_foreign');

    //columnas de horarios

        $table->enum('Dia_semana', ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado']);
        $table->time('Hora_inicio');
        $table->time('Hora_fin');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
