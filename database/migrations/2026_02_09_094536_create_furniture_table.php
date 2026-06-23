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
        Schema::create('furniture', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // Bed, Table, Chair, Cupboard
            $table->string('code')->unique(); // Unique Asset Code
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('condition', ['new', 'good', 'damaged', 'repairable'])->default('new');
            $table->enum('status', ['available', 'assigned', 'broken', 'maintenance'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('furniture');
    }
};
