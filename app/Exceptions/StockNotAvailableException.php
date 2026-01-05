<?php

namespace App\Exceptions;

use Exception;

class StockNotAvailableException extends Exception
{
    public function __construct($message = "The requested quantity exceeds available stock.", $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render($request)
    {
        return response()->json([
            'error' => 'Stock Not Available',
            'message' => $this->getMessage(),
        ], 400);
    }
}
