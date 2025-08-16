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
            $table->id();
            $table->foreignId('Id_Estudiantes')->constrained()->onDelete('cascade');
            $table->foreignId('Id_Asignarura')->constrained()->onDelete('cascade');
            $table->foreignId('Id_usuario')->constrained()->onDelete('cascade');//quien registro las notas
            $table->Decimal('notas',5,2);//esto para decir la cantidad del primer dato hasta 5 y despues de los puntos 2 
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
