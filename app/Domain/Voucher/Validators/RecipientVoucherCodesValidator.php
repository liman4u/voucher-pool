<?php
/**
 * Created by PhpStorm.
 * User: liman
 * Date: 8/18/18
 * Time: 8:14 PM
 */

namespace App\Domain\Voucher\Validators;

use Prettus\Validator\LaravelValidator;

class RecipientVoucherCodesValidator extends LaravelValidator
{

    protected $rules = [
        'recipient' => [
            'email'  => 'required|exists:recipients,email'
        ]
    ];
}