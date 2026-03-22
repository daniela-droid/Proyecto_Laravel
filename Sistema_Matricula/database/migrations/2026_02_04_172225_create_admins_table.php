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
        Schema::create('admins', function (Blueprint $table) {
             $table->bigIncrements('id');
           
            $table->unsignedBigInteger('id_usuarios')->unique()->index('admins_id_usuarios_foreign');
            $table->string('Nombre');
            $table->string('Apellido');
            $table->string('Cargo')->nullable(); 
            $table->timestamps();

           
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
