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
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->integer('number')->nullable();
            $table->string('neighborhood');
            $table->string('postal_code')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->boolean('active')->default(1);
            $table->string('responsible');
            $table->foreignId('secretary_id')->constrained('secretaries');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
