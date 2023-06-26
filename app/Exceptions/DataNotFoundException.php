<?php

namespace App\Exceptions;

use Exception;
use GuzzleHttp\Psr7\Request;

class DataNotFoundException extends Exception
{
    public function render(Request $request)
    {
        return response()->error('Data is not available', 404);
    }
}
