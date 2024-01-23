<?php

declare(strict_types=1);

namespace App\Infrastructure\DomainException;

use Throwable;

class InvalidArgumentException extends DomainException
{
    public function __construct (
        string $key,
        string $message = '',
        ?Throwable $previous = null)
    {
        if(empty($message)) $message = "The field {$key} has an invalid content." ;

        parent::__construct($message, 400, $previous);
    }
}