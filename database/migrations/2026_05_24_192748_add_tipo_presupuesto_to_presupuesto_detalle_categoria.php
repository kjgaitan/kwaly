<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('presupuesto_detalle_categoria') && !Schema::hasColumn('presupuesto_detalle_categoria', 'tipo_presupuesto')) {
            Schema::table('presupuesto_detalle_categoria', function (Blueprint $table) {
                $table->enum('tipo_presupuesto', [
                    'necesidades',
                    'deseos',
                    'ahorro'
                ])->after('id_categoria');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('presupuesto_detalle_categoria') && Schema::hasColumn('presupuesto_detalle_categoria', 'tipo_presupuesto')) {
            Schema::table('presupuesto_detalle_categoria', function (Blueprint $table) {
                $table->dropColumn('tipo_presupuesto');
            });
        }
    }
};
