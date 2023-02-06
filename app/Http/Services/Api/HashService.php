<?php

namespace App\Http\Services\Api;

use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Services\Service;
use App\Enums\HashTypeEnum;
use App\Models\Hash;

class HashService extends Service
{
  public function __construct()
  {
    $this->model = new Hash();
  }

  public function get(object $model, HashTypeEnum $type): ?Hash
  {
    return $model->hashes()->where('type', $type)->first();
  }

  public function getRelatedModel(string $hash, HashTypeEnum $type, object $instance): ?object
  {
    return $instance::whereHas('hashes', function ($q) use ($hash, $type) {
      $q->where('hash', $hash);
      $q->where('type', $type);
      $q->where(
        function ($qDate) {
          $qDate->whereDate('expired_at', '>', Carbon::now());
          $qDate->orWhereNull('expired_at');
        }
      );
    })->first();
  }

  public function create(object $model, HashTypeEnum $type, Carbon $expired_at = null): string
  {
    $hash = $model->hashes()
      ->firstOrNew([
        'type' => $type,
      ]);

    if ($hash->exists) {
      $model->hashes()
        ->detach($hash->id);
    }

    $hash->type = $type;
    $hash->hash = md5(Str::random(10));
    $hash->expired_at = $expired_at;
    $model->hashes()
      ->save($hash);

    return $hash->hash;
  }

  public function remove(object $model, HashTypeEnum $type): void
  {
    $ids = $model->hashes()
      ->where('type', $type)
      ->get()
      ->pluck('id')
      ->all();

    $model->hashes()
      ->detach($ids);

    Hash::whereIn('id', $ids)
      ->delete();
  }
}