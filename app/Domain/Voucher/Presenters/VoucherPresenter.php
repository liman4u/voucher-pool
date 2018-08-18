<?php

namespace App\Domain\Voucher\Presenters;

use App\Domain\Voucher\Transformers\VoucherTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class VoucherPresenter extends FractalPresenter
{

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new VoucherTransformer();
    }
}