<?php

namespace VCComponent\Laravel\Shipment\Repositories;

use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use VCComponent\Laravel\Shipment\Entities\ShipmentStatusHistory;
use VCComponent\Laravel\Shipment\Repositories\ShipmentStatusHistoryRepository;
use VCComponent\Laravel\Vicoders\Core\Exceptions\NotFoundException;

/**
 * Class AccountantRepositoryEloquent.
 */
class ShipmentStatusHistoryRepositoryEloquent extends BaseRepository implements ShipmentStatusHistoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        if (isset(config('shipment.models')['shipment_status_history'])) {
            return config('shipment.models.shipment_status_history');
        } else {
            return ShipmentStatusHistory::class;
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
            throw new NotFoundException('Shipment Status History');
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
