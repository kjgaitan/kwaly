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
        if (!Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->id('id_usuario');
                $table->string('nombre', 100);
                $table->string('email', 150)->unique();
                $table->string('password_hash', 255);
                $table->string('telefono', 20)->nullable();
                $table->char('moneda_preferida', 3)->default('EUR');
                $table->string('idioma_preferido', 10)->default('es');
                $table->enum('estado_cuenta', ['activo', 'inactivo', 'bloqueado'])->default('activo');
                $table->dateTime('fecha_registro')->nullable();
                $table->dateTime('ultimo_acceso')->nullable();
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
