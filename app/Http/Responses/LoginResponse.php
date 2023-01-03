<?php

namespace App\Http\Responses;

use App\Models\User;
use Illuminate\Contracts\Support\Responsable;

class LoginResponse implements Responsable
{
  private $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function toResponse($request)
  {
    $this->user->load('roles', 'roles.permissions');

    return response()->json([
      'token' => $this->user->createToken(
        $request->device_name,
        []
      )->plainTextToken,
      'user' => [
        'name' => $this->user->name,
        'email' => $this->user->email,
        'roles' => $this->user->roles
      ],
      'company' => $this->user->company,
    ]);
  }
}
