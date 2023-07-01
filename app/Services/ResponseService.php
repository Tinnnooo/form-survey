<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Exceptions\SomethingWrongException;
use App\Models\Answer;
use App\Models\Response;
use App\Traits\RespondsWithHttpStatus;
use Exception;
use Illuminate\Support\Facades\DB;

class ResponseService
{
    use RespondsWithHttpStatus;

    public function getFormResponses($form)
    {
        $responses = $form->responses;

        if ($responses->count() === 0) {
            throw new NotFoundException('No Response has been added');
        }

        return $responses;
    }

    public function isFormRespondedByUser($form, $user)
    {
        return $form->responses()->byUser($user->id)->count() > 0;
    }

    public function add($form, $response_data, $user)
    {
        DB::beginTransaction();
        try {
            $response = Response::create([
                'form_id' => $form->id,
                'user_id' => $user->id,
                'date' => date('Y-m-d H:i:s'),
            ]);

            $response_answers = [];
            foreach ($response_data['answers'] as $answer) {
                $response_answers[] = new Answer([
                    'question_id' => $answer['question_id'],
                    'value' => $answer['value'] ?? "",
                ]);
            }

            $response->answers()->saveMany($response_answers);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new SomethingWrongException;
        }
    }
}
