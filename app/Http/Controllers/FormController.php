<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Services\FormService;
use App\Http\Requests\FormRequests;
use App\Http\Resources\DetailFormResource;
use App\Http\Resources\FormCollection;
use Illuminate\Support\Facades\Auth;
use App\Traits\RespondsWithHttpStatus;
use App\Http\Resources\StoreFormResource;


class FormController extends Controller
{
    use RespondsWithHttpStatus;

    public function __construct(protected FormService $formService)
    {

    }

    public function storeForm(FormRequests $request)
    {
        $user_id = Auth::user()->id;

        $form = $this->formService->newForm($request->validated(), $user_id);

        return $this->respondWithSuccess(new StoreFormResource($form));
    }

    public function getAllUserForm()
    {
        $forms = $this->formService->getAllUserForm(Auth::user()->id);
        return $this->respondWithSuccess(new FormCollection($forms));
    }

    public function getDetailForm($slug)
    {
        $form = $this->formService->getDetailForm($slug);

        return $this->respondWithSuccess(new DetailFormResource($form));
    }
}
