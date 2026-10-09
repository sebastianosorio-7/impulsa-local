<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('capacitacion_id')->constrained('capacitaciones')->cascadeOnDelete();
            $table->string('estado')->default('inscrito');
            $table->unsignedTinyInteger('progreso')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'capacitacion_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};
