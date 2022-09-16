<?php

namespace Database\Seeders;

use App\Consts\Status;
use App\Models\Event;
use Carbon\CarbonInterval;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EventSeeder extends Seeder
{
  public function run()
  {
    Event::create([
      'name' => '予約前',
      'application_start_date' => Carbon::now()->add(CarbonInterval::days(10))
        ->setHours(0)
        ->setMinutes(0),
      'due_date' => Carbon::create(2022, 11, 26, 23, 59, 00),
      'begin_date' => Carbon::create(2022, 11, 27, 10, 00, 00),
      'end_date' => Carbon::create(2022, 11, 27, 17, 00, 00),
      'price' => 0,
      'status' => Status::LOTTERY_APPLICATIONS,
      'visible' => 1,
      'max_reservation_count' => 2,
    ]);

    Event::create([
      'name' => '予約受付中',
      'application_start_date' => Carbon::now()->sub(CarbonInterval::days(10))
        ->setHours(0)
        ->setMinutes(0),
      'due_date' => Carbon::create(2022, 11, 26, 23, 59, 00),
      'begin_date' => Carbon::create(2022, 11, 27, 10, 00, 00),
      'end_date' => Carbon::create(2022, 11, 27, 17, 00, 00),
      'price' => 0,
      'status' => Status::LOTTERY_APPLICATIONS,
      'visible' => 1,
      'max_reservation_count' => 2,
    ]);

    Event::create([
      'name' => '販売受付中',
      'application_start_date' => Carbon::now()->sub(CarbonInterval::days(10))
        ->setHours(0)
        ->setMinutes(0),
      'due_date' => Carbon::create(2022, 11, 26, 23, 59, 00),
      'begin_date' => Carbon::create(2022, 11, 27, 10, 00, 00),
      'end_date' => Carbon::create(2022, 11, 27, 17, 00, 00),
      'price' => 1500,
      'status' => Status::LOTTERY_APPLICATIONS,
      'visible' => 1
    ]);

    Event::create([
      'name' => '予約終了',
      'application_start_date' => Carbon::now()->sub(CarbonInterval::days(10))
        ->setHours(0)
        ->setMinutes(0),
      'due_date' => Carbon::now()->sub(CarbonInterval::days(5))
        ->setHours(0)
        ->setMinutes(0),
      'begin_date' => Carbon::create(2022, 11, 27, 10, 00, 00),
      'end_date' => Carbon::create(2022, 11, 27, 17, 00, 00),
      'price' => 0,
      'status' => Status::LOTTERY_APPLICATIONS,
      'visible' => 1
    ]);

    Event::create([
      'name' => '販売終了',
      'application_start_date' => Carbon::now()->sub(CarbonInterval::days(10))
        ->setHours(0)
        ->setMinutes(0),
      'due_date' => Carbon::now()->sub(CarbonInterval::days(5))
        ->setHours(0)
        ->setMinutes(0),
      'begin_date' => Carbon::create(2022, 11, 27, 10, 00, 00),
      'end_date' => Carbon::create(2022, 11, 27, 17, 00, 00),
      'price' => 1500,
      'status' => Status::LOTTERY_APPLICATIONS,
      'visible' => 1
    ]);

    Event::create([
      'name' => '抽選中',
      'application_start_date' => Carbon::now()->sub(CarbonInterval::days(10))
        ->setHours(0)
        ->setMinutes(0),
      'due_date' => Carbon::now()->sub(CarbonInterval::days(5))
        ->setHours(0)
        ->setMinutes(0),
      'begin_date' => Carbon::create(2022, 11, 27, 10, 00, 00),
      'end_date' => Carbon::create(2022, 11, 27, 17, 00, 00),
      'price' => 1500,
      'status' => Status::PENDING,
      'visible' => 1
    ]);

    Event::create([
      'name' => '抽選完了',
      'application_start_date' => Carbon::now()->sub(CarbonInterval::days(10))
        ->setHours(0)
        ->setMinutes(0),
      'due_date' => Carbon::now()->sub(CarbonInterval::days(5))
        ->setHours(0)
        ->setMinutes(0),
      'begin_date' => Carbon::create(2022, 11, 27, 10, 00, 00),
      'end_date' => Carbon::create(2022, 11, 27, 17, 00, 00),
      'price' => 1500,
      'status' => Status::DONE,
      'visible' => 1
    ]);
  }
}
