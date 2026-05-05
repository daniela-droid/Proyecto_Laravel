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
        Schema::create('reportes_admins', function (Blueprint $table) {
           $table->bigIncrements('id');
            $table->foreign('id_admin')->references('id')->on('admins')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion');
            $table->enum('categoria', ['sistema', 'infraestructura', 'personal', 'otros']);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes_admins');
    }
};
