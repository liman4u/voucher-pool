<?php

namespace App\Domain\Recipient\Presenters;

use App\Domain\Recipient\Transformers\RecipientTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class RecipientPresenter extends FractalPresenter
{

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RecipientTransformer();
    }
}