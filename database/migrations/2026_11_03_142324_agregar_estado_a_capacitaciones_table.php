<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('capacitaciones')) {
            Schema::table('capacitaciones', function (Blueprint $table) {
                if (!Schema::hasColumn('capacitaciones', 'estado')) {
                    // Quitamos el ->after('cupos') para evitar el error
                    $table->string('estado')->default('abierta');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('capacitaciones')) {
            Schema::table('capacitaciones', function (Blueprint $table) {
                if (Schema::hasColumn('capacitaciones', 'estado')) {
                    $table->dropColumn('estado');
                }
            });
        }
    }
};
