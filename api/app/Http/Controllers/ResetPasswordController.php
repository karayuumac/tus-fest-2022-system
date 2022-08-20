<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
  public function __invoke(Request $request)
  {
    $result = [
      'email' => $request->email,
      'token' => $request->token
    ];
    return response()->json($request);
  }
}
