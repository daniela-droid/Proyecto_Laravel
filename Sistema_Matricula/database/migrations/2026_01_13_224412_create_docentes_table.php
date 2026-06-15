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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_usuario')->unique()->index('docentes_id_usuario_foreign');
            $table->string('Nombre');
            $table->string('Apellido');
            $table->date('FechadeNacimiento');
            $table->string('Email');
            $table->string('Telefono');
            $table->unsignedBigInteger('id_especialidads')->index('docentes_id_especialidads_foreign');
            $table->timestamps();

            $table->foreign('id_usuario')->references('id')->on('usuarios')->onDelete('cascade');
            
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
