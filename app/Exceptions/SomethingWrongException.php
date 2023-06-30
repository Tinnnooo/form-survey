<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class SomethingWrongException extends Exception
{
    public function render(Request $request)
    {
        return response()->json([
            'message' => 'Currently server is busy. Please try again.',
        ], 500);
    }
}
