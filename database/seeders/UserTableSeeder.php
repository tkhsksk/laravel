<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();
        
        DB::table('users')->insert([
            [
                'name'        => 'マスター',
                'first_name'  => '髙橋',
                'second_name' => '佳佑',
                'email'       => 'tkhsksk0318@gmail.com',
                'birthday'    => '1990-03-18',
                'phone'       => '08031775789',
                'post'        => '1510053',
                'address'     => '東京都渋谷区代々木1-25-10-303',
                'password'    => bcrypt('password'),
                'created_at'  => now(),
            ],
            [
                'name'        => 'カンリ',
                'first_name'  => '管理',
                'second_name' => '太郎',
                'email'       => 'tkhsksk0318+master@gmail.com',
                'birthday'    => null,
                'phone'       => null,
                'post'        => null,
                'address'     => null,
                'password'    => bcrypt('password'),
                'created_at'  => now(),
            ],
            [
                'name'        => 'ベーシック',
                'first_name'  => '通常',
                'second_name' => '花子',
                'email'       => 'tkhsksk0318+basic@gmail.com',
                'birthday'    => null,
                'phone'       => null,
                'post'        => null,
                'address'     => null,
                'password'    => bcrypt('password'),
                'created_at'  => now(),
            ]
        ]);
    }
}
