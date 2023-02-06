<?php

namespace App\Http\Services\Api;

use Illuminate\Support\Facades\Hash as HashFacade;
use Carbon\Carbon;
use App\Http\Services\Service;
use App\Notifications\Auth\RegisterNotification;
use App\Notifications\Auth\RecoveryNotification;
use App\Enums\UserRoleEnum;
use App\Enums\HashTypeEnum;
use App\Models\User;
use App\Models\Hash;

class AuthService extends Service
{
  public function __construct()
  {
    $this->model = new User();
  }

  public function me(): ?User
  {
    $me = auth()->user();

    if ($me->role !== UserRoleEnum::User) {
      return response()->message(__('You have not access to this section'), 'error', 403);
    }

    return $me;
  }

  public function login(array $input): ?User
  {
    $me = $this->getByEmail($input['email']);
    if (!$me || !HashFacade::check($input['password'], $me->password)) {
      return response()->message(__('The provided credentials are incorrect.'), 'error', 422);
    }

    if ($me->role !== UserRoleEnum::User) {
      return response()->message(__('You have not access to this section'), 'error', 403);
    }

    $me->token = $me->createToken($me->email)->plainTextToken;
    return $me;
  }

  public function logout(): void
  {
    auth()->user()->tokens()->delete();
  }

  public function register(array $input): bool
  {
    $user = $this->modelCreate([
      'company' => $input['company'],
      'name' => $input['name'],
      'email' => $input['email'],
      'password' => HashFacade::make($input['password']),
      'role' => UserRoleEnum::User,
    ]);

    $hash = service('Api\Hash')->create($user, HashTypeEnum::Verify);
    $link = str_replace('{hash}', $hash, $input['link']);
    $user->notify(new RegisterNotification($user, $link));

    return true;
  }

  public function activate(Hash $hash): ?bool
  {
    $user = service('Api\Hash')->getRelatedModel($hash->hash, HashTypeEnum::Verify, (new User));
    if (is_null($user)) {
      return response()->message(__('The activation link is wrong or expired'), 'error', 422);
    }

    $user = $this->modelUpdate($user, [
      'email_verified_at' => Carbon::now(),
    ]);
    service('Api\Hash')->remove($user, HashTypeEnum::Verify);

    service('Api\Billing')->getCustomer($user);

    return true;
  }

  public function recovery(array $input): ?bool
  {
    $user = $this->getByEmail($input['email']);

    if (is_null($user) || $user->role == UserRoleEnum::Admin) {
      return response()->message('The email is incorect', 'error', 422);
    }

    service('Api\Hash')->remove($user, HashTypeEnum::Recovery);
    $hash = service('Api\Hash')->create($user, HashTypeEnum::Recovery, null);
    $link = str_replace('{hash}', $hash, $input['link']);
    $user->notify(new RecoveryNotification($user, $link));

    return true;
  }

  public function hash(Hash $hash): ?bool
  {
    $user = service('Api\Hash')->getRelatedModel($hash->hash, HashTypeEnum::Recovery, (new User));
    if (is_null($user)) {
      return response()->message(__('The password recovery link is wrong or expired'), 'error', 422);
    }

    return true;
  }

  public function savePassword(array $input): ?User
  {
    $user = service('Api\Hash')->getRelatedModel($input['hash'], HashTypeEnum::Recovery, (new User));
    if (is_null($user)) {
      return response()->message(__('The password recovery link is wrong or expired'), 'error', 422);
    }

    $user = $this->modelUpdate($user, [
      'password' => HashFacade::make($input['password']),
    ]);
    service('Api\Hash')->remove($user, HashTypeEnum::Recovery);

    $user->token = $user->createToken($user->email)->plainTextToken;
    return $user;
  }

  public function changePassword(array $input): ?User
  {
    $me = auth()->user();
    if (!HashFacade::check($input['current'], $me->password)) {
      return response()->message('You entered wrong current password', 'error', 422);
    }

    $me = $this->modelUpdate($me, [
      'password' => HashFacade::make($input['new']),
    ]);

    return $me;
  }
}