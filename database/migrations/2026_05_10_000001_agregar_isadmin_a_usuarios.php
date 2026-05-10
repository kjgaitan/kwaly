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
        if (Schema::hasTable('usuarios') && !Schema::hasColumn('usuarios', 'isadmin')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->boolean('isadmin')->default(false)->after('estado_cuenta');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn('isadmin');
        });
    }
};
