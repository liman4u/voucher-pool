<?php

namespace App\Domain\Recipient\Transformers;

use App\Domain\Recipient\Models\Recipient;
use League\Fractal\TransformerAbstract;

class RecipientTransformer extends TransformerAbstract
{
    public function transform(Recipient $recipient)
    {
        return [
            'id'      => (int) $recipient->id,
            'name'   => $recipient->name,
            'discount' => (double) $recipient->discount,
        ];
    }
}