<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('documento')->nullable()->unique();
            $table->string('actividad_economica')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('rol')->default('emprendedor');
            $table->string('estado')->default('activo');
            $table->boolean('requisitos_verificados')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'documento',
                'actividad_economica',
                'ubicacion',
                'telefono',
                'rol',
                'estado',
                'requisitos_verificados',
            ]);
        });
    }
};