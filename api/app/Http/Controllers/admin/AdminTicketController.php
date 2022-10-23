<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Reserve;
use App\Models\ReserveEntry;
use App\Models\Seat;
use App\Models\SeatEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
  public function scan($id, Request $request)
  {
    $request->validate([
      'token' => 'uuid|required',
    ]);

    $event = Event::find($id);
    if (!$event) {
      return response()->json([
        'message' => 'イベントが見つかりません.担当者に報告してください.'
      ], 400);
    }

    if ($event->isFree()) {
      $reserve = Reserve::where([
        'event_id' => $id,
        'ticket_token' => $request->token
      ])->first();

      if (!$reserve) {
        return response()->json([
          'message' => 'チケットが見つかりません.担当者に報告してください.'
        ], 400);
      }

      if ($reserve->has_used) {
        return response()->json([
          'message' => 'チケットはすでに利用されています.'
        ], 400);
      }

      ReserveEntry::create([
        'reserve_id' => $reserve->id,
        'entry_time' => Carbon::now()
      ]);

      return response()->json([
        'message' => '正常に入場処理が行われました.'
      ]);
    } else {
      $seat = Seat::whereRelation('charge', 'event_id', $id)
        ->where('ticket_token', $request->token)
        ->first();

      if (!$seat) {
        return response()->json([
          'message' => 'チケットが見つかりません.担当者に報告してください.'
        ], 400);
      }

      if ($seat->has_used) {
        return response()->json([
          'message' => 'チケットはすでに利用されています.'
        ], 400);
      }

      $seat->update([
        'has_used' => true
      ]);
      SeatEntry::create([
        'seat_id' => $seat->id,
        'entry_time' => Carbon::now()
      ]);

      return response()->json([
        'message' => '正常に入場処理が行われました.'
      ]);
    }
  }
}
