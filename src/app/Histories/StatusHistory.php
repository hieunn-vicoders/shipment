<?php

namespace VCComponent\Laravel\Shipment\Histories;

use VCComponent\Laravel\Shipment\Entities\Shipment;
use VCComponent\Laravel\Shipment\Entities\ShipmentStatusHistory;

class StatusHistory
{
    public static function record(Shipment $shipment)
    {
        return ShipmentStatusHistory::create([
            'status'        => $shipment->status,
            'shipment_id'   => $shipment->id,
        ]);
    }

    public static function tracking($code)
    {
        $shipment = Shipment::where('code', $code)->with('histories')->first();

        return $shipment->histories;
    }
}