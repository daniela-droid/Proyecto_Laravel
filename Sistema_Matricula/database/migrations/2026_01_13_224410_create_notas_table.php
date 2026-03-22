<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): voids
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_matricula')->index('notas_id_matricula_foreign');// Trae al alumno y su grado
            $table->unsignedBigInteger('id_horario')->index('notas_id_horario_foreign');   // Trae la materia, el profe y el grupo
            $table->unsignedBigInteger('id_corte_evaluativo')->index('notas_id_corte_evaluativo_foreign'); // Trae el momento (I Corte, etc.)
            $table->unsignedBigInteger('id_usuario')->index('notas_id_usuario_foreign');

           
            $table->double('nota_normal')->default(0); // La que se saca en el corte
            $table->double('nota_especial')->nullable(); // Solo se llena si va a reparación
            $table->string('observacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};
