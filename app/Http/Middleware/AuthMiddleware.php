<?php

namespace App\Http\Middleware;

use App\Http\Repositories\TokenRepository;
use App\Models\Token;
use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthMiddleware
{
    use ResponseTrait;


    public function __construct()
    {
        $this->token_repository = new TokenRepository;
    }


    public function handle(Request $request, Closure $next)
    {
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

            $request->merge([
                "bearrer" => $request->header("bearrer"),
                "refresh" => $request->header("refresh"),
            ]);
            return $next($request);
        }

        if (now()->lessThanOrEqualTo($token->refresh_expired_at)) {
            $bearrer = str()->uuid();
            $token->update([
                "bearrer" => $bearrer,
                "bearrer_expired_at" => now()->addMinutes(5),
            ]);
            $request->merge([
                "bearrer" => $bearrer,
                "refresh" => $request->header("refresh"),
            ]);
            return $next($request);
        }
        return $this->failMes("Bilgilerini tekrar girerek denemelisin !")->send();
    }
}
