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
            $table->id();
            /*creamos relacion con las difenrentes tablas*/
    $table->foreign('id_estudiantes')->references('id')->on('estudiantes')->onDelete('cascade'); 

    $table->foreign('id_asignaturas')->references('id')->on('asignaturas')->onDelete('cascade'); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
