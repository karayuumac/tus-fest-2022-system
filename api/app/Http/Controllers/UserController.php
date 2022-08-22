<?php

namespace App\Http\Controllers;


use App\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function get(Request $request)
  {
    return new UserResource($request->user());
  }
}
