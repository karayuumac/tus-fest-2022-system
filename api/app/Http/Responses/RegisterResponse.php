<?php

namespace App\Http\Responses;

use Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Fortify;

class RegisterResponse implements RegisterResponseContract
{
  public function toResponse($request)
  {
    $user = Auth::user();
    return $request->wantsJson()
      ? response()->json($user, 201)
      : redirect('/');
  }
}
