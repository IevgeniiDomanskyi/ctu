<?php

namespace App\Http\Services\Admin;

use Illuminate\Support\Facades\Hash;
use App\Http\Services\Service;
use App\Enums\UserRoleEnum;
use App\Models\User;

class AuthService extends Service
{
  public function __construct()
  {
    $this->model = new User();
  }

  public function me(): ?User
  {
    return auth()->user();
  }

  public function login(array $input): ?User
  {
    $me = $this->getByEmail($input['email']);
    if (!$me || !Hash::check($input['password'], $me->password)) {
      return response()->message(__('The provided credentials are incorrect.'), 'error', 422);
    }

    if ($me->role !== UserRoleEnum::Admin) {
      return response()->message(__('You have not access to this section'), 'error', 403);
    }

    $me->token = $me->createToken($me->email)->plainTextToken;
    return $me;
  }

  public function logout(): void
  {
    auth()->user()->tokens()->delete();
  }
}