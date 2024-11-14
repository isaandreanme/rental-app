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
        Schema::create('rental_agreements', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade')->nullable();
            $table->foreignId('driver_id')->constrained('drivers')->onDelete('cascade')->nullable();
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade')->nullable();
            $table->date('rental_start_date')->nullable();
            $table->date('rental_end_date')->nullable();
            $table->integer('rental_duration')->nullable();
            $table->enum('status', ['Draft', 'Active', 'Completed', 'Cancelled'])->default('Draft')->nullable();
            $table->text('terms_condition')->nullable();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_agreements');
    }
};
