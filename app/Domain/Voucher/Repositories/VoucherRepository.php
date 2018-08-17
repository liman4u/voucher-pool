<?php

namespace App\Domain\Voucher\Repositories;

use App\Domain\Voucher\Models\Voucher;
use Prettus\Repository\Eloquent\BaseRepository;

class VoucherRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Voucher::class;
    }
}