<?php

namespace VCComponent\Laravel\Shipment\Test\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use VCComponent\Laravel\Shipment\Test\Stubs\Entities\Shipment;
use VCComponent\Laravel\Shipment\Test\Stubs\Entities\ShipmentStatusHistory;
use VCComponent\Laravel\Shipment\Test\TestCase;


class ShipmentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_get_shipment()
    {
        $data = factory(Shipment::class, 1)->create([
            'shipmentable_type' => 'order_item'
        ])->each(function ($item) {
            factory(ShipmentStatusHistory::class, 2)->create([
                'shipment_id' => $item->id,
            ]);
        })->map(function ($item) {
            unset($item['created_at']);
            unset($item['updated_at']);
            return $item;
        })->toArray();

        $response = $this->get("api/admin/shipments/" . implode(',', array_column($data, 'shipmentable_id')) . "?shipmentable_type=order_item");
        $response->assertSuccessful();

        $response->assertJson([
            'data' => $data
        ]);
        $response->assertJsonStructure([
            'data' => [
                [
                    'histories' => [
                        'data' => []
                    ]
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    public function can_create_shipment()
    {
        $data = factory(Shipment::class)->make([
            'shipmentable_type' => 'order_item'
        ])->toArray();

        $response = $this->post("api/admin/shipments/", $data);
        $response->assertSuccessful();
        $response->assertJson([
            'data' => $data
        ]);
    }

    /**
     * @test
     */
    public function can_update_shipment_statu()
    {
        $data = factory(Shipment::class)->create([
            'shipmentable_type' => 'order_item'
        ])->toArray();

        unset($data['created_at']);
        unset($data['updated_at']);

        $response = $this->put("api/admin/shipments/".$data['id'].'/status', ['status' => 32]);
        $response->assertSuccessful();

        $data['status'] = "32";
        
        $this->assertDatabaseHas('shipments', $data);
        $this->assertDatabaseHas('shipment_status_histories', [
            'shipment_id' => $data['id'],
            'status'    => $data['status'],
        ]);
    }

    /**
     * @test
     */
    public function can_get_shipment_statuses()
    {
        $response = $this->get("api/admin/shipments/statuses");
        $response->assertSuccessful();
        $statuses = collect(Shipment::statuses())->map(function ($item) {
            return ["name" => $item];
        })->toArray();
        $response->assertJson(['data' => $statuses]);

    }

    /**
     * @test
     */
    public function can_update_shipment()
    {
        $data = factory(Shipment::class)->create([
            'shipmentable_type' => 'order_item'
        ])->toArray();

        $shipment = factory(Shipment::class)->make([
            'shipmentable_type' => $data['shipmentable_type'],
            'shipmentable_id'   => $data['shipmentable_id'],
        ])->toArray();

        $response = $this->put("api/admin/shipments/".$data['id'], $shipment);
        $response->assertSuccessful();
        $response->assertJson(['data' => $shipment]);
        
        $this->assertDatabaseHas('shipments', $shipment);
        $this->assertDatabaseHas('shipment_status_histories', [
            'shipment_id' => $data['id'],
            'status'    => $shipment['status'],
        ]);
    }

    /**
     * @test
     */
    public function can_update_shipment_by_create_route()
    {
        $data = factory(Shipment::class)->create([
            'shipmentable_type' => 'order_item'
        ])->toArray();

        $shipment = factory(Shipment::class)->make([
            'shipmentable_type' => $data['shipmentable_type'],
            'shipmentable_id'   => $data['shipmentable_id'],
        ])->toArray();

        $response = $this->post("api/admin/shipments/", $shipment);
        $response->assertSuccessful();
        $response->assertJson(['data' => $shipment]);
        
        $this->assertDatabaseHas('shipments', $shipment);
        $this->assertDatabaseHas('shipment_status_histories', [
            'shipment_id' => $data['id'],
            'status'    => $shipment['status'],
        ]);
    }
}
