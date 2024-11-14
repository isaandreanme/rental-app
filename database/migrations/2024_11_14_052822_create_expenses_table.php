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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade')->nullable();
            $table->foreignId('driver_id')->constrained()->onDelete('cascade')->nullable();
            $table->date('date_expense')->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->string('receipt')->nullable();
            $table->enum('type_date_expense', [
                'Fuel', 
                'Maintenance', 
                'Repairs', 
                'Insurance', 
                'Parking Fees', 
                'Toll Fees', 
                'Cleaning', 
                'Marketing'
            ])->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
