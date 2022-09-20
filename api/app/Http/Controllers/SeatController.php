<?php

namespace App\Http\Controllers;

use App\Http\Requests\Seat\ReserveSeatRequest;
use App\Jobs\ExpireStripeSessionJob;
use App\Jobs\RemovePendingSeatJob;
use App\Models\Charge;
use App\Models\Event;
use App\Models\Seat;
use App\Resources\collection\SeatCollection;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\StripeClient;
use Stripe\Webhook;

class SeatController extends Controller
{
  public function reservedSeats(int $id)
  {
    $charges = Charge::with(['seats'])
      ->where('event_id', $id)
      ->get();
    $seats = [];

    foreach ($charges as $charge) {
      $seats = array_merge($seats, $charge->seats->toArray());
    }
    return new SeatCollection($seats);
  }

  public function reservedSeatsByUser(int $id)
  {
    $charges = Auth::user()
      ->charges()
      ->where('event_id', $id)
      ->pending()
      ->with(['seats'])
      ->get();
    $seats = [];

    foreach ($charges as $charge) {
      $seats = array_merge($seats, $charge->seats->toArray());
    }
    return new SeatCollection($seats);
  }

  public function reserveWithPending(int $id, ReserveSeatRequest $request)
  {
    $stripe = new StripeClient(config('app.stripe_secret_key'));
    $event = Event::find($id);

    if ($event->isFree()) {
      return response()->json(
        [
          'message' => '無料イベントの予約を行うことはできません.'
        ]
        , 400);
    }
    if (count(Auth::user()->charges()->pending()->get()) > 0) {
      return response()->json(
        [
          'message' => '既に座席の仮保持が行われています.'
        ]
        , 400);
    }

    $seats = $request->input('seats');
    $checkoutSession = null;

    try {
      DB::transaction(function () use ($id, $seats, &$checkoutSession, $stripe) {
        $chargeId = (string) Str::uuid();;
        $charge = Charge::create([
          'event_id' => $id,
          'reserved_user_id' => Auth::user()->id,
          'charge_id' => $chargeId,
          'is_pending' => true
        ]);

        foreach ($seats as $seat) {
          $row = $seat['row'];
          $col = $seat['col'];

          if (Seat::where([
              ['row', '=', $row],
              ['col', '=', $col]
            ])->count() !== 0) {
            throw new Exception();
          }

          Seat::create([
            'col' => $col,
            'row' => $row,
            'is_pending' => true,
            'charge_id' => $charge->id
          ]);
        }

        // Stripeの請求作成
        $checkoutSession = Session::create([
          'line_items' => [[
            'price' => 'price_1Lk1a2KSt4j2Xc6z372LOdGV', // TODO: change here!
            'quantity' => count($seats)
          ]],
          'mode' => 'payment',
          'success_url' => 'http://localhost/event/3/success?token='.$chargeId,
          'cancel_url' => 'http://localhost/event/'.$id
        ]);

        RemovePendingSeatJob::dispatch($charge)->delay(15 * 60);
      });
    } catch (Exception $e) {
      Log::warning($e->getMessage());

      // セッションを無効化
      $stripe->checkout->sessions->expire($checkoutSession->id);

      return response()->json([
        'message' => '指定された座席はすでに予約されています.'
      ], 400);
    }
    // 購入可能時間を15分に制限
    ExpireStripeSessionJob::dispatch($stripe, $checkoutSession->id)->delay(15 * 60);

    return response()->json([
      'redirect_to' => $checkoutSession->url
    ]);
  }

  public function releasePendingSeats(int $id)
  {
    $charges = Auth::user()
      ->charges()
      ->where('event_id', $id)
      ->pending()
      ->with(['seats'])
      ->get();

    foreach ($charges as $charge) {
      foreach ($charge->seats as $seat) {
        $seat->delete();
      }
      $charge->delete();
    }
    return response()->json([]);
  }

/*
  public function paymentSucceed(Request $request)
  {
    $event = null;
    try {
      $event = Webhook::constructEvent(
        $request->getContent(), $_SERVER['HTTP_STRIPE_SIGNATURE'], config('STRIPE_ENDPOINT_SECRET')
      );
    } catch (SignatureVerificationException $e) {
      return response()->json([], 400);
    }

    switch ($event->type) {
      case 'checkout.session.async_payment_succeeded':
        Log::debug($event);
      default:
    }
  }
*/

  public function validateToken(int $id, Request $request)
  {
    $request->validate([
      'token' => ['required', 'string']
    ]);

    $charge = Charge::where([
      'reserved_user_id' => Auth::user()->id,
      'event_id' => $id,
      'charge_id' => $request->get('token')
    ]);
    if (!$charge->exists()) {
      return response()->json([], 400);
    }

    foreach ($charge->first()->seats as $seat) {
      $seat->update([
        'ticket_token' => (string) Str::uuid(),
        'is_pending' => false
      ]);
    }
    $charge->update([
      'is_pending' => false
    ]);
    return response()->json([], 200);
  }
}