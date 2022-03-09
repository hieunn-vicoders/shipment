<?php

namespace VCComponent\Laravel\Shipment\Validators;

use VCComponent\Laravel\Vicoders\Core\Validators\AbstractValidator;

class ShipmentValidator extends AbstractValidator
{
    protected $rules = [
        'RULE_ADMIN_CREATE' => [
            'shipment_code'     => 'unique:shipments',
            'status'            => 'required',
            'shipmentable_id'   => 'required',
            'shipmentable_type' => 'required',
        ],
        'RULE_ADMIN_UPDATE_STATUS' => [
            'status'    => 'required',
        ],
        'SHOW_SHIPMENT' => [
            'shipmentable_type' => 'required',
        ]
    ];
}
