<?php

namespace VCComponent\Laravel\Shipment\Entities;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'shipment_code',
        'url',
        'note',
        'status',
        'shipmentable_id',
        'shipmentable_type',
    ];

    public function shipmentable()
    {
        return $this->morphTo();
    }

    public function histories()
    {
        return $this->hasMany(ShipmentStatusHistory::class);
    }
}
