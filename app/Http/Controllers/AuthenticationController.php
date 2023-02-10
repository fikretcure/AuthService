<?php

namespace App\Http\Controllers;


use App\Http\Repositories\TokenRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\AuthenticationCheckTokenRequest;
use App\Http\Requests\AuthenticationLoginRequest;
use App\Models\Token;
use Illuminate\Http\JsonResponse;
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

            return $this->success(compact("bearrer", "refresh"))->send();
        }
        return $this->failMes("Bilgilerini tekrar girerek denemelisin !")->send();
    }

    public function checkToken(AuthenticationCheckTokenRequest $request)
    {
        $token = Token::where("bearrer", $request->input("bearrer"))
            ->where("refresh", $request->input("refresh"))
            ->firstOrFail();


        if (now()->lessThanOrEqualTo($token->bearrer_expired_at)) {

            return $this->success($token->user)->send();
        }

        if (now()->lessThanOrEqualTo($token->refresh_expired_at)) {
            $bearrer = str()->uuid();
            $token->update([
                "bearrer" => $bearrer,
                "bearrer_expired_at" => now()->addMinutes(5),
            ]);
            return $this->success($token->user)->send();

        }
        return $this->failMes("Bilgilerini tekrar girerek denemelisin !")->send();


    }
}
