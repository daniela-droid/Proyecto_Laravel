<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     
     */
    public function up(): void
    {
        Schema::create('padres', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Nombre_o_Tutor');
            $table->string('Apellido');
            $table->string('Email');
            $table->string('Cedula');
            $table->string('Telefono');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('padres');
    }
};
