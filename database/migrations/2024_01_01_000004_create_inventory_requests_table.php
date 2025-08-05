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
        Schema::create('inventory_requests', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->decimal('quantity', 10, 2);
            $table->string('unit_type', 10);
            $table->decimal('price', 10, 2);
            $table->decimal('threshold', 10, 2);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('requested_by')->constrained('users');
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_requests');
    }
};
