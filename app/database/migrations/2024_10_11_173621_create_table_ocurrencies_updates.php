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
        Schema::create('ocurrences_updates', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->foreignId('users_id')->constrained('users');
            $table->foreignId('ocurrences_id')->constrained('ocurrences');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ocurrences_updates');
    }
};
