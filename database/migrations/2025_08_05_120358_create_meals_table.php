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
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('meal_date');
            $table->enum('meal_type', ['lunch', 'dinner']);
            $table->enum('status', ['scheduled', 'taken', 'cancelled'])->default('scheduled');
            $table->decimal('cost', 8, 2)->nullable();
            $table->integer('rating')->nullable(); // 1-5 rating
            $table->text('feedback')->nullable();
            $table->timestamp('taken_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users_table_updated');
            $table->unique(['user_id', 'meal_date', 'meal_type']); // One meal per type per day per user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
