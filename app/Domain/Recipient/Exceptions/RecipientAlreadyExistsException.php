<?php

namespace App\Domain\Recipient\Exceptions;


class RecipientAlreadyExistsException extends \Exception
{

    protected $message = 'Recipient already exists with the same email address';
}