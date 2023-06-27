<?php

namespace App\Http\Requests;

use App\Models\Question;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubmitResponseRequest extends FormRequest
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
            "answers" => "array",
            "answers.*.question_id" => "required|exists:questions,id",
            "answers.*.value" => function ($att, $value, $fail){
                $index = Str::after($att, 'answers.');
                $index = Str::before($index, '.value');
                $question_id = request('answers')[$index]['question_id'];
                $question = Question::find($question_id);

                if($question && $question->is_required && empty($value)) {
                    $fail('answers', 'The answers field is required.');
                }
            }
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->respondUnprocessed($validator->errors())
        );
    }
}
