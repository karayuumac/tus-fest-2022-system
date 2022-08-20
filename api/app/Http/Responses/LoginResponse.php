<?php

namespace App\Http\Responses;

use Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Fortify;

class LoginResponse implements LoginResponseContract
{
  public function toResponse($request)
  {
    $user = Auth::user();
    return $request->wantsJson()
      ? response()->json($user)
      : redirect()->intended(Fortify::redirects('login'));
  }
}
