<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitResponseRequest;
use App\Http\Resources\ResponseAnswerCollection;
use App\Services\ResponseAnswersService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    use RespondsWithHttpStatus;

    public function __construct(protected ResponseAnswersService $responseAnswersService)
    {

    }

    public function SubmitResponse($slug, SubmitResponseRequest $request)
    {
        $this->responseAnswersService->submitResponse($slug, $request, auth()->user());

        return $this->respondOk('Submit response success');
    }

    public function GetAllFormResponses($slug)
    {
        $responses = $this->responseAnswersService->getAllFormResponse($slug, auth()->user());

        return $this->respondWithSuccess(new ResponseAnswerCollection($responses));
    }
}
