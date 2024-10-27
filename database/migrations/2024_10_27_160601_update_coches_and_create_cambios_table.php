<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Elimino cilindrada de la tabla coches
        Schema::table('coches', function (Blueprint $table) {
            $table->dropColumn('cilindrada');
        });
        // Creo al tabla cambios y añado las 2 opciones posibles
        Schema::create('cambios', function (Blueprint $table) {
            $table->id();
            $table->string('tipo')->unique();
        });
        DB::table('cambios')->insert([
            ['tipo' => 'Automático'],
            ['tipo' => 'Manual']
        ]);
        // Relación entre coches y cambios
        Schema::table('coches', function (Blueprint $table) {
            $table->foreignId('cambio_id')->constrained('cambios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coches', function (Blueprint $table) {
            $table->dropForeign(['cambio_id']);
            $table->dropColumn('cambio_id');
        });

        Schema::dropIfExists('cambios');

        Schema::table('coches', function (Blueprint $table) {
            $table->integer('cilindrada')->nullable();
        });
    }
};
