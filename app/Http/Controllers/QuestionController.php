<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Resources\StoreQuestionResource;
use App\Services\QuestionService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    use RespondsWithHttpStatus;

    public function __construct(protected QuestionService $questionService)
    {

    }

    public function AddQuestionToForm($slug, StoreQuestionRequest $request)
    {
        $new_question = $this->questionService->addQuestion($slug, $request->validated(), auth()->user());
        return $this->respondWithSuccess(new StoreQuestionResource($new_question));
    }

    public function RemoveQuestionFromForm($slug, $question_id)
    {
        $this->questionService->removeQuestionForm($slug, $question_id, auth()->user());

        return $this->respondOk("Remove question success");
    }
}
