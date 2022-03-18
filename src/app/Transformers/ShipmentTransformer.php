<?php

namespace VCComponent\Laravel\Shipment\Transformers;

use League\Fractal\TransformerAbstract;
use VCComponent\Laravel\Shipment\Entities\ShipmentStatus;

class ShipmentTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'histories'
    ];

    public function __construct($includes = [])
    {
        $this->setDefaultIncludes($includes);
    }

    public function transform($model)
    {
        return [
            'id'            => (int) $model->id,
            'code'          => $model->code,
            'url'           => $model->url,
            'note'          => $model->note,
            'status'        => $model->status,
            'shipmentable_id'   => (int) $model->shipmentable_id,
            'shipmentable_type' => $model->shipmentable_type,
            'timestamps' => [
                'created_at' => $model->created_at,
                'updated_at' => $model->updated_at,
            ],
        ];
    }

    public function includeHistories($model)
    {
        if ($model->histories) {
            return $this->collection($model->histories, new ShipmentStatusHistoryTransformer());
        }
    }
}
