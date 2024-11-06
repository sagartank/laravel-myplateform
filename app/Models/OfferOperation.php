<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OfferOperation extends Pivot
{
    protected $table = 'offer_operations';
    public $incrementing = true;

    protected $guarded = [];
    public $timestamps = false;
}
