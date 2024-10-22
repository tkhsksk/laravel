<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->delete();

        DB::table('departments')->insert([
            [
                'location_id'   => 1,
                'name'          => 'WEBシステム事業部',
                'created_at'    => now(),
            ],
            [
                'location_id'   => 1,
                'name'          => 'カスタマーサクセス事業部',
                'created_at'    => now(),
            ]
        ]);
    }
}
