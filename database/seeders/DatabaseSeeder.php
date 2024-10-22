<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// php artisan db:seedでcall内のクラスメソッドが実行される

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            EmploymentStatusTableSeeder::class,
            LocationTableSeeder::class,
            DepartmentTableSeeder::class,
            UserTableSeeder::class,
            UserAdminTableSeeder::class,
            EquipmentTableSeeder::class,
            OtherTableSeeder::class,
        ]);
    }
}
