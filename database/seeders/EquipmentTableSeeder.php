<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('equipments')->delete();

        DB::table('equipments')->insert([
            [
                'admin_id'      => 1,
                'location_id'   => 1,
                'category'      => 'P',
                'number'        => 'A123456',
                'portia_number' => 'A123456',
                'purchased_at'  => '2024-01-01',
                'created_at'    => now(),
            ],
            [
                'admin_id'      => 1,
                'location_id'   => 1,
                'category'      => 'K',
                'number'        => 'K123456',
                'portia_number' => 'K123456',
                'purchased_at'  => '2024-01-01',
                'created_at'    => now(),
            ],
            [
                'admin_id'      => null,
                'location_id'   => 1,
                'category'      => 'L',
                'number'        => 'portia0001',
                'portia_number' => 'portia0001',
                'purchased_at'  => '2024-01-01',
                'created_at'    => now(),
            ]
        ]);
    }
}
