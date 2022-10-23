<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('reserve_entries', function (Blueprint $table) {
      $table->id();

      $table->unsignedBigInteger('reserve_id');
      $table->foreign('reserve_id')->references('id')
        ->on('reserves');

      // 入場時間
      $table->dateTime('entry_time');


      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('reserve_entries');
  }
};
