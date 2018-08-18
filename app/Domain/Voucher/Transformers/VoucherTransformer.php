<?php

namespace App\Domain\Voucher\Transformers;

use App\Domain\Voucher\Models\Voucher;
use League\Fractal\TransformerAbstract;

class VoucherTransformer extends TransformerAbstract
{
    public function transform(Voucher $voucher)
    {
        return [
            'id'      => (int) $voucher->id,
            'code'   => $voucher->code,
            'expires_at' =>  $voucher->expires_at->format('Y-m-d H:i:s'),
            'used_at' =>  $voucher->used_at ? $voucher->used_at->format('Y-m-d H:i:s') : ''
        ];
    }
}