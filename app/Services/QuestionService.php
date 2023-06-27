<?php

namespace App\Services;

use App\Exceptions\ForbiddenAccess;
use Exception;
use App\Models\Form;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use App\Exceptions\NotFoundException;
use App\Exceptions\SomethingWrongException;
use App\Services\AllowedDomainService;

class QuestionService
{
    public function isUserAllowed($user, $form)
    {
        if($form->creator_id !== $user->id)
        {
            throw new ForbiddenAccess('Forbidden access');
        }
    }

    public function addQuestion($slug, $dataQuestion, $user)
    {
        $form = Form::where("slug", $slug)->first();

        if(empty($form)){
            throw new NotFoundException('Form not found');
        }

        $this->isUserAllowed($user, $form);

        DB::beginTransaction();

        try{
            $questions = Question::create([
                "name" => $dataQuestion["name"],
                "choice_type" => $dataQuestion['choice_type'],
                "is_required" => $dataQuestion['is_required'] ?? 0,
                "choices" => isset($dataQuestion['choices']) ? implode(', ', $dataQuestion['choices']) : '',
                "form_id" => $form['id'],
            ]);


            DB::commit();
            return $questions;
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    public function removeQuestionForm($slug, int $id, $user)
    {
        $form = Form::where('slug', $slug)->first();
        if(empty($form)){
            throw new NotFoundException('Form not found');
        }


        $question = Question::where('id', $id)->where('form_id', $form->id)->first();
        if(empty($question)){
            throw new NotFoundException('Question not found');
        }

        $this->isUserAllowed($user, $form);

        try{
            $question->delete();
        } catch (Exception $e) {
            throw new SomethingWrongException;
        }
    }
}
