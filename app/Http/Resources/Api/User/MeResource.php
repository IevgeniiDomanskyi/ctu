<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Enums\UserRoleEnum;

class MeResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'company' => $this->company,
      'email' => $this->email,
      'role' => $this->role,
      'isAdmin' => $this->role === UserRoleEnum::Admin,
      $this->mergeWhen(!empty($this->stripe_id), [
        'isSubscribed' => $this->subscribed('default'),
        $this->mergeWhen($this->subscribed('default'), [
          'isCanceled' => $this->subscription('default')?->canceled(),
          'isEnded' => $this->subscription('default')?->ended(),
          'onGracePeriod' => $this->subscription('default')?->onGracePeriod(),
          'onTrial' => $this->onTrial('default'),
          'trialEndsAt' => $this->trialEndsAt('default'),
          'periodEndsAt' => Carbon::createFromTimeStamp($this->subscription('default')?->asStripeSubscription()->current_period_end),
        ]),
      ]),
      $this->mergeWhen(!empty($this->token), [
        'token' => $this->token,
      ]),
    ];
  }
}