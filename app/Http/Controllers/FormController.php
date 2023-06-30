<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequests;
use App\Http\Resources\DetailFormResource;
use App\Http\Resources\FormCollection;
use App\Http\Resources\StoreFormResource;
use App\Services\FormService;
use App\Traits\RespondsWithHttpStatus;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    use RespondsWithHttpStatus;

    public function __construct(protected FormService $formService)
    {

    }

    /**
     * For Creator
     */
    public function store(FormRequests $request)
    {
        $form = $this->formService->newForm($request->validated(), Auth::user());

        return $this->respondWithSuccess(new StoreFormResource($form));
    }

    public function index()
    {
        $forms = $this->formService->getUserForms(Auth::user());

        return $this->respondWithSuccess(new FormCollection($forms));
    }

    /**
     * For invited users to get detail form
     */
    public function show(string $slug)
    {
        $form = $this->formService->getAllowedForm($slug, Auth::user());

        return $this->respondWithSuccess(new DetailFormResource($form));
    }
}
