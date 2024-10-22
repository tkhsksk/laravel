<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_admins')->delete();
        
        DB::table('user_admins')->insert([
            [
                'user_id'             => 1,
                'employment_id'       => 1,
                'department_id'       => 1,
                'role'                => 'M',
                'title'               => 'WEBエンジニア',
                'employed_at'         => '2016-04-01',
                'started_at'          => '2016-04-01',
                'mm_name'             => 'test_takahashi',
                'mm_pass'             => encrypt('hoge'),
                'google_account'      => 'hoge',
                'google_account_pass' => encrypt('hoge'),
                'pin'                 => '0318',
                'created_at'          => now(),
                'code'                => '000001',
            ],
            [
                'user_id'             => 2,
                'employment_id'       => 1,
                'department_id'       => 1,
                'role'                => 'A',
                'title'               => 'システムエンジニア',
                'employed_at'         => '2016-04-01',
                'started_at'          => '2016-04-01',
                'mm_name'             => 'test_kanri',
                'mm_pass'             => encrypt('hoge'),
                'google_account'      => 'hoge',
                'google_account_pass' => encrypt('hoge'),
                'pin'                 => '0116',
                'created_at'          => now(),
                'code'                => '000002',
            ],
            [
                'user_id'             => 3,
                'employment_id'       => 1,
                'department_id'       => 1,
                'role'                => 'B',
                'title'               => 'スーパーバイザー',
                'employed_at'         => '2016-04-01',
                'started_at'          => '2016-04-01',
                'mm_name'             => 'test_basic',
                'mm_pass'             => encrypt('hoge'),
                'google_account'      => 'hoge',
                'google_account_pass' => encrypt('hoge'),
                'pin'                 => '0827',
                'created_at'          => now(),
                'code'                => '000003',
            ],
        ]);
    }
}
