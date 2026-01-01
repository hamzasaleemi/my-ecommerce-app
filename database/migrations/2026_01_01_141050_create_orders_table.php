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
        Schema::create('orders', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Table Columns
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['completed'])->default('completed');

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
