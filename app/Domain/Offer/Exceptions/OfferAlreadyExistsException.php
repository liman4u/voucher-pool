<?php

namespace App\Domain\Offer\Exceptions;


class OfferAlreadyExistsException extends \Exception
{

    protected $code = 1001;

    protected $message = 'Offer already exists with the same name';
}