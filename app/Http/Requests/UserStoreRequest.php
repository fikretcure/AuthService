<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
            "name" => [
                "required",
                "string"
            ],
            "surname" => [
                "required",
                "string"
            ],
            "email" => [
                "required",
                "string",
                "email:rfc,dns",
                Rule::unique(User::class)
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(6)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
            ]
        ];
    }
}
