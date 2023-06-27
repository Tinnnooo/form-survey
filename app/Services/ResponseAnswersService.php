<?php

namespace App\Services;

use Exception;
use App\Models\Form;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Response;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ForbiddenAccess;
use App\Exceptions\NotFoundException;
use App\Services\AllowedDomainService;
use App\Traits\RespondsWithHttpStatus;
use App\Exceptions\SomethingWrongException;
use App\Exceptions\UnprocessedDataException;

class ResponseAnswersService
{
    use RespondsWithHttpStatus;

    public function __construct(protected AllowedDomainService $allowedDomainService)
    {

    }

    public function isUserAllowed($user, $form)
    {
        if($form->creator_id !== $user->id)
        {
            throw new ForbiddenAccess('Forbidden access');
        }
    }

    public function isResponseTwice($form, $user)
    {
        if($form->limit_one_response && Response::where('form_id', $form->id)->where('user_id', $user->id)->first()){
            throw new UnprocessedDataException('You can not submit form twice');
        }
    }

    public function getForm($slug)
    {
        $form = Form::where('slug', $slug)->first();
        if(empty($form))
        {
            throw new NotFoundException("Form not found");
        }

        return $form;
    }

    public function getAllFormResponse($slug, $user)
    {
        $form = $this->getForm($slug);

        $this->isUserAllowed($user, $form);

        $response = Response::where('form_id', $form->id)->get();

        return $response;
    }

    public function submitResponse($slug, $dataResponse, $user)
    {
        $form = $this->getForm($slug);

        $this->allowedDomainService->userDomainCheck($user, $form);
        $this->isResponseTwice($form, $user);

        DB::beginTransaction();
        try {
            $response = Response::create([
                "form_id" => $form['id'],
                "user_id" => $user['id'],
                "date" => date('Y-m-d H:i:s'),
            ]);

            $this->createAnswersData($dataResponse, $response->id);

            DB::commit();
        } catch (Exception $e) {
            throw new SomethingWrongException;
            DB::rollBack();
        }
    }

    public function createAnswersData($dataAnswers, $response_id)
    {
        foreach($dataAnswers['answers'] as $answers){
            Answer::create([
                "response_id" => $response_id,
                "question_id" => $answers['question_id'],
                "value" => $answers['value'],
            ]);
        }
    }


}
