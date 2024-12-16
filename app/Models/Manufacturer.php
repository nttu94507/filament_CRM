<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Manufacturer extends Model
{
    //
    public function probe(): HasMany
    {
        return $this->HasMany(Probe::class);
    }
}
