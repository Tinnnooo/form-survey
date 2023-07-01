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

Route::group(['prefix' => 'v1'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);


        // Get Current User
        Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        // For creator
        Route::post('forms', [FormController::class, 'store']);
        Route::get('forms', [FormController::class, 'index']);
        Route::post('forms/{form_slug}/questions', [QuestionController::class, 'store']);
        Route::delete('forms/{form_slug}/questions/{question_id}', [QuestionController::class, 'delete']);
        Route::get('forms/{form_slug}/responses', [ResponseController::class, 'index']);

        // For Invited Users
        Route::get('forms/{form_slug}', [FormController::class, 'show']);
        Route::post('forms/{form_slug}/responses', [ResponseController::class, 'store']);

    });
});
