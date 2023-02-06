<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\Validator;

class ApiValidationException extends Exception
{
  public function __construct()
  {
    parent::__construct();
  }

  public function render()
  {
    return response()->result();
  }

  public function withValidator(Validator $validator)
  {
    $messages = $validator->getMessageBag()->toArray();
    foreach ($messages as $field => $errors) {
      foreach ($errors as $error) {
        response()->message($error, 'error', 422);
      }
    }

    return $this;
  }

  public function failedAuthorization($message)
  {
    response()->message($message, 'error', 403);
    return $this;
  }
}