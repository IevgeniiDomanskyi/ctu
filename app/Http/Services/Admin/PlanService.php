<?php

namespace App\Http\Services\Admin;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Services\Service;
use App\Models\Plan;

class PlanService extends Service
{
  public function __construct()
  {
    $this->model = new Plan();
  }

  public function create(array $data): Plan
  {
    if ( ! empty($data['current'])) {
      $this->resetCurrent();
    }

    $plan = $this->modelCreate($data);
    return $plan;
  }

  public function update(Plan $plan, array $data): Plan
  {
    if ( ! empty($data['current'])) {
      $this->resetCurrent();
    }

    $plan = $this->modelUpdate($plan, $data);
    return $plan;
  }

  public function markAsCurrent(Plan $plan): Plan
  {
    $this->resetCurrent();

    $plan = $this->modelUpdate($plan, [
      'current' => true,
    ]);
    return $plan;
  }

  public function resetCurrent(): void
  {
    $plans = $this->getAll();
    if ($plans->count()) {
      $plans->each(function ($item, $key) {
        $item->update([
          'current' => false,
        ]);
      });
    }
  }

  public function all(): Collection
  {
    return $this->getAll();
  }

  public function current(): ?Plan
  {
    $plan = $this->getByField('current', true);
    if (empty($plan)) {
      $plan = $this->model->orderBy('created_at', 'desc')->first();
      if (empty($plan)) {
        return response()->message(__('There are no any created plans'), 'error', 404);
      }
    }

    return $plan;
  }

  public function remove(Plan $plan): bool
  {
    $this->modelRemove($plan);
    return true;
  }
}