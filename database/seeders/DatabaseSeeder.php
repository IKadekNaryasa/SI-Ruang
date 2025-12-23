<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Bidang;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $bidangId = Str::uuid()->toString();
        $bidangId2 = Str::uuid()->toString();
        Bidang::create(
            [
                'id' => $bidangId,
                'code' => 'BID-III',
                'name' => 'Bidang Pengembangan Budaya Politik',
            ]
        );

        Bidang::create(
            [
                'id' => $bidangId2,
                'code' => 'KESBANGPOL',
                'name' => 'Badan Kesatuan Bangsa dan Politik Kabupaten Buleleng',
            ]
        );

        User::create([
            'id' => Str::uuid()->toString(),
            'name' => 'Admin Rapatin Kesbangpol',
            'email' => 'admin@siruang.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'bidang_id' => $bidangId2,
        ]);
        User::create([
            'id' => Str::uuid()->toString(),
            'name' => 'Operator Rapatin Bidang 3',
            'email' => 'siruang.bidang3@siruang.com',
            'password' => Hash::make('12345678'),
            'bidang_id' => $bidangId,
        ]);
    }
}
