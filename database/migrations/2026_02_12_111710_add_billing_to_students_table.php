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
        Schema::table('students', function (Blueprint $table) {
            $table->decimal('total_bill', 10, 2)->default(0)->after('room_id');
            $table->decimal('paid_amount', 10, 2)->default(0)->after('total_bill');
            $table->string('payment_status')->default('due')->after('paid_amount'); // due, partially_paid, paid
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['total_bill', 'paid_amount', 'payment_status']);
        });
    }
};
