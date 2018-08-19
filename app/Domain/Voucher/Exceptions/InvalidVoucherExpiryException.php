<?php

namespace App\Domain\Voucher\Exceptions;


class InvalidVoucherExpiryException extends \Exception
{

    protected $message = 'Invalid voucher expiry date,date can not be in the past';
}