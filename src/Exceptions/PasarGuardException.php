<?php

namespace Pooshgan\PasarGuard\Exceptions;

use Exception;
use Throwable;

class PasarGuardException extends Exception
{
    protected array $errorData;

    public function __construct(string $message = "", int $code = 0, array $errorData = [], ?Throwable $previous = null)
    {
        $this->errorData = $errorData;
        parent::__construct($message, $code, $previous);
    }

    public function getErrorData(): array
    {
        return $this->errorData;
    }
}