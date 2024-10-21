<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $casts = [
        'price' => MoneyCast::class,

    ];
    public function probe(): BelongsTo
    {
        return $this->belongsTo(Probe::class);
    }
}
