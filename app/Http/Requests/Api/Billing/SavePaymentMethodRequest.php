<?php

namespace App\Http\Requests\Api\Billing;

use App\Http\Requests\ApiRequest;
use App\Enums\UserRoleEnum;

class SavePaymentMethodRequest extends ApiRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return $this->user()->role == UserRoleEnum::User;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      'payment_method' => 'required',
    ];
  }
}