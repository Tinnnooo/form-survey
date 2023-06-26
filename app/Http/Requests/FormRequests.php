<?php

namespace App\Http\Requests;

use App\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FormRequests extends FormRequest
{
    use RespondsWithHttpStatus;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required",
            "slug" => "required|unique:forms,slug|alpha_dash|regex:/^[a-zA-Z0-9\-\.]+$/",
            "allowed_domains" => "array",
            "description" => "nullable",
            "limit_one_response" => "nullable",
            "creator_id" => "exists:users,id"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->respondUnprocessed($validator->errors()),
        );
    }
}
