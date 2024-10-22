<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('corps')->delete();
        DB::table('location')->delete();

        DB::table('corps')->insert([
            [
                'name'                        => '株式会社test',
                'kana'                        => 'カブシキガイシャテスト',
                'cto'                         => '企業太郎',
                'capital_stock'               => 4000,
                'corp_mynumber'               => '1006543210987',
                'establishmented_at'          => '2016-02-22',
                'created_at'                  => now(),
            ]
        ]);

        DB::table('location')->insert([
            [
                'name'                        => '東京本社オフィス',
                'corp_id'                     => 1,
                'post'                        => '1010051',
                'phone'                       => '0311112222',
                'address'                     => '東京都千代田区神田神保町3-2 高橋ビル',
                'nearest_station'             => '神保町',
                'contracted_at'               => '2023-04-01',
                'occupancy_at'                => '2023-04-01',
                'employment_insurance_number' => '12345678901',
                'created_at'                  => now(),
            ],
            [
                'name'                        => '長岡オフィス',
                'corp_id'                     => 1,
                'post'                        => '9400062',
                'phone'                       => '0250000000',
                'address'                     => '新潟県長岡市大手通2-3-10 米百俵プレイス ミライエ長岡 西館 9階',
                'nearest_station'             => '長岡',
                'contracted_at'               => '2024-01-01',
                'occupancy_at'                => '2023-04-01',
                'employment_insurance_number' => '12345678901',
                'created_at'                  => now(),
            ]
        ]);
    }
}
