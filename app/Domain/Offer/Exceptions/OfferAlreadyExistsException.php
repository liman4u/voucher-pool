<?php

namespace App\Domain\Offer\Exceptions;


class OfferAlreadyExistsException extends \Exception
{

    protected $message = 'Offer already exists with the same name';
}