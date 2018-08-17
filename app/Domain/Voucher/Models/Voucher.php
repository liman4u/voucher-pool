<?php

namespace App\Domain\Voucher\Models;

use App\Domain\Offer\Models\Offer;
use App\Domain\Recipient\Models\Recipient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'offer_id',
        'recipient_id',
        'expires_at',
        'used_at'
    ];

    /**
     * Belongs To relation
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * Belongs To relation
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo(Recipient::class);
    }
}