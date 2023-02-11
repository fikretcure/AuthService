<?php

namespace App\Http\Requests;

use App\Models\Token;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthenticationCheckTokenRequest extends FormRequest
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
            "bearrer" =>[
                "required",
                "string",
                "uuid",
                Rule::exists(Token::class)
            ],
            "refresh" =>[
                "required",
                "string",
                "uuid",
                Rule::exists(Token::class)
            ]
        ];
    }
}