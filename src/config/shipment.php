<?php

return [
    'models'          => [
        'shipment' => VCComponent\Laravel\Shipment\Entities\Shipment::class,
        'shipment_status' => VCComponent\Laravel\Shipment\Entities\ShipmentStatus::class,
        'shipment_status_history' => VCComponent\Laravel\Shipment\Entities\ShipmentStatusHistory::class,
    ],

    'transformers'    => [
        'meta' => VCComponent\Laravel\Shipment\Transformers\ShipmentTransformer::class,
        'shipment_status' => VCComponent\Laravel\Shipment\Transformers\ShipmentStatusTransformer::class,
        'shipment_status_history' => VCComponent\Laravel\Shipment\Transformers\ShipmentStatusHistoryTransformer::class,
    ],

    'auth_middleware' => [
        'admin'    => [
            [
                'middleware' => '',
                'except'     => [],
            ]
        ],
    ],

];
