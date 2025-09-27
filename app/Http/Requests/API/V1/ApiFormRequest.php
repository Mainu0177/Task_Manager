<?php

namespace App\Http\Requests\API\v1;

use App\Traits\ApiResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    // /**
    //  * Get the validation rules that apply to the request.
    //  *
    //  * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
    //  */
    // public function rules(): array
    // {
    //     return [
    //         //
    //     ];
    // }


    use ApiResponseTrait;

    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(
            $this->error($validator->errors()->all(), 422)
        );
    }
}
