<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Resources\StoreQuestionResource;
use App\Services\FormService;
use App\Services\QuestionService;
use App\Traits\RespondsWithHttpStatus;

class QuestionController extends Controller
{
    use RespondsWithHttpStatus;

    public function __construct(protected QuestionService $questionService, protected FormService $formService)
    {

    }

    // For Creator

    public function store($form_slug, StoreQuestionRequest $request)
    {
        $form = $this->formService->getUserForm($form_slug, auth()->user());

        $question = $this->questionService->addFormQuestion($form, $request->validated());

        return $this->respondWithSuccess(new StoreQuestionResource($question));
    }

    public function delete($form_slug, $question_id)
    {
        $form = $this->formService->getUserForm($form_slug, auth()->user());

        $question = $this->questionService->getFormQuestion($form, $question_id);

        $this->questionService->removeFormQuestion($question);

        return $this->respondOk('Remove question success');
    }
}
