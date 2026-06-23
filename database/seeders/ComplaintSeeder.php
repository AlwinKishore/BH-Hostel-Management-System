<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $student = \App\Models\Student::first();
        
        if ($student) {
            \App\Models\Complaint::create([
                'student_id' => $student->id,
                'category' => 'Food',
                'title' => 'Canteen food quality',
                'description' => 'The food quality has been declining lately.',
                'status' => 'pending',
            ]);
        }
    }
}
