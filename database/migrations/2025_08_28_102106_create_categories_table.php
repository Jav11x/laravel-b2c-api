<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Crea la tabla de categorías.
 * Reglas:
 *  - 'name' único para evitar duplicados lógicos.
 */

return new class extends Migration
{
    /** Ejecuta la migración. */

    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->unique('name');
        });
    }

    /** Revierte la migración. */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
