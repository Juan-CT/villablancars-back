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
        Schema::create('coches', function (Blueprint $table) {
            $table->id(); // ID auto incremental
            $table->foreignId('marca_id')->constrained()->onDelete('cascade');
            $table->foreignId('carroceria_id')->constrained()->onDelete('cascade');
            $table->string('modelo');
            $table->year('anio');
            $table->string('color');
            $table->decimal('precio', 10, 2);
            $table->decimal('kilometros', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coches');
    }
};
