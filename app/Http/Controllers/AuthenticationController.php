<?php

namespace App\Http\Controllers;


use App\Http\Requests\AuthenticationLoginRequest;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class AuthenticationController extends Controller
{


    /**
     * @param AuthenticationLoginRequest $request
     * @return JsonResponse
     */
    public function login(AuthenticationLoginRequest $request): JsonResponse
    {
        return $this->success()->send();
    }
}
