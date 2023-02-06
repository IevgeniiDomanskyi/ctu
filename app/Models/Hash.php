<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\HashTypeEnum;

class Hash extends Model
{
  use HasFactory;

  protected $fillable = [
    'hash',
    'type',
    'expired_at',
  ];

  /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
      'type' => HashTypeEnum::class,
      'expired_at' => 'datetime',
      'created_at' => 'datetime',
      'updated_at' => 'datetime',
  ];

  /**Start Relations */
  public function users()
  {
    return $this->morphedByMany(User::class, 'hashable')->withTimestamps();
  }
  /**End Relations */
}