<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use App\Services\FormService;
use App\Http\Requests\FormRequests;
use App\Http\Resources\FormCollection;
use App\Http\Resources\GetFormCollection;
use App\Http\Resources\GetFormResource;
use Illuminate\Support\Facades\Auth;
use App\Traits\RespondsWithHttpStatus;
use App\Http\Resources\StoreFormResource;

class FormController extends Controller
{
    private FormService $formService;
    use RespondsWithHttpStatus;

    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
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
}
