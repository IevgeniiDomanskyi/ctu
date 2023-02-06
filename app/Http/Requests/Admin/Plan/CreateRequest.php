<?php

namespace App\Http\Requests\Admin\Plan;

use App\Http\Requests\ApiRequest;
use App\Enums\UserRoleEnum;

class CreateRequest extends ApiRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return $this->user()->role == UserRoleEnum::Admin;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      'name' => 'required',
      'api_id' => 'required',
      'current' => 'required',
      'trial' => 'numeric',
    ];
  }
}