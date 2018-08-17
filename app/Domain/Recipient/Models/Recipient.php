<?php

namespace App\Domain\Recipient\Models;

use App\Domain\Voucher\Models\Voucher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;

class Recipient extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}