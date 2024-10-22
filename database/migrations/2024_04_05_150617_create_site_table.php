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
        Schema::create('site_servers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('plan')->nullable();

            $table->string('url');
            $table->string('login_id')->nullable();
            $table->string('login_pass')->nullable();

            $table->string('mail_receive')->nullable();
            $table->string('mail_send')->nullable();
            $table->longText('note')->nullable();

            $table->string('status',1)->comment('ステータス')->default('E');
            
            $table->timestamps();
        });
        Schema::create('site_dbs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_id')->nullable()->constrained('site_servers');
            $table->string('host');
            $table->string('user');
            $table->string('pass');
            $table->string('phpmyadmin');
            $table->string('basic_id')->nullable();
            $table->string('basic_pass')->nullable();

            $table->string('status',1)->comment('ステータス')->default('E');

            $table->longText('note')->nullable();

            $table->timestamps();
        });
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();

            $table->foreignId('register_id')->constrained('user_admins');
            $table->foreignId('server_id')->nullable()->constrained('site_servers');
            $table->foreignId('domain_site_id')->nullable()->constrained('sites');
            $table->foreignId('db_id')->nullable()->constrained('site_dbs');

            $table->string('url')->unique();
            $table->string('url_admin')->nullable();

            $table->string('basic_id')->nullable();
            $table->longText('basic_pass')->nullable();
            $table->longText('note')->nullable();
            $table->longText('git')->nullable();

            $table->string('status',1)->comment('ステータス')->default('E');

            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('register_id')->constrained('user_admins');
            $table->string('title');
            $table->longText('note')->nullable();
            
            $table->date('started_at')->comment('開始日')->nullable();
            $table->date('ended_at')->comment('終了日')->nullable();
            $table->string('started_hr_at',2)->comment('開始時間')->nullable();
            $table->string('started_min_at',2)->comment('開始分')->nullable();
            $table->string('ended_hr_at',2)->comment('終了時間')->nullable();
            $table->string('ended_min_at',2)->comment('終了分')->nullable();

            $table->string('role')->default('B');

            $table->string('status',1)->comment('ステータス')->default('D');

            $table->timestamps();
        });

        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('register_id')->constrained('user_admins');
            $table->foreignId('admin_id')->nullable()->constrained('user_admins');
            $table->foreignId('location_id')->nullable()->constrained('location');

            $table->string('name');
            $table->string('origin_name');
            $table->string('extension');
            $table->string('size');
            $table->string('url');
            $table->string('status',1)->comment('ステータス')->default('E');

            $table->timestamps();
        });

        Schema::create('task_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('note')->nullable();
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('register_id')->comment('登録者')->constrained('user_admins');
            $table->foreignId('charger_id')->comment('担当者')->constrained('user_admins');
            $table->string('title')->comment('タイトル');
            $table->longText('note')->nullable();
            $table->string('status',1)->comment('ステータス')->default('N');
            $table->date('preferred_date')->comment('希望日')->nullable();
            $table->string('preferred_hr',2)->comment('希望時間')->nullable();
            $table->string('preferred_min',2)->comment('希望分')->nullable();

            $table->foreignId('category_id')->constrained('task_categories');
            $table->timestamps();
        });

        Schema::create('manuals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('register_id')->constrained('user_admins');
            $table->foreignId('updater_id')->nullable()->constrained('user_admins');
            $table->string('title');
            $table->longText('note')->nullable();
            $table->string('updatable_ids')->nullable();
            $table->string('status',1)->comment('ステータス')->default('D');

            $table->string('role')->default('B');

            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('register_id')->constrained('user_admins');
            $table->foreignId('updater_id')->nullable()->constrained('user_admins');
            $table->string('question');
            $table->longText('answer');
            $table->string('updatable_ids')->nullable();
            $table->string('status',1)->comment('ステータス')->default('D');

            $table->string('role')->default('B');

            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('register_id')->comment('登録者')->constrained('user_admins');
            $table->foreignId('charger_id')->comment('担当者')->constrained('user_admins');
            $table->string('product_name')->comment('商品名');
            $table->longText('note')->nullable();
            $table->string('status',1)->comment('ステータス')->default('N');

            $table->datetime('purchase_at')->comment('購入日')->nullable();
            $table->datetime('arrival_at')->comment('到着日')->nullable();

            $table->timestamps();
        });

        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('register_id')->comment('登録者')->constrained('user_admins');
            $table->string('contents_id')->comment('コンテンツid');
            $table->string('type',1)->comment('コンテンツタイプ');

            $table->timestamps();
        });

        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('register_id')->comment('登録者')->constrained('user_admins');
            $table->string('title')->nullable();
            $table->longText('note');

            $table->timestamps();
        });

        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->comment('サイト名');
            $table->longText('corp_holiday')->comment('会社休業日')->nullable();
            $table->string('mm_status',1)->comment('mmステータス')->default('D');
            $table->string('mm_url')->comment('mmURL')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_dbs');
        Schema::dropIfExists('site_servers');
        Schema::dropIfExists('sites');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('files');
        Schema::dropIfExists('task_categories');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('manuals');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('notes');
        Schema::dropIfExists('configs');
    }
};
