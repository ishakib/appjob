<?php

namespace App\Exceptions;

use Throwable;

class ModelUpdateException extends BaseException {
    public function __construct(string $message = "", string $details = "", int $code = 0, Throwable $previous = null)
    {
        $this->message = __('exception.model.fail');

        if (!blank($message)) {
            $this->message = $message;
        }

        parent::__construct($details, $code, $previous);
    }
}
