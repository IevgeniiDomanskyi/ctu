<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Resources\Admin\User\MeResource;

class AuthController extends Controller
{
    public function me(Request $request) : JsonResponse
    {
        $me = service('Admin\Auth')->me();
        return response()->result( $me ? new MeResource($me) : $me);
    }

    public function login(LoginRequest $request) : JsonResponse
    {
        $input = $request->safe()->only(['email', 'password']);
        $result = service('Admin\Auth')->login($input);
        return response()->result(new MeResource($result), __('You have successfully logged into your account'));
    }

    public function logout() : JsonResponse
    {
        service('Admin\Auth')->logout();
        return response()->result(true);
    }
}
