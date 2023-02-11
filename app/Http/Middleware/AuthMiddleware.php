<?php

namespace App\Http\Middleware;

use App\Helpers\RequestMergeHelper;
use App\Http\Repositories\TokenRepository;
use App\Models\Token;
use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class AuthMiddleware
{
    use ResponseTrait;

    /**
     *
     */
    public function __construct()
    {
        $this->token_repository = new TokenRepository;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed
     * @throws ValidationException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $request_merge = new RequestMergeHelper();

        $validator = Validator::make(getallheaders(), [
            "bearrer" => [
                "required",
                "string",
                "uuid",
                Rule::exists(Token::class)
            ],
            "refresh" => [
                "required",
                "string",
                "uuid",
                Rule::exists(Token::class)
            ]
        ]);
        $validator->validated();

        $token = $this->token_repository->showWhereBearrerAndWhereRefresh($request->header("bearrer"), $request->header("refresh"));

        if (now()->lessThanOrEqualTo($token->bearrer_expired_at)) {
            $request_merge->handle($request->header("bearrer"), $request->header("refresh"));
            Auth::loginUsingId($token->user_id);

            return $next($request);
        }

        if (now()->lessThanOrEqualTo($token->refresh_expired_at)) {
            $bearrer = str()->uuid();
            $token->update([
                "bearrer" => $bearrer,
                "bearrer_expired_at" => now()->addMinutes(5),
            ]);
            $request_merge->handle($bearrer, $request->header("refresh"));
            Auth::loginUsingId($token->user_id);

            return $next($request);
        }
        return $this->failMes("Bilgilerini tekrar girerek denemelisin !")->send();
    }
}
