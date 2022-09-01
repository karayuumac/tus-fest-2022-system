<?php

use App\Consts\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('events', function (Blueprint $table) {
      $table->id();

      $table->string('name');
      $table->dateTime('application_start_date');
      $table->dateTime('due_date');

      $table->dateTime('begin_date');
      $table->dateTime('end_date');

      $table->integer('price');

      $table->enum('status', Status::statuses);
      $table->boolean('visible')->default(false);

      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('events');
  }
};
