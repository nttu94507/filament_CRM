<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Probe extends Model
{
    //'

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
