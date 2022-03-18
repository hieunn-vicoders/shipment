<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['prefix' => 'admin'], function ($api) {
        $api->post('shipments', 'VCComponent\Laravel\Shipment\Http\Controllers\Api\Admin\ShipmentController@create');
        $api->get('shipments/statuses', 'VCComponent\Laravel\Shipment\Http\Controllers\Api\Admin\ShipmentController@getStatuses');
        $api->put('shipments/{id}', 'VCComponent\Laravel\Shipment\Http\Controllers\Api\Admin\ShipmentController@update');
        $api->get('shipments/{shipmentable_ids}', 'VCComponent\Laravel\Shipment\Http\Controllers\Api\Admin\ShipmentController@show');
        $api->put('shipments/{id}/status', 'VCComponent\Laravel\Shipment\Http\Controllers\Api\Admin\ShipmentController@updateStatus');
    });
});
