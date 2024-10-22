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
        Schema::create('employments', function (Blueprint $table) {
            $table->id()->increments();
            $table->string('name')->comment('名称')->unique();
            $table->longText('note')->comment('メモ')->nullable();
            $table->string('status',1)->comment('状態')->default('D');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employment_status');
    }
};
