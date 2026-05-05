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
        Schema::create('reportes_docentes', function (Blueprint $table) {
            $table->id();
             $table->foreign('id_docente')->references('id')->on('docentes')->onDelete('cascade');//quien lo hace
            $table->foreign('id_estudiante')->references('id')->on('estudiantes')->onDelete('cascade');//quien lo ve
          
            $table->string('titulo');
            $table->text('descripcion');
            $table->enum('tipo', ['conducta', 'rendimiento', 'asistencia']);
            $table->timestamps();
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes_docentes');
    }
};
