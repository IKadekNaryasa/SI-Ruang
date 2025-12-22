<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::create([
            'id' => Str::uuid()->toString(),
            'code' => "ROOM-01",
            'name' => 'Meeting Room Kesbangpol Buleleng',
            'status' => 'active'
        ]);
        Room::create([
            'id' => Str::uuid()->toString(),
            'code' => "ROOM-02",
            'name' => 'Meeting Room 2 Kesbangpol Buleleng',
            'status' => 'active'
        ]);
    }
}
