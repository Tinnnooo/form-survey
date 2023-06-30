<?php

namespace App\Http\Requests;

use App\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreQuestionRequest extends FormRequest
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
            'name' => 'required',
            'choice_type' => 'required|in:short answer,paragraph,date,multiple choice,dropdown,checkboxes',
            'is_required' => 'nullable',
            'choices' => 'required_if:choice_type,multiple choice, dropdown, checkboxes',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->respondUnprocessed($validator->errors())
        );
    }
}
