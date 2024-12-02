<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    //
    public function probes(): HasMany
    {
        return $this->hasMany(Probe::class);
    }

    public function shipment(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }
}
