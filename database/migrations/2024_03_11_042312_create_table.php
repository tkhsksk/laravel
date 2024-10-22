<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();

            $table->string('first_kana')->comment('カナ姓')->nullable();
            $table->string('second_kana')->comment('カナ名')->nullable();
            $table->string('first_name')->comment('姓')->nullable();
            $table->string('second_name')->comment('名')->nullable();

            $table->string('gender',1)->comment('性別')->nullable();

            $table->date('birthday')->comment('誕生日')->nullable();
            $table->string('post',8)->comment('郵便番号')->nullable();
            $table->string('address')->comment('住所')->nullable();
            $table->string('phone',14)->comment('電話番号')->nullable();
            $table->string('spouse_status',1)->comment('配偶者')->nullable();
            $table->string('dependent',4)->comment('扶養人数')->nullable();

            $table->string('image')->comment('ユーザー画像')->nullable();
            
            $table->string('how_to_commute')->comment('通勤方法')->nullable();
            $table->string('nearest_station')->comment('最寄駅')->nullable();
            $table->string('nearest_station_corp')->comment('降車駅')->nullable();

            $table->string('emoji_mm')->comment('mattermost絵文字')->nullable();
            $table->string('adobe_account')->comment('アドビCCアカウント')->nullable();
            $table->string('adobe_pass')->comment('アドビCCパスワード')->nullable();

            $table->string('bank_name')->comment('銀行名')->nullable();
            $table->string('bank_number')->comment('銀行番号')->nullable();
            $table->string('bank_branch_name')->comment('支店名')->nullable();
            $table->string('bank_branch_number')->comment('支店番号')->nullable();
            $table->string('bank_account_status')->comment('口座種類　普通　当座')->nullable();
            $table->string('bank_account')->comment('口座番号')->nullable();
            $table->string('bank_account_name')->comment('口座名義人　漢字')->nullable();
            $table->string('bank_account_name_kana')->comment('口座名義人　カナ')->nullable();

            $table->longText('note')->comment('メモ')->nullable();

            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('signedin_at')->comment('最終ログイン')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
