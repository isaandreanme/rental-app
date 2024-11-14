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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone_number')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->integer('age')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('address')->nullable();
            $table->string('license_number')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->string('document')->nullable();
            $table->string('license')->nullable();
            $table->string('reference')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
