<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('gastos_compartidos')) {
            return;
        }

        Schema::table('gastos_compartidos', function (Blueprint $table) {
            if (!Schema::hasColumn('gastos_compartidos', 'categoria')) {
                $table->string('categoria', 50)->nullable()->after('titulo');
            }

            if (!Schema::hasColumn('gastos_compartidos', 'descripcion')) {
                $table->string('descripcion', 255)->nullable()->after('categoria');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('gastos_compartidos')) {
            return;
        }

        Schema::table('gastos_compartidos', function (Blueprint $table) {
            if (Schema::hasColumn('gastos_compartidos', 'descripcion')) {
                $table->dropColumn('descripcion');
            }

            if (Schema::hasColumn('gastos_compartidos', 'categoria')) {
                $table->dropColumn('categoria');
            }
        });
    }
};
