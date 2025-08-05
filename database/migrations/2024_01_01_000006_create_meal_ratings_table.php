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
        Schema::create('meal_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_id')->nullable()->constrained('meals');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->integer('rating')->nullable()->check('rating >= 1 AND rating <= 5');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_ratings');
    }
};
