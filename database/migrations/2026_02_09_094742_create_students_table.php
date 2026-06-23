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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('id_proof_number')->nullable();
            $table->string('id_proof_type')->nullable(); // Aadhaar, Passport, etc.
            $table->string('photo')->nullable();
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('set null');
            $table->date('joining_date')->nullable();
            $table->enum('status', ['active', 'inactive', 'alumni'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
