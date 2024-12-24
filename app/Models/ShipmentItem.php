<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ShipmentItem extends Model
{
    //
    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    public function probe(): HasOne
    {
        return $this->HasOne(Probe::class);
    }
}
