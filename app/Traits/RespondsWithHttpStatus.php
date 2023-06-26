<?php
namespace App\Traits;

trait RespondsWithHttpStatus
{
    public function respondWithSuccess($contents, $status = 200)
    {
        return response()->json($contents, $status);
    }

    public function respondUnprocessed($errors, $status = 422)
    {
        return response()->json([
            'message' => "Invalid field",
            "errors" => $errors,
        ], $status);
    }

    public function respondOk($message, $status = 200)
    {
        return response()->json([
            "message" => $message,
        ], $status);
    }

    public function respondNotFound($message, $status = 404)
    {
        return response()->json([
            "message" => $message,
        ], $status);
    }
}
