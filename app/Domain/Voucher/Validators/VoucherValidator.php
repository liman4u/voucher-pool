<?php

namespace App\Domain\Voucher\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class VoucherValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'offer_id' => 'required|exists:offers,id',
            'expiry_date'  => 'required|date'
        ]
    ];
}