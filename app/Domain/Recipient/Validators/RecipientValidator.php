<?php

namespace App\Domain\Recipient\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class RecipientValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required',
            'email'  => 'required|unique:recipients,email'
        ]
    ];
}