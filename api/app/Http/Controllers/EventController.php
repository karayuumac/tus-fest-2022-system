<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\ReserveRequest;
use App\Models\Event;
use App\Models\Reserve;
use App\Resources\collection\EventCollection;
use App\Resources\EventResource;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
  public function index()
  {
    return new EventCollection(Event::where('visible', '=', true)->get());
  }

  public function get(int $id)
  {
    return new EventResource(Event::find($id));
  }

  public function reserve(int $id, ReserveRequest $request)
  {
    $event = Event::find($id);
    $user = Auth::user();

    if ($request->input('number_of_people') > $event->max_reservation_count)
    {
      return response()
        ->json(['message' => '予約は'.$event->max_reservation_count.'枚以下にしてください.'], 400);
    }
    if ($user->alreadyReserved())
    {
      return response()
        ->json(['message' => 'すでに予約済みです'], 400);
    }

    for ($i = 1; $i <= $request->input('number_of_people'); $i++) {
      Reserve::create([
        'event_id' => $id,
        'reserve_user_id' => Auth::user()->id,
        'ticket_token' => bin2hex(random_bytes(16)),
        'has_used' => false
      ]);
    }
    return response()->json();
  }
}
