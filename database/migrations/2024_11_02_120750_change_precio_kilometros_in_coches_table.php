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
        Schema::table('coches', function (Blueprint $table) {
            $table->integer('precio')->change();
            $table->integer('kilometros')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coches', function (Blueprint $table) {
            $table->decimal('precio', 10, 2)->change();
            $table->decimal('kilometros', 8, 2)->change();
        });
    }
};
