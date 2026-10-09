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
        Schema::create('capacitaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('area');
            $table->text('descripcion')->nullable();
            $table->text('requisitos')->nullable();
            $table->date('fecha');
            $table->time('hora');
            $table->unsignedInteger('cupo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('capacitaciones');
    }
};
