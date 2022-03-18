<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use VCComponent\Laravel\Shipment\Test\Stubs\Entities\Shipment;

$factory->define(Shipment::class, function (Faker $faker) {
    return [
        'code'     => $faker->word,
        'url'               => $faker->url(),
        'note'              => $faker->paragraph(),
        'status'            => rand(1, 31),
        'shipmentable_id'   => rand(1, 31),
        'shipmentable_type' => $faker->word,
    ];
});
