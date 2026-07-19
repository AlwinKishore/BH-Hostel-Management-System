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
        // Drop foreign keys in hostellers
        Schema::table('hostellers', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
            $table->dropForeign(['year_id']);
        });

        // Drop foreign key in years
        Schema::table('years', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
        });

        // Rename tables
        Schema::rename('batches', 'academic_years');
        Schema::rename('years', 'batches');

        // Rename columns
        Schema::table('batches', function (Blueprint $table) {
            $table->renameColumn('batch_id', 'academic_year_id');
            $table->renameColumn('year_name', 'batch_name');
        });

        Schema::table('academic_years', function (Blueprint $table) {
            $table->renameColumn('batch_name', 'name');
        });

        Schema::table('hostellers', function (Blueprint $table) {
            $table->renameColumn('batch_id', 'academic_year_id');
            $table->renameColumn('year_id', 'batch_id');
        });

        // Add back foreign keys
        Schema::table('batches', function (Blueprint $table) {
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->nullOnDelete();
        });

        Schema::table('hostellers', function (Blueprint $table) {
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->nullOnDelete();
            $table->foreign('batch_id')->references('id')->on('batches')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys
        Schema::table('batches', function (Blueprint $table) {
            $table->dropForeign(['academic_year_id']);
        });

        Schema::table('hostellers', function (Blueprint $table) {
            $table->dropForeign(['academic_year_id']);
            $table->dropForeign(['batch_id']);
        });

        // Reverse column renames
        Schema::table('hostellers', function (Blueprint $table) {
            $table->renameColumn('batch_id', 'year_id');
            $table->renameColumn('academic_year_id', 'batch_id');
        });

        Schema::table('academic_years', function (Blueprint $table) {
            $table->renameColumn('name', 'batch_name');
        });

        Schema::table('batches', function (Blueprint $table) {
            $table->renameColumn('batch_name', 'year_name');
            $table->renameColumn('academic_year_id', 'batch_id');
        });

        // Reverse table renames
        Schema::rename('batches', 'years');
        Schema::rename('academic_years', 'batches');

        // Add back old foreign keys
        Schema::table('years', function (Blueprint $table) {
            $table->foreign('batch_id')->references('id')->on('batches')->nullOnDelete();
        });

        Schema::table('hostellers', function (Blueprint $table) {
            $table->foreign('batch_id')->references('id')->on('batches')->nullOnDelete();
            $table->foreign('year_id')->references('id')->on('years')->nullOnDelete();
        });
    }
};
