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
        Schema::create('cortes_evaluativos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_modalidades')->index('cortes_evaluativos_id_modalidades_foreign'); //no
            $table->string('nombre');
            $table->integer('ponderacion');
            $table->unsignedBigInteger('id_periodo_academicos')->index('cortes_evaluativos_id_periodo_academicos_foreign'); 
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cortes_evaluativos');
    }
};
