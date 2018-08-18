<?php

namespace App\Domain\Offer\Transformers;

use App\Domain\Offer\Models\Offer;
use League\Fractal\TransformerAbstract;

class OfferTransformer extends TransformerAbstract
{
    public function transform(Offer $offer)
    {
        return [
            'id'      => (int) $offer->id,
            'name'   => $offer->name,
            'discount' =>  (double) $offer->discount,
        ];
    }
}