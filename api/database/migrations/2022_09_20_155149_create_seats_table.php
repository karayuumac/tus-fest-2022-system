<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('seats', function (Blueprint $table) {
      $table->id();

      // 列番号
      $table->integer('row');
      // 行番号
      $table->integer('col');
      // 仮予約か
      $table->boolean('is_pending');
      // 決済
      $table->unsignedBigInteger('charge_id');
      $table->foreign('charge_id')->references('id')->on('charges');
      // チケット表示用トークン
      $table->uuid('ticket_token')->nullable();
      // 譲渡しているかどうか
      $table->boolean('is_assigned')->default(false);
      // 使用したか
      $table->boolean('has_used')->default(false);

      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('seats');
  }
};
