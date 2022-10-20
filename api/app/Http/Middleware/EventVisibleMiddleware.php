<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;

class EventVisibleMiddleware
{
  public function handle(Request $request, Closure $next)
  {
    $event = Event::findOrFail($request->route()->parameter('id'));
    if ($event->canReserve()) {
      return $next($request);
    }
    return response()->json([], 403);
  }
}
