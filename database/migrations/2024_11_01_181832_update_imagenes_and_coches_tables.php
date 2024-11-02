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
        Schema::table('imagenes', function (Blueprint $table) {
            $table->string('url');
        });

        Schema::table('coches', function (Blueprint $table) {
            $table->dropColumn('imagen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('imagenes', function (Blueprint $table) {
            $table->dropColumn('url');
        });

        Schema::table('coches', function (Blueprint $table) {
            $table->string('imagen')->nullable();
        });
    }
};
