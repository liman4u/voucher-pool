<?php

namespace App\Domain\Offer\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class OfferValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required',
            'discount'  => 'required|numeric|min:0|max:100'
        ]
    ];
}