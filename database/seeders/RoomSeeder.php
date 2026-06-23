<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buildings = \App\Models\Building::all();

        foreach ($buildings as $building) {
            for ($i = 1; $i <= 5; $i++) {
                \App\Models\Room::create([
                    'building_id' => $building->id,
                    'room_number' => $building->id . '0' . $i,
                    'floor' => rand(0, $building->total_floors),
                    'capacity' => rand(1, 4),
                    'type' => ['single', 'double', 'triple', 'dormitory'][rand(0, 3)],
                    'status' => 'vacant',
                ]);
            }
        }
    }
}
