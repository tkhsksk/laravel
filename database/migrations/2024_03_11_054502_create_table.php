<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// php artisan migrate:freshでデータベース作成とデータ削除が実行

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->comment('利用ユーザーid')->nullable()->constrained('user_admins');
            $table->foreignId('location_id')->comment('所在地id')->constrained('location');

            $table->string('category')->comment('カテゴリー');
            $table->string('number')->comment('型番')->unique();
            $table->decimal('price', 12, 2)->comment('購入価格')->nullable();
            $table->string('os')->comment('os')->nullable();
            $table->string('os_version')->comment('バージョン')->nullable();
            $table->integer('display_size')->comment('ディスプレイサイズ')->nullable();
            $table->string('memory')->comment('メモリ')->nullable();
            $table->string('storage')->comment('ストレージ')->nullable();
            $table->string('processor')->comment('プロセッサ')->nullable();
            $table->string('portia_number')->comment('管理番号')->unique();
            
            $table->longText('note')->comment('メモ')->nullable();

            $table->date('used_at')->comment('利用開始日')->nullable();
            $table->date('purchased_at')->comment('購入日');
            $table->string('status',1)->comment('機材状態')->default('N');
            $table->timestamps();
        });

        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('register_id')->comment('登録ユーザーid')->constrained('user_admins');
            $table->foreignId('charger_id')->comment('承認ユーザーid')->constrained('user_admins');

            $table->date('preferred_date')->comment('希望日');
            $table->string('preferred_hr_st',2)->comment('希望開始時間');
            $table->string('preferred_min_st',2)->comment('希望開始分');
            $table->string('preferred_hr_end',2)->comment('希望終了時間');
            $table->string('preferred_min_end',2)->comment('希望終了分');
            
            $table->string('holiday',1)->comment('有給希望')->default('D');
            $table->string('status',1)->comment('ステータス')->default('N');
            $table->longText('note')->comment('メモ')->nullable();
            $table->timestamps();

            $table->index(['register_id', 'charger_id', 'preferred_date', 'status'], 'shifts_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
        Schema::dropIfExists('shifts');
        Schema::dropIndex('shifts_index');
    }
};
