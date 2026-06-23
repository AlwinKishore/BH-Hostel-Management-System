<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FurnitureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = \App\Models\Room::all();

        foreach ($rooms as $room) {
            // Add a Bed to each room
            \App\Models\Furniture::create([
                'name' => 'Single Bed Frame',
                'type' => 'Bed',
                'code' => 'BED-' . $room->id . '-' . rand(100, 999),
                'room_id' => $room->id,
                'condition' => 'good',
                'status' => 'assigned',
            ]);

            // Add a Table to some rooms
            if (rand(0, 1) == 1) {
                \App\Models\Furniture::create([
                    'name' => 'Study Table',
                    'type' => 'Table',
                    'code' => 'TBL-' . $room->id . '-' . rand(100, 999),
                    'room_id' => $room->id,
                    'condition' => 'good',
                    'status' => 'assigned',
                ]);
            }
        }
    }
}
