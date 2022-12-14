<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\LoginResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function login(Request $request)
  {
    $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required'],
      'device_name' => ['required'],
    ]);

    $user = User::where('email', $request->email)->first();

    if (!Hash::check($request->password, optional($user)->password)) {
      throw ValidationException::withMessages([
        'email' =>[__('auth.failed')]
      ]);
    }

    return new LoginResponse($user);
  }

  function logout(Request $request){
    $request->user()->currentAccessToken()->delete();

    return response()->noContent();
  }
}
