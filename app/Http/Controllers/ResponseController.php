<?php

namespace App\Http\Controllers;

use App\Exceptions\UnprocessedDataException;
use App\Http\Requests\SubmitResponseRequest;
use App\Http\Resources\ResponseAnswerCollection;
use App\Services\FormService;
use App\Services\ResponseService;
use App\Traits\RespondsWithHttpStatus;

class ResponseController extends Controller
{
    use RespondsWithHttpStatus;

    public function __construct(protected ResponseService $responseService, protected FormService $formService)
    {

    }

    // For creator

    public function index($form_slug)
    {
        $form = $this->formService->getUserForm($form_slug, auth()->user());

        $responses = $this->responseService->getFormResponses($form);

        return $this->respondWithSuccess(new ResponseAnswerCollection($responses));
    }

    // For Invited User

    public function store($form_slug, SubmitResponseRequest $request)
    {
        $user = auth()->user();

        $form = $this->formService->getAllowedForm($form_slug, $user);

        if ($form->limit_one_response && $this->responseService->isFormRespondedByUser($form, $user)) {
            throw new UnprocessedDataException('You can not submit form twice');
        }

        $this->responseService->add($form, $request->validated(), $user);

        return $this->respondOk('Submit response success');
    }
}
