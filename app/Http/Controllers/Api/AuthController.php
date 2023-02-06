<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\RecoveryRequest;
use App\Http\Requests\Api\Auth\SavePasswordRequest;
use App\Http\Requests\Api\Auth\ChangePasswordRequest;
use App\Http\Resources\Api\User\MeResource;
use App\Models\Hash;

class AuthController extends Controller
{
  public function me(Request $request): JsonResponse
  {
    $me = service('Api\Auth')->me();
    return response()->result($me ? new MeResource($me) : $me);
  }

  public function login(LoginRequest $request): JsonResponse
  {
    $input = $request->safe()->only(['email', 'password']);
    $result = service('Api\Auth')->login($input);
    return response()->result(new MeResource($result), __('You have successfully logged into your account'));
  }

  public function logout(): JsonResponse
  {
    service('Api\Auth')->logout();
    return response()->result(true);
  }

  public function register(RegisterRequest $request): JsonResponse
  {
    $input = $request->safe()->only(['name', 'company', 'email', 'password', 'link']);
    $result = service('Api\Auth')->register($input);
    return response()->result($result, __('You were successfully registered'));
  }

  public function activate(Hash $hash): JsonResponse
  {
    $result = service('Api\Auth')->activate($hash);
    return response()->result($result, __('You were successfully activated your account'));
  }

  public function recovery(RecoveryRequest $request)
  {
    $input = $request->safe()->only(['email', 'link']);
    $result = service('Api\Auth')->recovery($input);
    return response()->result($result, __('A letter with instructions was sent to your email'));
  }

  public function hash(Hash $hash): JsonResponse
  {
    $result = service('Api\Auth')->hash($hash);
    return response()->result($result);
  }

  public function savePassword(SavePasswordRequest $request): JsonResponse
  {
    $input = $request->safe()->only(['hash', 'password']);
    $result = service('Api\Auth')->savePassword($input);
    return response()->result(new MeResource($result), __('You have successfully set your new password'));
  }

  public function changePassword(ChangePasswordRequest $request): JsonResponse
  {
    $input = $request->safe()->only(['current', 'new']);
    $result = service('Api\Auth')->changePassword($input);
    return response()->result(new MeResource($result), __('You have successfully change your password'));
  }
}