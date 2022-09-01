<?php

namespace Database\Factories;

use App\Consts\Status;
use App\Models\Event;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EventFactory extends Factory
{
  protected $model = Event::class;

  public function definition(): array
  {
    return [
      'name' => rtrim($this->faker->realText(10, 5), '。'),
      'application_start_date' => Carbon::now()->sub(CarbonInterval::days(15)),
      'due_date' => Carbon::now()->add(CarbonInterval::days(15)),
      'begin_date' => Carbon::now()->add(CarbonInterval::days(20)),
      'end_date' => Carbon::now()->add(CarbonInterval::days(30)),
      'price' => $this->faker->randomDigit() * 100,
      'status' => $this->faker->randomElement(Status::statuses),
      'visible' => true,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now(),
    ];
  }

  public function free(): EventFactory
  {
    return $this->state(function (array $attributes) {
      return [
        'price' => 0
      ];
    });
  }

  public function beforeApplication(): EventFactory
  {
    return $this->state(function (array $attributes) {
      return [
        'application_start_date' => Carbon::now()->add(CarbonInterval::days())
      ];
    });
  }

  public function afterApplication(): EventFactory
  {
    return $this->state(function (array $attributes) {
      return [
        'due_date' => Carbon::now()->sub(CarbonInterval::days(10))
      ];
    });
  }

  public function invisible(): EventFactory
  {
    return $this->state(function (array $attributes) {
      return [
        'visible' => false
      ];
    });
  }
}
