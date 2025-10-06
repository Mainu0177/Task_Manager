<?php

namespace App\Http\Requests\API\V1\Group;

use App\Http\Requests\API\v1\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class GroupUserRequest extends ApiFormRequest
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
            'group_id' => 'nullable|integer|exists:users.id|required_without:user_ids',
            'user_ids' => 'nullable|array|required_without:user_id',
            'user_ids.*' => 'integer|exists:users.id'
        ];
    }
}
