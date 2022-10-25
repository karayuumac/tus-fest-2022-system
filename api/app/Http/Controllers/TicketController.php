<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\Reserve;
use App\Models\Seat;
use App\Resources\EventResource;
use Auth;
use Exception;

class TicketController extends Controller
{
  public function index()
  {
    $response = [];
    /** @var Reserve[] $reserves */
    $reserves = Auth::user()->reserves;
    foreach ($reserves as $reserve) {
      $response[] = [
        'id' => 'F-' . $reserve->id,
        'type' => 'reserve',
        'event' => new EventResource($reserve->event),
        'ticket_token' => $reserve->ticket_token,
        'is_assigned' => $reserve->is_assigned
      ];
    }

    /** @var Charge[] $charges */
    $charges = Auth::user()->charges;
    foreach ($charges as $charge) {
      foreach ($charge->seats as $seat) {
        $response[] = [
          'id' => 'S-' . $seat->id,
          'type' => 'seat',
          'event' => new EventResource($charge->event),
          'ticket_token' => $seat->ticket_token,
          'is_assigned' => $seat->is_assigned
        ];
      }
    }

    return response()->json(['data' => $response]);
  }

  private function findOrFail(string $id)
  {
    $array = explode('-', $id);
    if (count($array) != 2 || !($array[0] === 'F' || $array[0] === 'S') || !is_numeric($array[1])) {
      throw new Exception("URLの形式が正しくありません.");
    }
    if ($array[0] === 'F') {
      // 無料イベント
      $reserve = Reserve::find($array[1]);
      if (!$reserve->exists()) {
        throw new Exception("予約データが存在しません.");
      } else if ($reserve->reserve_user_id != Auth::id()) {
        throw new Exception("権限がありません");
      }

      return $reserve;
    } else if ($array[0] === 'S') {
      // 有料チケット
      $seat = Seat::find($array[1]);
      if (!$seat->exists()) {
        throw new Exception("予約データが存在しません.");
      } else if ($seat->charge->reserved_user_id != Auth::id()) {
        throw new Exception("権限がありません");
      }

      return $seat;
    }
  }

  public function send(string $id)
  {
    try {
      $entity = $this->findOrFail($id);
    } catch (Exception $e) {
      return response()->json([
        'message' => $e->getMessage()
      ], 400);
    }
    $entity->update([
      'is_assigned' => true
    ]);

    return response()->json([
      'url' => config('app.frontend_url') . '/ticket/' . $entity->ticket_token
    ]);
  }

  public function stopSharing(string $id)
  {
    try {
      $entity = $this->findOrFail($id);
    } catch (Exception $e) {
      return response()->json([
        'message' => $e->getMessage()
      ], 400);
    }
    $entity->update([
      'is_assigned' => false
    ]);

    return response()->json();
  }

  public function show(string $token)
  {
    $eloquent =
      Reserve::where('ticket_token', $token)->first() ? Reserve::where('ticket_token', $token)->first() :
      Seat::where('ticket_token', $token)->first();
    if (!$eloquent) {
      return response()->json([
        'message' => '正しいチケットトークンを入力してください.'
      ], 400);
    }

    if (Auth::guest() && !$eloquent->is_assigned) {
      return response()->json([
        'message' => 'チケットは譲渡されていません.'
      ], 400);
    }
    if (Auth::check() && $eloquent->is_assigned) {
      return response()->json([
        'message' => 'チケットは既に譲渡済みです.'
      ], 400);
    }

    return response()->json([
      'event' => new EventResource($eloquent->event),
      'token' => $eloquent->ticket_token,
      'row' => !$eloquent->event->isFree() ? $eloquent->row : null,
      'col' => !$eloquent->event->isFree() ? $eloquent->col : null
    ]);
  }
}
