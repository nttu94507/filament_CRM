<?php

namespace App\Models;

use App\ProbeStatus;
use App\ShipmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $casts = [
        'probes' => 'array',

        'action_type' => ShipmentStatus::class,

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function shipment_items(): HasMany
    {
        return $this->hasMany(ShipmentItem::class, 'shipment_id', 'id');
    }

    //
}
