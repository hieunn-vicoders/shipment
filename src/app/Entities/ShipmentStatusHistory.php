<?php 

namespace VCComponent\Laravel\Shipment\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class ShipmentStatusHistory extends Model 
{
    use Sluggable, SluggableScopeHelpers;

    protected $fillable = [
        'status',
        'shipment_id',
    ];

    public function sluggable()
    {
        return [
            'key' => [
                'source' => 'name',
            ],
        ];
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}