<?php

namespace App\Exceptions;

use Exception;

class ForbiddenAccessException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => 'Forbidden access'
        ], 403);
    }
}
