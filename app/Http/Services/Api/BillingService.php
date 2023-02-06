<?php

namespace App\Http\Services\Api;

use Stripe\Customer;
use Stripe\SetupIntent;
use App\Http\Services\Service;
use App\Models\User;

class BillingService extends Service
{
  public function getCustomer(User $user): Customer
  {
    return $user->createOrGetStripeCustomer();
  }

  public function setupIndent(User $user): SetupIntent
  {
    return $user->createSetupIntent();
  }

  public function savePaymentMethod(User $user, array $data): User
  {
    $this->getCustomer($user);

    if (!empty($data['payment_method'])) {
      $user->addPaymentMethod($data['payment_method']);
      $user->updateDefaultPaymentMethod($data['payment_method']);
    }

    return $user;
  }

  public function subscribe(User $user): ?User
  {
    $this->getCustomer($user);

    if (!$user->hasPaymentMethod()) {
      return response()->message(__('You should add a card first'), 'error', 422);
    }

    if ($user->subscribed('default') && $user->subscription('default')?->onGracePeriod()) {
      $user->subscription('default')->resume();
    } else {
      $plan = service('Admin\Plan')->current();
      if (empty($plan)) {
        return null;
      }

      if (!$user->subscribed('default')) {
        $subscription = $user->newSubscription('default', $plan->api_id);
        if (!empty($plan->trial)) {
          $subscription->trialDays($plan->trial);
        }
        $subscription->add();
      }
    }

    $user->refresh();
    return $user;
  }

  public function unsubscribe(User $user): ?User
  {
    $this->getCustomer($user);

    if ($user->subscribed('default')) {
      $user->subscription('default')->cancel();
    }

    $user->refresh();
    return $user;
  }
}