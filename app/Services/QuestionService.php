<?php

namespace App\Services;

use App\Exceptions\DataNotFoundException;
use App\Exceptions\ForbiddenAccessException;
use Exception;
use App\Models\Form;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use App\Exceptions\NotFoundException;
use App\Exceptions\SomethingWrongException;

class QuestionService
{
    public function addFormQuestion($form, $question_data)
    {
        DB::beginTransaction();

        try{
            $question = Question::create([
                "name" => $question_data["name"],
                "choice_type" => $question_data['choice_type'],
                "is_required" => $question_data['is_required'] ?? 0,
                "choices" => isset($question_data['choices']) ? implode(', ', $question_data['choices']) : '',
                "form_id" => $form->id,
            ]);

            DB::commit();

            return $question;
        } catch (Exception $e) {
            DB::rollback();
            throw new SomethingWrongException;
        }
    }

    public function getFormQuestion($form, $question_id){
        $question = $form->questions()->where('id', $question_id)->first();
        if(empty($question)){
            throw new NotFoundException('Question not found');
        }

        return $question;
    }

    public function removeFormQuestion($question)
    {
        try{
            $question->delete();
        } catch (Exception $e) {
            throw new SomethingWrongException;
        }
    }
}
