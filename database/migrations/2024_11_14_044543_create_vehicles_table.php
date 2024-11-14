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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('vehicle_name');
            $table->string('type')->nullable();
            $table->string('model')->nullable();
            $table->string('engine_type')->nullable();
            $table->string('engine_number')->nullable();
            $table->string('license_plate')->nullable();
            $table->date('registration_expiry_date')->nullable();
            $table->integer('year_of_first_immatriculation')->nullable();
            $table->string('fuel_type')->nullable();
            $table->integer('kilometer')->nullable();
            $table->decimal('daily_rate', 10, 2)->nullable();
            $table->string('gearbox')->default('Automatic')->nullable();
            $table->integer('number_of_seats')->nullable();
            $table->string('options')->nullable();
            $table->string('document')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
