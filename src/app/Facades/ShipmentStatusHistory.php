<?php

namespace VCComponent\Laravel\Shipment\Facades;

use Illuminate\Support\Facades\Facade;

class ShipmentStatusHistory extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shipment_status_history';
    }
}
