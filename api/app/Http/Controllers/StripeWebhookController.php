<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\WebhookController;
use Stripe\Event;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends WebhookController
{
  public function handlePaymentIntentSucceeded(Request $request)
  {
    $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
    $event = null;
    try {
      $event = Webhook::constructEvent(
        $request->getContent(), $sig_header, config('app.stripe_endpoint_secret')
      );
    } catch (SignatureVerificationException $e) {
      return response()->json([], 400);
    }

    switch ($event->type) {
      case 'payment_intent.succeeded':
        Log::debug($event->data->object->charges);
      default:
        return response()->json([], 200);
    }
  }
}
