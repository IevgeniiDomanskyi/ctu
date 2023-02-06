<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\ApiValidationException;

abstract class ApiRequest extends FormRequest
{
  protected function failedValidation(Validator $validator)
  {
    throw (new ApiValidationException())->withValidator($validator);
  }

  protected function failedAuthorization()
  {
    throw (new ApiValidationException())->failedAuthorization(__('You have not access to this method'));
  }
}