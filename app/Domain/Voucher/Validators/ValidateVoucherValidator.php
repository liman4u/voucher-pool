<?php
/**
 * Created by PhpStorm.
 * User: liman
 * Date: 8/18/18
 * Time: 8:14 PM
 */

namespace App\Domain\Voucher\Validators;

use Prettus\Validator\LaravelValidator;

class ValidateVoucherValidator extends LaravelValidator
{

    protected $rules = [
        'validate' => [
            'code' => 'required|exists:vouchers,code',
            'email'  => 'required|exists:recipients,email'
        ]
    ];
}