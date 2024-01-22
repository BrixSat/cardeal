<?php
declare(strict_types=1);
namespace App\Domain\Client;

use App\Infrastructure\DomainException\DomainRecordNotFoundException;
use Throwable;

class ClientNotFoundException extends DomainRecordNotFoundException
{
    public function __construct (string $message = '', ?Throwable $previous = null)
    {
        $errorMsg = 'The client you requested does not exist.';
        if (!empty($message)) $errorMsg.= ' More: '.$message;

        parent::__construct($errorMsg, 404, $previous);
    }
}
