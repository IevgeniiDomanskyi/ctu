<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PermissionRequest;
use App\Http\Requests\Api\Billing\SavePaymentMethodRequest;
use App\Http\Resources\Api\User\MeResource;

class BillingController extends Controller
{
  public function setupIndent(Request $request): JsonResponse
  {
    $result = service('Api\Billing')->setupIndent($request->user());
    return response()->result($result);
  }

  public function savePaymentMethod(SavePaymentMethodRequest $request): JsonResponse
  {
    $input = $request->safe()->only(['payment_method']);
    $result = service('Api\Billing')->savePaymentMethod($request->user(), $input);
    return response()->result(new MeResource($result), __('Your card was saved'));
  }

  public function subscribe(PermissionRequest $request): JsonResponse
  {
    $result = service('Api\Billing')->subscribe($request->user());
    return response()->result(new MeResource($result), __('You were successfully subscribed'));
  }

  public function unsubscribe(PermissionRequest $request): JsonResponse
  {
    $result = service('Api\Billing')->unsubscribe($request->user());
    return response()->result(new MeResource($result), __('You were successfully unsubscribed'));
  }
}