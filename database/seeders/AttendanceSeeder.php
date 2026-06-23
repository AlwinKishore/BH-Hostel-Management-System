<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = \App\Models\Student::where('status', 'active')->get();
        $date = date('Y-m-d');

        foreach ($students as $student) {
            \App\Models\Attendance::create([
                'student_id' => $student->id,
                'date' => $date,
                'status' => 'present',
                'notes' => 'Bulk seeded',
            ]);
        }
    }
}
