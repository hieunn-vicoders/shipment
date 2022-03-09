<?php

namespace VCComponent\Laravel\Shipment\Transformers;

use League\Fractal\TransformerAbstract;

class ShipmentStatusHistoryTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'status'
    ];

    public function __construct($includes = [])
    {
        $this->setDefaultIncludes($includes);
    }

    public function transform($model)
    {
        return [
            'id'            => (int) $model->id,
            'status'        => $model->status,
            'shipment_id'   => $model->shipment_id,
            'timestamps' => [
                'created_at' => $model->created_at,
                'updated_at' => $model->updated_at,
            ],
        ];
    }

    public function includeStatus($model)
    {
        if ($model->status) {
            return $this->item($model->status, new ShipmentStatusTransformer());
        }
    }    
}
