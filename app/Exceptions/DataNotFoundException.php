<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class DataNotFoundException extends Exception
{
    public function render(Request $request)
    {
        return response()->json([
            'message' => 'Data is not available',
        ], 404);
    }
}
