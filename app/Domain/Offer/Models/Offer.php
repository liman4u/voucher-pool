<?php

namespace App\Domain\Offer\Models;

use App\Domain\Voucher\Models\Voucher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;

class Offer extends Model implements Transformable
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'alias',
        'discount'
    ];


    /**
     * @return array
     */
    public function transform()
    {
        return [
            'id'      => (int) $this->id,
            'name'   => $this->name,
            'discount' => (double) $this->discount,
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }

}