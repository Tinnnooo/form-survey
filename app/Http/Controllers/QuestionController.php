<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Services\QuestionService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    //
    private QuestionService $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function storeQuestionForm($slug, StoreQuestionRequest $request)
    {
        $new_question = $this->questionService->addQuestion($slug, auth()->user());

    }
}
