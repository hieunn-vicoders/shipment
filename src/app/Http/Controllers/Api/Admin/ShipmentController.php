<?php

namespace VCComponent\Laravel\Shipment\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use VCComponent\Laravel\Shipment\Entities\ShipmentStatusHistory;
use VCComponent\Laravel\Shipment\Histories\StatusHistory;
use VCComponent\Laravel\Shipment\Repositories\ShipmentRepository;
use VCComponent\Laravel\Shipment\Transformers\ShipmentTransformer;
use VCComponent\Laravel\Shipment\Validators\ShipmentValidator;
use VCComponent\Laravel\Vicoders\Core\Controllers\ApiController;

class ShipmentController extends ApiController
{   
    protected $repository;
    protected $entity;
    protected $validator;
    protected $transformer;
    
    public function __construct(ShipmentRepository $repository, ShipmentValidator $validator)
    {
        $this->repository = $repository;
        $this->entity   = $repository->getEntity();
        $this->validator = $validator;
        
        if (config('shipment.auth_middleware.admin.middleware') !== '') {
            $this->middleware(
                config('shipment.auth_middleware.admin.middleware'),
                ['except' => config('shipment.auth_middleware.admin.except')]
            );
        } else {
            throw new Exception("Admin middleware configuration is required");
        }

        if (isset(config('shipment.transformers')['shipment'])) {
            $this->transformer = config('shipment.transformers.shipment');
        } else {
            $this->transformer = ShipmentTransformer::class;
        }

        if (isset(config('shipment.model')['shipment_status_history'])) {
            $this->shipment_status_history = config('shipment.model.shipment_status_history');
        } else {
            $this->shipment_status_history = ShipmentStatusHistory::class;
        }
    }

    public function show($shipmentable_ids, Request $request)
    {
        $this->validator->isValid($request, 'SHOW_SHIPMENT');   

        $shipmentable_ids = explode(',', $shipmentable_ids);                                                                  
        $result = $this->entity                                                                         
            ->where('shipmentable_type', $request->get('shipmentable_type'))                                      
            ->whereIn('shipmentable_id', $shipmentable_ids)                                                          
            ->oldest()->get();
                                                                                                                 
        return $this->response->collection($result, new $this->transformer(['histories']));     
    }

    public function create(Request $request)
    {
        $this->validator->isValid($request, 'RULE_ADMIN_CREATE');

        $shipment = $this->entity->updateOrCreate(
            ['shipmentable_id' => $request->get('shipmentable_id'), 'shipmentable_type' => $request->get('shipmentable_type')],
            ['code' => $request->get('code'), "url" => $request->get('url'), "note" => $request->get('note'), "status" => $request->get('status')]
        );

        StatusHistory::record($shipment);

        return $this->response->item($shipment, new $this->transformer);
    }

    public function update(Request $request, $id)
    {
        $this->validator->isValid($request, 'RULE_ADMIN_UPDATE');

        $shipment = $this->repository->findById($id);

        $shipment->update([
            'code' => $request->get('code'),
            'url' => $request->get('url'),
            'note' => $request->get('note'),
            'status' => $request->get('status'),
        ]);

        StatusHistory::record($shipment);

        return $this->response->item($shipment, new $this->transformer);
    }

    public function updateStatus($id, Request $request)
    {
        $this->validator->isValid($request, 'RULE_ADMIN_UPDATE_STATUS');

        $shipment = $this->repository->findById($id);

        $shipment->status = $request->get('status');

        $shipment->save();

        StatusHistory::record($shipment);

        return $this->success();
    }

    public function getStatuses()
    {
        $statuses = collect($this->entity::statuses())->map(function ($item, $key) {
            return [
                "name" => $item
            ];
        })->toArray();

        return response()->json(["data" => $statuses]);
    }
}