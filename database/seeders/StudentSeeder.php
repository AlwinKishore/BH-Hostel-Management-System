<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = \App\Models\Room::all();

        foreach ($rooms->take(5) as $room) {
            \App\Models\Student::create([
                'name' => 'John Doe ' . $room->id,
                'email' => 'student' . $room->id . '@example.com',
                'phone' => '987654321' . $room->id,
                'id_proof_number' => 'ABC12345' . $room->id,
                'id_proof_type' => 'Aadhaar',
                'room_id' => $room->id,
                'joining_date' => now()->subMonths(2),
                'status' => 'active',
            ]);
        }
    }
}
