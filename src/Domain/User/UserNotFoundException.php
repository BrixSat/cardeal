<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Infrastructure\DomainException\DomainRecordNotFoundException;
use Throwable;

class UserNotFoundException extends DomainRecordNotFoundException
{
    public function __construct (string $message = '', ?Throwable $previous = null)
    {
        $errorMsg = 'The user you requested does not exist.';
        if (!empty($message)) $errorMsg.= ' More: '.$message;

        parent::__construct($errorMsg, 404, $previous);
    }
}
