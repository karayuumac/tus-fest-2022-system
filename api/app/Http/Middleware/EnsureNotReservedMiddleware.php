<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;

class EnsureNotReservedMiddleware
{
  public function handle(Request $request, Closure $next)
  {
    $event = Event::findOrFail($request->route()->parameter('id'));
    if (!$event->canReserve()) {
      return response()->json([
        'message' => 'このイベントのチケットをすでに予約済みです.'
      ], 403);
    } else if ($event->isFull()) {
      return response()->json([
        'message' => 'このイベントは満席です.'
      ], 403);
    }
    return $next($request);
  }
}
