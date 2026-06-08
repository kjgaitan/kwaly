<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('gastos_compartidos')) {
            return;
        }

        Schema::table('gastos_compartidos', function (Blueprint $table) {
            if (!Schema::hasColumn('gastos_compartidos', 'id_categoria')) {
                $table->unsignedBigInteger('id_categoria')->nullable()->after('titulo');
            }
        });

        if (!Schema::hasTable('gasto_compartido_participantes')) {
            Schema::create('gasto_compartido_participantes', function (Blueprint $table) {
                $table->id('id_participante');
                $table->unsignedBigInteger('id_gasto');
                $table->unsignedBigInteger('id_usuario');
                $table->unique(['id_gasto', 'id_usuario'], 'gasto_participante_unique');
            });
        }

        if (Schema::hasColumn('gastos_compartidos', 'categoria') && Schema::hasTable('categorias')) {
            DB::table('gastos_compartidos')
                ->whereNull('id_categoria')
                ->whereNotNull('categoria')
                ->orderBy('id_gasto')
                ->chunkById(100, function ($gastos) {
                    foreach ($gastos as $gasto) {
                        $categoria = DB::table('categorias')
                            ->whereRaw('LOWER(nombre) = ?', [mb_strtolower($gasto->categoria)])
                            ->orderByRaw('id_usuario IS NOT NULL')
                            ->first();

                        if ($categoria) {
                            DB::table('gastos_compartidos')
                                ->where('id_gasto', $gasto->id_gasto)
                                ->update(['id_categoria' => $categoria->id_categoria]);
                        }
                    }
                }, 'id_gasto');
        }

        DB::table('gastos_compartidos')
            ->orderBy('id_gasto')
            ->chunkById(100, function ($gastos) {
                foreach ($gastos as $gasto) {
                    $yaTieneParticipantes = DB::table('gasto_compartido_participantes')
                        ->where('id_gasto', $gasto->id_gasto)
                        ->exists();

                    if ($yaTieneParticipantes) {
                        continue;
                    }

                    $miembros = DB::table('grupo_miembros')
                        ->where('id_grupo', $gasto->id_grupo)
                        ->pluck('id_usuario');

                    foreach ($miembros as $idUsuario) {
                        DB::table('gasto_compartido_participantes')->insert([
                            'id_gasto' => $gasto->id_gasto,
                            'id_usuario' => $idUsuario,
                        ]);
                    }
                }
            }, 'id_gasto');
    }

    public function down(): void
    {
        Schema::dropIfExists('gasto_compartido_participantes');

        if (Schema::hasTable('gastos_compartidos') && Schema::hasColumn('gastos_compartidos', 'id_categoria')) {
            Schema::table('gastos_compartidos', function (Blueprint $table) {
                $table->dropColumn('id_categoria');
            });
        }
    }
};
