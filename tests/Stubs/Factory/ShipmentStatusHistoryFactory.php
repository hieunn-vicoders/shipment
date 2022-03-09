<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use VCComponent\Laravel\Shipment\Test\Stubs\Entities\ShipmentStatusHistory;

$factory->define(ShipmentStatusHistory::class, function (Faker $faker) {
    return [
        'status'        => rand(1, 31),
        'shipment_id'   => rand(1, 31),
    ];
});
