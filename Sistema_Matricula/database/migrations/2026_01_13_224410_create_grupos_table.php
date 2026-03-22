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
            $table->string('Código');
            $table->string('Nombre');//puede ser A O B
            $table->string('Descripcion');
            $table->unsignedBigInteger('id_turno')->index('grupos_id_turno_foreign');
            $table->unsignedBigInteger('id_grado')->index('grupos_id_grado_foreign');
           $table->unsignedBigInteger('id_periodo_academicos')->index('grupos_id_periodo_academicos_foreign');
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
