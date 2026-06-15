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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Código_Persona');
            $table->string('c_temporal');
            $table->string('Nombre');
            $table->string('Apellido');
            $table->string('Sexo');
            $table->date('Fecha_N');
           $table->string('Celular');
            $table->unsignedBigInteger('id_padre')->index('estudiantes_id_padre_foreign')->nullable();;
            $table->unsignedBigInteger('id_comarca')->index('estudiantes_id_comarca_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};

