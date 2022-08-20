<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
  public function register(Request $request)
  {
    $validated_data = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8'
    ]);

    $user = User::create([
      'name' => $validated_data['name'],
      'email' => $validated_data['email'],
      'password' => Hash::make($validated_data['password'])
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
      'access_token' => $token,
      'token_type' => 'Bearer'
    ]);
  }

  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);

    if (!Auth::attempt($credentials)) {
      return response()->json([
        'message' => 'ユーザー名またはパスワードが異なります'
      ], Response::HTTP_UNAUTHORIZED);
    } else {
      return response()->json([
        'message' => 'ログインに成功しました！'
      ]);
    }
  }

  public function logout()
  {
    Auth::logout();
    return response()->json([
      'message' => 'ログアウトに成功しました！'
    ]);
  }

  public function authenticated()
  {
    if (Auth::check()) {
      return response()->json([
        'authenticated' => true
      ]);
    } else {
      return response()->json([
        'authenticated' => false
      ]);
    }
  }
}
