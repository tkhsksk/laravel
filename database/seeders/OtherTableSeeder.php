<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OtherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shifts')->delete();
        DB::table('site_servers')->delete();
        DB::table('site_dbs')->delete();
        DB::table('sites')->delete();
        
        DB::table('shifts')->insert([
            [
                'register_id'       => 3,
                'charger_id'        => 1,
                'preferred_date'    => '2024-01-01',
                'preferred_hr_st'   => 9,
                'preferred_min_st'  => 00,
                'preferred_hr_end'  => 15,
                'preferred_min_end' => 00,
                'created_at'        => now(),
            ]
        ]);

        DB::table('site_servers')->insert([
            [
                'name'        => 'AWS',
                'plan'        => 'nano',
                'url'         => 'https://console.aws.amazon.com/console/home?region=us-east-1',
                'login_id'    => 'login',
                'login_pass'  => encrypt('hoge'),
                'created_at'  => now(),
            ]
        ]);

        DB::table('site_dbs')->insert([
            [
                'server_id'  => 1,
                'host'       => 'cilcle-shop-mysql.cdykb3psgmzn.us-east-1.rds.amazonaws.com',
                'user'       => 'admin',
                'pass'       => encrypt('hoge'),
                'phpmyadmin' => 'https://phpmyadmin.cilcle.shop/',
                'created_at' => now(),
            ]
        ]);

        DB::table('sites')->insert([
            [
                'name'           => '食べログ',
                'register_id'    => 1,
                'server_id'      => 1,
                'domain_site_id' => 1,
                'url'            => 'https://qiita.com/Otake_M/items/3c761e1a5e65b04c6c0e',
                'created_at'     => now(),
            ],
            [
                'name'           => '',
                'register_id'    => 1,
                'server_id'      => 1,
                'domain_site_id' => 1,
                'url'            => 'https://pay.portiamock.work/',
                'created_at'     => now(),
            ]
        ]);

        DB::table('notifications')->insert([
            [
                'register_id'   => 1,
                'title'         => 'ハロウィンパーティー開催のお知らせ',
                'note'          => '例年通りハロウィンパーティーを開催します！🎃',
                'created_at'    => now(),
            ],
            [
                'register_id'   => 1,
                'title'         => '会社の夏休みが確定しました！🍧',
                'note'          => '今年は8/24〜9/22を予定しています！楽しみですね！',
                'created_at'    => now(),
            ],
            [
                'register_id'   => 1,
                'title'         => '社員のみの大切なお知らせ',
                'note'          => 'この記事は、権限が管理者以上の人にしか見えていないはずです',
                'created_at'    => now(),
            ]
        ]);

        DB::table('task_categories')->insert([
            [
                'name'       => '購入のお願い',
                'note'       => '備品や飲料の購入についての依頼など',
                'created_at' => now(),
            ],
            [
                'name'       => '教えてほしい',
                'note'       => '教えてほしい',
                'created_at' => now(),
            ]
        ]);

        DB::table('tasks')->insert([
            [
                'register_id'  => 1,
                'charger_id'   => 2,
                'title'        => 'お茶の購入お願いします',
                'created_at'   => now(),
                'category_id'  => 1,
                'status'       => 'N'
            ],
            [
                'register_id'  => 3,
                'charger_id'   => 1,
                'title'        => 'プログラムを教えてください',
                'created_at'   => now(),
                'category_id'  => 2,
                'status'       => 'P'
            ],
            [
                'register_id'  => 3,
                'charger_id'   => 2,
                'title'        => 'スムージ、味はざくろがいいです',
                'created_at'   => now(),
                'category_id'  => 1,
                'status'       => 'E'
            ]
        ]);

        DB::table('manuals')->insert([
            [
                'register_id'   => 1,
                'title'         => 'ポストの開け方',
                'note'          => 'ビル内部のポスト→0→0←9',
                'updatable_ids' => '2,3',
                'created_at'    => now(),
            ]
        ]);

        DB::table('faqs')->insert([
            [
                'register_id'   => 1,
                'question'      => 'どうすれば1Fのポストは開けられますか',
                'answer'        => '→0→0←9と回して下さい',
                'created_at'    => now(),
            ]
        ]);

        DB::table('orders')->insert([
            [
                'register_id'  => 1,
                'charger_id'   => 2,
                'product_name' => 'お茶',
                'created_at'   => now(),
                'status'       => 'N'
            ],
            [
                'register_id'  => 3,
                'charger_id'   => 1,
                'product_name' => 'ノート',
                'created_at'   => now(),
                'status'       => 'P'
            ],
            [
                'register_id'  => 3,
                'charger_id'   => 2,
                'product_name' => 'スムージ(ざくろ味)',
                'created_at'   => now(),
                'status'       => 'E'
            ]
        ]);

        DB::table('favorites')->insert([
            [
                'register_id'   => 1,
                'contents_id'   => 1,
                'type'          => 'M',
                'created_at'    => now(),
            ]
        ]);

        DB::table('notes')->insert([
            [
                'register_id' => 1,
                'note'        => '<p>test</p>',
                'created_at'  => now(),
            ]
        ]);

        DB::table('configs')->insert([
            [
                'site_name' => 'ララワークス',
                'mm_url'    => 'https://mm.portia.co.jp/api/v4/posts',
            ]
        ]);
    }
}
