<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\ApiRequest;

class RegisterRequest extends ApiRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
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
      'company' => 'required',
      'email' => 'required|email|unique:users,email',
      'password' => 'required',
      'link' => 'required|regex:/{hash}/',
    ];
  }
}