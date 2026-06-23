<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = \App\Models\Room::take(5)->get();
        
        foreach ($rooms as $room) {
            \App\Models\MaintenanceRequest::create([
                'room_id' => $room->id,
                'title' => 'Sample Issue for Room ' . $room->room_number,
                'description' => 'This is a sample maintenance request generated for testing.',
                'priority' => 'medium',
                'status' => 'pending',
            ]);
        }
    }
}
