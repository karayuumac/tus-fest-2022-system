<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('charges', function (Blueprint $table) {
      $table->id();

      // ユーザ
      $table->unsignedBigInteger('reserved_user_id');
      $table->foreign('reserved_user_id')->references('id')->on('users');

      // イベント
      $table->unsignedBigInteger('event_id');
      $table->foreign('event_id')->references('id')->on('events');

      // 決済識別子
      $table->uuid('charge_id');

      // 決済待ちか
      $table->boolean('is_pending')->default(true);

      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('charges');
  }
};
