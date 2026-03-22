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
        Schema::create('matriculas', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->foreign('id_estudiante')->references('id')->on('estudiantes')->onDelete('cascade');
            $table->foreign('id_grupo')->references('id')->on('grupos');
            $table->foreign('id_periodo_academicos')->references('id')->on('periodo_academicos');
            $table->foreign('id_usuario')->references('id')->on('matriculas');


            $table->date('fecha_matricula');
            $table->enum('estado',['Activo','Retirado','Suspendido','Expulsado']);
            $table->string('observaciones')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
        {Schema::table('matriculas', function (Blueprint $table) {
            // Es buena práctica poder deshacerlo si algo sale mal
            $table->dropForeign(['id_estudiante']);
            $table->dropForeign(['id_grupo']);
            $table->dropForeign(['id_periodo_academicos']);
            $table->dropForeign(['id_usuario']);
        });
    }
};
