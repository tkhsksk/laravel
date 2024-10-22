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
        Schema::create('user_admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->comment('ユーザーid')->constrained('users');

            $table->foreignId('employment_id')->comment('雇用形態')->nullable()->constrained('employments');
            $table->string('role')->comment('権限')->default('B');
            $table->string('engineer_role')->comment(' エンジニア権限')->default('D');
            $table->string('status',1)->comment('ユーザー状態')->default('E');

            $table->foreignId('department_id')->comment('部署')->nullable()->constrained('departments');
            $table->string('title')->comment('肩書')->nullable();
            $table->string('code')->comment('従業員コード')->nullable();
            $table->string('position')->comment('役職')->nullable();
            $table->date('employed_at')->comment('入社日')->nullable();
            $table->date('started_at')->comment('初回出社日')->nullable();
            $table->date('retiremented_at')->comment('退職日')->nullable();
            $table->date('ended_at')->comment('最終出社日')->nullable();

            $table->string('filing_status')->comment('税表区分')->nullable();
            $table->string('insurance_social_status')->comment('社会保険加入')->nullable();
            $table->string('insurance_employment_status')->comment('雇用保険加入')->nullable();
            $table->string('insurance_employment_number')->comment('雇用保険被保険者番号')->nullable();

            $table->string('mm_name')->comment('Mattermostユーザー名')->unique()->nullable();
            $table->text('mm_pass')->comment('Mattermostパスワード')->nullable();
            $table->string('google_account')->comment('googleアカウント')->nullable();
            $table->text('google_account_pass')->comment('googleアカウントパスワード')->nullable();
            $table->string('win_device_name')->comment('デバイス名')->nullable();
            $table->string('ms_account')->comment('microsoftアカウント')->nullable();
            $table->text('ms_account_password')->comment('microsoftパスワード')->nullable();
            $table->string('apple_id')->comment('AppleID')->nullable();
            $table->text('apple_pass')->comment('AppleIDパスワード')->nullable();
            $table->string('mac_name')->comment('macフルネーム')->nullable();
            $table->string('mac_account_name')->comment('macアカウント名')->nullable();
            $table->text('mac_account_pass')->comment('macアカウントパスワード')->nullable();
            $table->string('pin',4)->comment('PINコード')->nullable();

            $table->longText('note')->comment('管理者用メモ')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_admin');
    }
};
