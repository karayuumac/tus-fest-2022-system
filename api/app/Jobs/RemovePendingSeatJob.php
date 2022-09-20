<?php

namespace App\Jobs;

use App\Models\Charge;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemovePendingSeatJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public function __construct(private Charge $charge)
  {
  }

  public function handle()
  {
    // 予約状態が確定していたら無視する.
    if (!$this->charge->is_pending) {
      return;
    }
    $seats = $this->charge->seats;

    foreach ($seats as $seat) {
      $seat->delete();
    }
    $this->charge->delete();
  }
}
