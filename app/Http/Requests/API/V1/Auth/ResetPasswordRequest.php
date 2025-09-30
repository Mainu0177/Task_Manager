<?php

namespace App\Http\Requests\API\V1\Auth;

use App\Http\Requests\API\v1\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|exists:users,email',
            'otp' => 'required|digits:6',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
