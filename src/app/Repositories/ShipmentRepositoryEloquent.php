<?php

namespace VCComponent\Laravel\Shipment\Repositories;

use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use VCComponent\Laravel\Shipment\Entities\Shipment;
use VCComponent\Laravel\Shipment\Repositories\ShipmentRepository;
use VCComponent\Laravel\Vicoders\Core\Exceptions\NotFoundException;

/**
 * Class AccountantRepositoryEloquent.
 */
class ShipmentRepositoryEloquent extends BaseRepository implements ShipmentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        if (isset(config('shipment.models')['shipment'])) {
            return config('shipment.models.shipment');
        } else {
            return Shipment::class;
        }
    }

    public function getEntity()
    {
        return $this->model;
    }

    public function findById($id)
    {
        $shipment = $this->find($id);
        if (!$shipment) {
            throw new NotFoundException('Shipment');
        }
        return $shipment;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
