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
        Schema::table('projects', function (Blueprint $table) {
            // Eliminar la columna 'status' existente si es necesario
            if (Schema::hasColumn('projects', 'status')) {
                $table->dropColumn('status');
            }

            // Agregar la columna 'status_id' con relación a la tabla 'status' y permitir null
            $table->foreignId('status_id')->after('category_id')->nullable()->constrained('status')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Eliminar la relación 'status_id'
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');

            // Restaurar la columna 'status' si es necesario
            if (!Schema::hasColumn('projects', 'status')) {
                $table->enum('status', ['En proceso', 'Terminado', 'Idea'])->after('category_id');
            }
        });
    }
};