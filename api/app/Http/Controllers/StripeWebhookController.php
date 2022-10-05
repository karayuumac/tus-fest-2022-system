<?php

namespace App\Http\Controllers;


use App\Models\Charge;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Cashier\Http\Controllers\WebhookController;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends WebhookController
{
  public function handlePaymentIntentSucceeded(Request $request)
  {
    $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
    try {
      $event = Webhook::constructEvent(
        $request->getContent(), $sig_header, config('app.stripe_endpoint_secret')
      );
    } catch (SignatureVerificationException $e) {
      return response()->json([], 400);
    }

    switch ($event->type) {
      case 'payment_intent.succeeded':
        $charge_model_id = $event->data->object->metadata->charge_model_id;
        $charge = Charge::find($charge_model_id);

        foreach ($charge->seats as $seat) {
          $seat->update([
            'ticket_token' => (string)Str::uuid(),
            'is_pending' => false
          ]);
        }
        $charge->update([
          'is_pending' => false
        ]);
        return response()->json([]);
      default:
        return response()->json([]);
    }
  }
}
