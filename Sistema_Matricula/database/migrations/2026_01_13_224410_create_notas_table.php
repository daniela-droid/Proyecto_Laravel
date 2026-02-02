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
        Schema::create('notas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_estudiantes')->index('notas_id_estudiantes_foreign');
            $table->unsignedBigInteger('id_asignaturas')->index('notas_id_asignaturas_foreign');
            $table->unsignedBigInteger('id_usuarios')->index('notas_id_usuarios_foreign');
            $table->decimal('notas', 5);
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
