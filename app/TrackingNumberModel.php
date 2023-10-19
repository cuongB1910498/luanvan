<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackingNumberModel extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id_tracking',
        'address_sent',
        'province_sent',
        'district_sent',
        'name_sent',
        'phone_sent',
        'address_receive',
        'district_receive',
        'province_receive',
        'name_receive',
        'phone_receive',
        'img_receive',
        'type_sending',
        'describe_tracking',
        'demension',
        'weight',
        'tracking_price',
        'cod',
        'id_extra_service',
        'id_user',
        'id_status',
        'id_bag',
        'tracking_return',
        'tracking_created_at',
        'tracking_updated_at',
    ];
    protected $primaryKey = 'id_tracking';
    protected $table = 'tbl_tracking_number';
}
