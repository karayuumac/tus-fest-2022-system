<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class EnsureAdminMiddleware
{
  public function handle(Request $request, Closure $next)
  {
    if (!Auth::user()->is_admin) {
      return response()->json([
        'message' => '権限がありません.'
      ], 401);
    }
    return $next($request);
  }
}
