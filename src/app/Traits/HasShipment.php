<?php

namespace VCComponent\Laravel\Shipmen\Traits;

use VCComponent\Laravel\Shipment\Entities\Shipment;

trait HasShipment 
{
    public function shipments()
    {
        if (isset(config('shipment.models')['shipment'])) {
            return $this->morphMany(config('shipment.models.shipment'), 'shipmentable');
        } else {
            return $this->morphMany(Shipment::class, 'shipmentable');
        }
    }

    protected static function bootShipmentActionableTrait()
    {
        self::deleting(function ($model) {
            $model->shipments()->delete();
        });
    }
}