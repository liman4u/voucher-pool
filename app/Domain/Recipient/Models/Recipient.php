<?php

namespace App\Domain\Recipient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipient extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email'
    ];
}