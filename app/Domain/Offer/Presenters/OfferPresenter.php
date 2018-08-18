<?php

namespace App\Domain\Offer\Presenters;

use App\Domain\Offer\Transformers\OfferTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class OfferPresenter extends FractalPresenter
{

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OfferTransformer();
    }
}