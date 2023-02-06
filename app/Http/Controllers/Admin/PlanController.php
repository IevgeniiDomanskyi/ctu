<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionRequest;
use App\Http\Requests\Admin\Plan\CreateRequest;
use App\Http\Resources\Admin\Plan\PlanResource;
use App\Models\Plan;

class PlanController extends Controller
{
  public function create(CreateRequest $request): JsonResponse
  {
    $input = $request->safe()->only(['name', 'api_id', 'trial', 'current']);
    $result = service('Admin\Plan')->create($input);
    return response()->result(new PlanResource($result), __('The new plan was created'));
  }

  public function update(CreateRequest $request, Plan $plan): JsonResponse
  {
    $input = $request->safe()->only(['name', 'api_id', 'trial', 'current']);
    $result = service('Admin\Plan')->update($plan, $input);
    return response()->result(new PlanResource($result), __('The current plan was updated'));
  }

  public function markAsCurrent(PermissionRequest $request, Plan $plan): JsonResponse
  {
    $result = service('Admin\Plan')->markAsCurrent($plan);
    return response()->result(new PlanResource($result), __('The plan was marked as current'));
  }

  public function all(PermissionRequest $request): JsonResponse
  {
    $result = service('Admin\Plan')->all();
    return response()->result(PlanResource::collection($result));
  }

  public function get(Plan $plan): JsonResponse
  {
    return response()->result(new PlanResource($plan));
  }

  public function current(PermissionRequest $request): JsonResponse
  {
    $result = service('Admin\Plan')->current();
    return response()->result(new PlanResource($result));
  }

  public function remove(Plan $plan): JsonResponse
  {
    $result = service('Admin\Plan')->remove($plan);
    return response()->result($result, __('The plan was removed'));
  }
}