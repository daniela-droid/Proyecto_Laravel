<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitudes_correccion_notas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_nota')->index();
            $table->unsignedBigInteger('id_docente')->index();
            $table->unsignedBigInteger('id_admin')->nullable()->index();
            $table->string('estado')->default('pendiente')->index();
            $table->text('motivo');
            $table->double('nota_sugerida')->nullable();
            $table->text('respuesta_admin')->nullable();
            $table->timestamp('aprobada_hasta')->nullable();
            $table->timestamp('usada_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes_correccion_notas');
    }
};
