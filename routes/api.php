<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResponseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1'], function() {

    Route::group(['prefix' => 'auth'], function() {
        Route::post('login', [AuthController::class, 'login']);
        Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
    });

    Route::middleware('auth:sanctum')->group(function() {
        Route::post('forms', [FormController::class, 'storeForm']);
        Route::get('forms', [FormController::class, 'getAllUserForm']);
        Route::get('forms/{form_slug}', [FormController::class, 'getDetailForm']);
        Route::post('forms/{form_slug}/questions', [QuestionController::class, 'AddQuestionToForm']);
        Route::delete('forms/{form_slug}/questions/{question_id}', [QuestionController::class, "RemoveQuestionFromForm"]);
        Route::post('forms/{form_slug}/responses', [ResponseController::class, 'SubmitResponse']);
        Route::get('forms/{form_slug}/responses', [ResponseController::class, "GetAllFormResponses"]);
    });
});

