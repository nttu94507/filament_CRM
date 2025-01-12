<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    public function probes(): HasMany
    {
        return $this->hasMany(Probe::class);
    }
    //
}
