<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class BaseException extends Exception
{
    protected ?string $details = "";

    public function __construct(?string $details = null, int $code = 0, Throwable $previous = null)
    {
        if (blank($this->message)) {
            $this->message = __('exception.general');
        }

        if (!blank($details)) {
            $this->details = $details;
        }

        parent::__construct($this->message, $code, $previous);

    }

    public function getDetails(): ?string
    {
        return $this->details;
    }
}
