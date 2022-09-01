<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Consts\Status;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // \App\Models\User::factory(10)->create();

    User::factory()->create([
      'email' => 'test@example.com',
      'password' => Hash::make('password')
    ]);

    /*Event::factory()->beforeApplication()->free()->create();
    Event::factory()->free()->create();
    Event::factory()->afterApplication()->create();
    Event::factory()->invisible()->create();*/

    /* Event::create([
      'name' => '理大祭１日目',
      'application_start_date' => Carbon::now()->sub(CarbonInterval::days(10))
        ->setHours(0)
        ->setMinutes(0),
      'due_date' => Carbon::create(2022, 11, 25, 23, 59, 00),
      'begin_date' => Carbon::create(2022, 11, 26, 10, 00, 00),
      'end_date' => Carbon::create(2022, 11, 26, 17, 00, 00),
      'price' => 0,
      'status' => Status::LOTTERY_APPLICATIONS,
      'visible' => 1
    ]);

    Event::create([
      'name' => '理大祭２日目',
      'application_start_date' => Carbon::now()->add(CarbonInterval::days(10))
        ->setHours(0)
        ->setMinutes(0),
      'due_date' => Carbon::create(2022, 11, 26, 23, 59, 00),
      'begin_date' => Carbon::create(2022, 11, 27, 10, 00, 00),
      'end_date' => Carbon::create(2022, 11, 27, 17, 00, 00),
      'price' => 0,
      'status' => Status::LOTTERY_APPLICATIONS,
      'visible' => 1
    ]);

    Event::create([
      'name' => '芸能人企画',
      'application_start_date' => Carbon::now()->sub(CarbonInterval::days(10))
        ->setHours(0)
        ->setMinutes(0),
      'due_date' => Carbon::create(2022, 11, 20, 23, 59, 00),
      'begin_date' => Carbon::create(2022, 11, 27, 13, 00, 00),
      'end_date' => Carbon::create(2022, 11, 27, 14, 00, 00),
      'price' => 1500,
      'status' => Status::LOTTERY_APPLICATIONS,
      'visible' => 1
    ]); */
    $this->call([
      EventSeeder::class
    ]);
  }
}
