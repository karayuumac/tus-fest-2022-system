<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Stripe\StripeClient;

class ExpireStripeSessionJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public function __construct(private StripeClient $stripe, private string $sessionId)
  {
  }

  public function handle()
  {
    $this->stripe->checkout->sessions->expire(
      $this->sessionId
    );
  }
}
