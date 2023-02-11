<?php

namespace App\Http\Controllers;


use App\Helpers\RequestMergeHelper;
use App\Http\Repositories\TokenRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\AuthenticationLoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 *
 */
class AuthenticationController extends Controller
{

    /**
     *
     */
    public function __construct()
    {
        $this->user_repository = new UserRepository;
        $this->token_repository = new TokenRepository;
    }

    /**
     * @param AuthenticationLoginRequest $request
     * @return JsonResponse
     */
    public function login(AuthenticationLoginRequest $request): JsonResponse
    {
        $user = $this->user_repository->showByEmail($request->validated("email"));
        if (Hash::check($request->password, $user->password)) {
            $bearrer = str()->uuid();
            $refresh = str()->uuid();
            $this->token_repository->store([
                "bearrer" => $bearrer,
                "bearrer_expired_at" => now()->addMinutes(5),
                "refresh" => $refresh,
                "refresh_expired_at" => $request->input("remember_me") ? now()->addDay(5) : now()->addHours(5),
                "user_id" => $user->id
            ]);
            (new RequestMergeHelper())->handle($bearrer, $refresh);
            $this->token_repository->deleteWhereRefreshExpiredAt();

            return $this->success(compact("bearrer", "refresh"))->send();
        }
        return $this->failMes("Bilgilerini tekrar girerek denemelisin !")->send();
    }

    /**
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        return $this->success($this->user_repository->show(Auth::id()))->send();
    }
}
