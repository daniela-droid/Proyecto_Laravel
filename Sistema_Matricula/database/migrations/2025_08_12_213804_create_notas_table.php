<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up(): void { Schema::create('notas', function (Blueprint $table) {
    $table->id();

    $table->foreignId('id_estudiantes')
          ->constrained('estudiantes') // 👈 aquí
          ->onDelete('cascade');

    $table->foreignId('id_asignaturas')
          ->constrained('asignaturas') // 👈 aquí
          ->onDelete('cascade');

    $table->foreignId('id_usuarios')
          ->constrained('usuarios') // 👈 aquí
          ->onDelete('cascade');

    $table->decimal('notas', 5, 2);
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
