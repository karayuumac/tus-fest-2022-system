<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('reserves', function (Blueprint $table) {
      $table->id();

      // イベント
      $table->unsignedBigInteger('event_id');
      $table->foreign('event_id')->references('id')->on('events');

      // 予約者
      $table->unsignedBigInteger('reserve_user_id');
      $table->foreign('reserve_user_id')->references('id')->on('events');

      // チケット表示用トークン
      $table->uuid('ticket_token');

      // 譲渡しているかどうか
      $table->boolean('is_assigned')->default(false);

      // 使用したかどうか
      $table->boolean('has_used')->default(false);

      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('reserves');
  }
};
