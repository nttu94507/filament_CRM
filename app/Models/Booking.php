<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Psy\Util\Str;

class Booking extends Model
{
    use HasFactory, SoftDeletes;
    //
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->booking_code = strtoupper(\Illuminate\Support\Str::random(6));
        });
    }

    // 你可以保留 deleted_at 的轉型（選用）
    protected $dates = ['deleted_at'];

}
