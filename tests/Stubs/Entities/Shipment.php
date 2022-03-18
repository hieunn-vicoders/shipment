<?php

namespace VCComponent\Laravel\Shipment\Test\Stubs\Entities;

use VCComponent\Laravel\Shipment\Entities\Shipment as BaseEntity;

class Shipment extends BaseEntity
{
    
    public static function statuses()
    {
        return [
            'Xác nhận đơn hàng',
            'Hàng nhập kho UK',
            'Đang vận chuyển',
            'Hàng đã về Việt Nam',
            'Giao hàng thành công',
        ];
    }
}
