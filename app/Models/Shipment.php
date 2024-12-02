<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [];

     public function user(): BelongsTo
     {
         return $this->belongsTo(User::class, 'user_id','id');
     }

      public function customer(): BelongsTo
      {
          return $this->belongsTo(Customer::class, 'receiver_id','id');
      }
    //
}
