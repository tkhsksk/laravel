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
        Schema::create('corps', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('名称')->unique();
            $table->string('kana')->comment('カナ');
            $table->string('cto')->comment('代表');
            $table->string('corp_mynumber',13)->comment('法人マイナンバー');
            $table->string('capital_stock')->comment('資本金');

            $table->string('status',1)->comment('状態')->default('E');
            $table->longText('note')->comment('メモ')->nullable();

            $table->date('establishmented_at')->comment('設立日');
            $table->timestamps();
        });

        Schema::create('location', function (Blueprint $table) {
            $table->id();
            $table->foreignId('corp_id')->comment('企業')->constrained('corps');

            $table->string('name')->comment('名称')->unique();
            $table->string('post',8)->comment('郵便番号');
            $table->string('address')->comment('住所');
            $table->string('phone',14)->comment('電話番号');
            $table->decimal('width', 6, 3)->comment('平米数')->nullable();
            $table->decimal('age', 6, 3)->comment('築年数')->nullable();

            $table->string('nearest_station')->comment('最寄駅');
            $table->string('other_stations')->comment('他近くの駅')->nullable();
            $table->decimal('rent', 10, 0)->comment('家賃')->nullable();
            $table->longText('note')->comment('メモ')->nullable();

            $table->date('contracted_at')->comment('契約日');
            $table->date('occupancy_at')->comment('入居日');
            $table->date('leaving_at')->comment('退去日')->nullable();
            $table->string('payment_date')->comment('家賃引落日')->nullable();

            $table->string('status',1)->comment('入居状態')->default('U');

            $table->string('employment_insurance_number',11)->comment('雇用保険適用事業所番号');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corps');
        Schema::dropIfExists('location');
    }
};
