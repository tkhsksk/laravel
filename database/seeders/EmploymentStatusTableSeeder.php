<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmploymentStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employments')->delete();

        DB::table('employments')->insert([
            [
                'name'       => '正社員',
                'note'       => '正規雇用の方',
                'status'     => 'E',
                'created_at' => now(),
            ],
            [
                'name'       => 'パート',
                'note'       => '非正規雇用雇用の方',
                'status'     => 'E',
                'created_at' => now(),
            ]
        ]);
    }
}
