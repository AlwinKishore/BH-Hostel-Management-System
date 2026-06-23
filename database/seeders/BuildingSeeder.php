<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Building::create([
            'name' => 'Main Block',
            'address' => '123 Hostel Street, North Campus',
            'total_floors' => 4,
            'total_rooms' => 40,
            'capacity' => 120,
            'status' => 'active',
        ]);

        \App\Models\Building::create([
            'name' => 'Girls Wing',
            'address' => '124 Hostel Street, North Campus',
            'total_floors' => 3,
            'total_rooms' => 30,
            'capacity' => 90,
            'status' => 'active',
        ]);

        \App\Models\Building::create([
            'name' => 'New annex',
            'address' => 'South Campus, Block 5',
            'total_floors' => 5,
            'total_rooms' => 50,
            'capacity' => 200,
            'status' => 'active',
        ]);
    }
}
