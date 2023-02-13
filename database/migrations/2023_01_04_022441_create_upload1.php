<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload1s', function (Blueprint $table) {
            $table->id();
            $table->string('レコードID')->nullable();
            $table->string('レコードタイプ')->nullable();
            $table->string('キャンペーンID')->nullable();
            $table->string('キャンペーン')->nullable();
            $table->string('キャンペーンの1日の予算')->nullable();
            $table->string('ポートフォリオID')->nullable();
            $table->string('キャンペーン開始日')->nullable();
            $table->string('キャンペーン終了日')->nullable();
            $table->string('キャンペーンターゲティングタイプ')->nullable();
            $table->string('広告グループ')->nullable();
            $table->string('入札額上限')->nullable();
            $table->string('キーワードまたは商品ターゲティング')->nullable();
            $table->string('商品ターゲティングID')->nullable();
            $table->string('マッチタイプ')->nullable();
            $table->string('SKU')->nullable();
            $table->string('キャンペーンステータス')->nullable();
            $table->string('広告グループステータス')->nullable();
            $table->string('ステータス')->nullable();
            $table->string('インプレッション')->nullable();
            $table->string('クリック')->nullable();
            $table->string('広告費')->nullable();
            $table->string('注文数')->nullable();
            $table->string('商品点数の合計')->nullable();
            $table->string('売上')->nullable();
            $table->string('ACOS')->nullable();
            $table->string('入札戦略')->nullable();
            $table->string('掲載枠タイプ')->nullable();
            $table->string('掲載枠による入札額の引き上げ')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload1s');
    }
};
