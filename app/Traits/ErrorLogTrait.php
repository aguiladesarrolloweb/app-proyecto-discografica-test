<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait ErrorLogTrait
{
    public static function logError($channel, $message, \Throwable $exception)
    {
        Log::channel($channel)->error($message, [
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
            'previous' => $exception->getPrevious() ? $exception->getPrevious()->getMessage() : null,
            'class' => get_class($exception),
        ]);

    }
}
