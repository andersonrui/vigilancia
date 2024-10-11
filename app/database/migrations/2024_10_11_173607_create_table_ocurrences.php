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
        Schema::create('ocurrences', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('solution_date');
            $table->foreignId('categories_ocurrences_id')->constrained('categories_ocurrences');
            $table->foreignId('buildings_id')->constrained('buildings');
            $table->foreignId('users_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ocurrences');
    }
};
