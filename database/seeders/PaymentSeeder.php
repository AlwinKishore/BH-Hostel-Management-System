<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = \App\Models\Student::all();
        
        foreach ($students as $student) {
            \App\Models\Payment::create([
                'student_id' => $student->id,
                'amount' => 500.00,
                'payment_date' => now()->subDays(rand(1, 30)),
                'payment_method' => 'Cash',
                'receipt_number' => 'REC-' . strtoupper(uniqid()),
                'status' => 'paid',
            ]);
        }
    }
}
